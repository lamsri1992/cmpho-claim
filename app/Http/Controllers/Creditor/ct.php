<?php

namespace App\Http\Controllers\Creditor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Auth;

class ct extends Controller
{
    public function index()
    {
        $hcode = Auth::user()->hcode;
        $count = DB::table('ct_list')->where('hospmain',$hcode)->count();
        $list = DB::table('ct_list')->where('hospmain',$hcode)->where('ct_status',3)->count();
        $confirm = DB::table('ct_list')->where('hospmain',$hcode)->whereIn('ct_status',[4,7,8])->count();
        $deny = DB::table('ct_list')->where('hospmain',$hcode)->where('ct_status',5)->count();
        $ct_cash = DB::table('ct_list')->select(DB::raw('SUM(total_payment) as t_pay , SUM(total_contrast) as t_con'))->where('hospmain',$hcode)->first();
        $creditor = DB::table('ct_list')
            ->select('hcode','h_name',DB::raw('SUM(total_payment) as t_pay , SUM(total_contrast) as t_con'))
            ->join('hospital','hospital.h_code','ct_list.hcode')
            ->where('hospmain','=',$hcode)
            ->groupBy('hcode','h_name')
            ->get();
        return view('creditor.ct.index',
        [
            'count'=>$count,
            'list'=>$list,
            'confirm'=>$confirm,
            'deny'=>$deny,
            'ct_cash'=>$ct_cash,
            'creditor'=>$creditor,
        ]);
    }

    public function hospital()
    {
        $hcode = Auth::user()->hcode;
        $query = "SELECT hcode,h_name,COUNT(*) AS `count`,SUM(total_payment) AS t_pay,SUM(total_contrast) AS t_con,trans_code
                    FROM ct_list cl
                    INNER JOIN hospital h ON h.h_code = cl.hcode
                    WHERE cl.hospmain = $hcode
                    AND MONTH(cl.process_date) = MONTH(CURDATE())
                    AND YEAR(cl.process_date) = YEAR(CURDATE())
                    GROUP BY cl.hcode,cl.trans_code";
        $data = DB::select($query);
        return view('creditor.ct.hospital',['data'=>$data]);
    }

    public function hospital_view($id)
    {
        $hcode = Auth::user()->hcode;
        $data = DB::table('ct_list')
                ->join('hospital','hospital.h_code','ct_list.hcode')
                ->where('trans_code',$id)
                ->where('hospmain',$hcode)
                ->get();
        $check = DB::table('transactions')->where('trans_ref',$id)->count();
        return view('creditor.ct.view',['data'=>$data,'id'=>$id,'check'=>$check]);
    }

    public function list($id)
    {
        $hcode = Auth::user()->hcode;
        if($id == 'process'){ 
            $data = DB::table('ct_list')
            ->leftjoin('hospital','hospital.h_code','ct_list.hcode')
            ->leftjoin('p_status','p_status.id','ct_list.ct_status')
            ->whereIn('ct_status', [3])
            ->where('hospmain',$hcode)
            ->orderby('ct_list.visitdate','asc')
            ->get();
        }
        if($id == 'confirm'){
            $data = DB::table('ct_list')
            ->leftjoin('hospital','hospital.h_code','ct_list.hcode')
            ->leftjoin('p_status','p_status.id','ct_list.ct_status')
            ->whereIn('ct_status', [4,7,8])
            ->where('hospmain',$hcode)
            ->orderby('ct_list.visitdate','asc')
            ->get();
        }
        if($id == 'deny'){
            $data = DB::table('ct_list')
            ->leftjoin('hospital','hospital.h_code','ct_list.hcode')
            ->leftjoin('p_status','p_status.id','ct_list.ct_status')
            ->whereIn('ct_status', [5])
            ->where('hospmain',$hcode)
            ->orderby('ct_list.visitdate','asc')
            ->get();
        }
        return view('creditor.ct.list',['data'=>$data]);
    }

    public function list_confirm(string $id,$ct_status)
    {
        $hcode = Auth::user()->hcode;
        $currentDate = date('Y-m-d H:i:s');
        if($ct_status == 4){
            $text = 'ยืนยันจ่ายรายการสำเร็จ';
        }else{
            $text = 'ยืนยันปฏิเสธจ่ายรายการสำเร็จ';
        }

        DB::table('ct_list')->where('uuid',$id)->update(
            [
                'ct_status' => $ct_status,
                'confirm_date' => $currentDate,
            ]
        );

        return back()->with('success',$text);
    }

    public function transaction_create(Request $request)
    {
        $hcode = Auth::user()->hcode;
        $currentDate = date('Y-m-d H:i:s');
        $transaction = 'BILL'.$hcode.date('Ym').substr(rand(),1,5);
        $data = DB::select(
            "SELECT SUM(total_payment) as total_p ,SUM(total_contrast) as total_c,COUNT(*) AS num,hcode
                FROM `ct_list`
                WHERE hospmain = '$hcode'
                AND `ct_list`.`trans_code` = '$request->tcode'
                AND `ct_list`.`transaction` IS NULL
                GROUP BY total_payment,total_contrast,hcode");

        DB::table('transactions')->insert(
            [
                'trans_hcode' => $hcode,
                'trans_hospmain' => $data[0]->hcode,
                'trans_code' => $transaction,
                'trans_ref' => $request->tcode,
                'trans_num' => $data[0]->num,
                'trans_payment' => $data[0]->total_p,
                'trans_contrast' => $data[0]->total_c,
                'trans_create' => $currentDate
            ]
        );
        DB::table('ct_list')
            ->where('hospmain',$hcode)
            ->whereNull('transaction')
            ->update(
            [
                'transaction' => $transaction,
                'ct_status' => 7,
                'trans_date' => $currentDate
            ]
        );
    }
}
