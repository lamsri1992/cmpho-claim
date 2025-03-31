<?php

namespace App\Http\Controllers\Cmpho;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Auth;

class dataController extends Controller
{
    public function index()
    {
        $opae = DB::table('claim_list')->where('p_status',2)->count();
        $sopae = DB::table('claim_list')->where('p_status',8)->count();
        $ctmri = DB::table('ct_list')->where('ct_status',2)->count();
        $sctmri = DB::table('ct_list')->where('ct_status',8)->count();
        return view('cmpho.dashboard',
            [
                'opae' => $opae,
                'sopae' => $sopae,
                'ctmri' => $ctmri,
                'sctmri' => $sctmri,
            ]
        );
    }

    public function opae()
    {
        $sql = "SELECT DISTINCT(claim_list.hcode),hospital.h_name,COUNT(claim_list.trans_code) AS total
                FROM claim_list
                LEFT JOIN hospital ON hospital.h_code = claim_list.hcode
                WHERE p_status = '2'
                GROUP BY claim_list.hcode,hospital.h_name,claim_list.trans_code";
        $data = DB::select($sql);
        return view('cmpho.opae.index',['data'=>$data]);
    }

    public function ctmri()
    {
        $sql = "SELECT DISTINCT(ct_list.hcode),hospital.h_name,COUNT(ct_list.trans_code) AS total
                FROM ct_list
                LEFT JOIN hospital ON hospital.h_code = ct_list.hcode
                WHERE ct_status = '2'
                GROUP BY ct_list.hcode,hospital.h_name,ct_list.trans_code";
        $data = DB::select($sql);
        return view('cmpho.ctmri.index',['data'=>$data]);
    }

    public function processOpae()
    {
        $currentDate = date('Y-m-d');
        $hcode = Auth::user()->hcode;

        DB::table('claim_list')
            ->where('p_status',2)
            ->whereNotNull('trans_code')
            ->update(
                [
                    'p_status' => 3,
                    'process_date' => $currentDate
                ]
            );
    }

    public function processCtmri()
    {
        $currentDate = date('Y-m-d');
        $hcode = Auth::user()->hcode;

        DB::table('ct_list')
            ->where('ct_status',2)
            ->whereNotNull('trans_code')
            ->update(
                [
                    'ct_status' => 3,
                    'process_date' => $currentDate
                ]
            );
    }

    public function reportOpae(Request $request)
    {
        $year = $request->year - 543;
        $sql = "SELECT claim_list.hcode,hospital_a.h_name AS visit_hospital,
                claim_list.hospmain,hospital_b.h_name AS main_hospital,
                COUNT(claim_list.vn) AS cases,
                SUM(total) AS total,
                SUM(nhso_cost * claim_list.num) AS nh_cost,
                SUM(rate * claim_list.num) AS d_cost
                FROM claim_list
                INNER JOIN hospital as hospital_a ON hospital_a.h_code = claim_list.hcode
                INNER JOIN hospital as hospital_b ON hospital_b.h_code = claim_list.hospmain
                LEFT JOIN nhso nh ON nh.nhso_code = claim_list.fs_code
                LEFT JOIN drug d ON d.tid = claim_list.fs_code
                WHERE claim_list.p_status NOT IN (1,2)
                AND MONTH(claim_list.process_date) = $request->month
                AND YEAR(claim_list.process_date) = $year
                GROUP BY claim_list.trans_code,claim_list.hcode,claim_list.hospmain,hospital_a.h_name,hospital_b.h_name
                ORDER BY hospital_a.h_code,hospital_b.h_code ASC";
        $data = DB::select($sql);
        $month = $request->month;
        $years = $request->year;
        return view('cmpho.opae.report',['data'=>$data,'month'=>$month,'years'=>$years]);
    }

}
