<?php

namespace App\Http\Controllers\Creditor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Auth;

class creditor extends Controller
{
    public function index()
    {
        $hcode = Auth::user()->hcode;
        $data = DB::table('claim_list')
            ->select('uuid','claim_id','vn','visitdate','hospmain','h_code','name','hn','h_name',
            'icd10','fs_code','total','nhso_code','nhso_name','nhso_unit','nhso_cost','p_name','p_icon','p_text_color')
            ->leftjoin('nhso','nhso.nhso_code','claim_list.fs_code')
            ->leftjoin('hospital','hospital.h_code','claim_list.hcode')
            ->leftjoin('p_status','p_status.id','claim_list.p_status')
            ->where('hospmain',$hcode)
            ->where('p_status',3)
            ->orderby('claim_id','desc')
            ->get();
        return view('creditor.index',['data'=>$data]);
    }
    
    public function hospital()
    {
        $hcode = Auth::user()->hcode;
        $query = "SELECT hcode,h_name,COUNT(vn) AS `count`,
                SUM(total) AS total,SUM(nhso_cost * cl.num) AS nh_cost,SUM(rate * cl.num) AS d_cost
                FROM claim_list cl
                INNER JOIN hospital h ON h.h_code = cl.hcode
                LEFT JOIN nhso nh ON nh.nhso_code = cl.fs_code
                LEFT JOIN drug d ON d.tid = cl.fs_code
                WHERE cl.hospmain = $hcode
                -- AND cl.p_status = 3
                AND MONTH(cl.process_date) = MONTH(CURDATE())
                AND YEAR(cl.process_date) = YEAR(CURDATE())
                GROUP BY cl.hcode";

        $data = DB::select($query);
        return view('creditor.hospital',['data'=>$data]);
    }

    public function hospitalSearch(Request $request)
    {
        $hcode = Auth::user()->hcode;
        $year = $request->year - 543;
        $query = "SELECT hcode,h_name,COUNT(vn) AS `count`,
                SUM(total) AS total,SUM(nhso_cost * cl.num) AS nh_cost,SUM(rate * cl.num) AS d_cost
                FROM claim_list cl
                INNER JOIN hospital h ON h.h_code = cl.hcode
                LEFT JOIN nhso nh ON nh.nhso_code = cl.fs_code
                LEFT JOIN drug d ON d.tid = cl.fs_code
                WHERE cl.hospmain = $hcode
                -- AND cl.p_status = 3
                AND MONTH(process_date) = $request->month
                AND YEAR(process_date) = $year
                GROUP BY cl.hcode";

        $data = DB::select($query);
        return view('creditor.hospitalMonth',['data'=>$data]);
    }

    public function hospitalList(string $id,$month)
    {
        $hcode = Auth::user()->hcode;
        $data = DB::table('claim_list')
            ->select(DB::raw('
            DISTINCT vn,
            COUNT(vn) AS cases,
            SUM(CASE WHEN claim_list.p_status = 3 THEN 1 ELSE 0 END) AS in_progress,
            SUM(total) as total,
            SUM(nhso_cost * num) AS nh_cost,
            SUM(rate * num) AS d_cost'),
            'visitdate','person_id','name','hcode','h_name')
            ->leftjoin('hospital','hospital.h_code','claim_list.hcode')
            ->leftjoin('nhso','nhso.nhso_code','claim_list.fs_code')
            ->leftjoin('drug','drug.tid','claim_list.fs_code')
            // ->join('p_status','p_status.id','claim_list.p_status')
            ->where('hcode',$id)
            ->where('hospmain',$hcode)
            ->whereRaw('MONTH(process_date) = '.$month.'')
            // ->where('p_status',3)
            ->groupby('vn','visitdate','person_id','name','hcode','h_name')
            ->get();
        // echo $data;
        return view('creditor.hospitalList',['data'=>$data,'id'=>$id]);
    }

    public function vn(string $id)
    {
        $hcode = Auth::user()->hcode;
        $data = DB::table('claim_list')
            ->select('vn','visitdate','hospmain','hcode','name','hn','p_status',
            'h_name','auth_code','person_id','age','sex_name','sex_icon','pd_date')
            ->leftjoin('hospital','hospital.h_code','claim_list.hospmain')
            ->leftjoin('sex_type','sex_type.sex_id','claim_list.sex')
            ->where('vn', $id)
            ->where('hospmain', $hcode)
            ->first();

        $list = DB::table('claim_list')
            ->leftjoin('nhso','nhso.nhso_code','claim_list.fs_code')
            ->leftjoin('drug','drug.tid','claim_list.fs_code')
            ->leftjoin('hospital','hospital.h_code','claim_list.hospmain')
            ->join('p_status','p_status.id','claim_list.p_status')
            ->where('vn', $id)
            ->where('hospmain', $hcode)
            ->get();
        return view('creditor.vn',
            [
                'data'=>$data,
                'list'=>$list,
            ]
        );
    }

    public function paid_status(Request $request)
    {
        $currentDate = date('Y-m-d H:i:s');
        DB::table('claim_list')->where('vn',$request->vn)->where('p_status',3)->update(
            [
                "p_status" => $request->stat,
                "pd_date" => $currentDate
                
            ]
        );
    }

    public function confirm_list()
    {
        $hcode = Auth::user()->hcode;
        $query = "SELECT hcode,h_name,COUNT(vn) AS `count`,
                SUM(total) AS total,SUM(nhso_cost * cl.num) AS nh_cost,SUM(rate * cl.num) AS d_cost
                FROM claim_list cl
                INNER JOIN hospital h ON h.h_code = cl.hcode
                LEFT JOIN nhso nh ON nh.nhso_code = cl.fs_code
                LEFT JOIN drug d ON d.tid = cl.fs_code
                WHERE cl.hospmain = $hcode
                AND cl.p_status = 4
                GROUP BY cl.hcode";

        $data = DB::select($query);
        return view('creditor.confirm',['data'=>$data]);
    }

    public function confirm($id)
    {
        $currentDate = date('Y-m-d H:i:s');
        $data = DB::table('claim_list')->where('uuid',$id)->update(
            [
                "p_status" => 4,
                "updated_at" => $currentDate
                
            ]
        );
        return back()->with('success','ยืนยันจ่ายรายการแล้ว');
    }
    
    public function deny(Request $request,string $id)
    {
        $sweetalertValue = $request->input('sweetalert_value');
        $currentDate = date('Y-m-d H:i:s');
        $data = DB::table('claim_list')->where('uuid',$id)->update(
            [
                "p_status" => 5,
                "deny_note" => $sweetalertValue,
                "updated_at" => $currentDate,
                
            ]
        );
        return back()->with('success','ปฏิเสธจ่ายรายการแล้ว');
    }

}
