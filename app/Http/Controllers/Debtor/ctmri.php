<?php

namespace App\Http\Controllers\Debtor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\CtmriImport;
use Illuminate\Support\Str;
use DB;
use Auth;
use File;

class ctmri extends Controller
{
    public function index()
    {
        $hcode = Auth::user()->hcode;
        $count = DB::table('ct_list')->where('hcode',$hcode)->count();
        $process = DB::table('ct_list')->where('hcode',$hcode)->where('ct_status',1)->count();
        $deny = DB::table('ct_list')->where('hcode',$hcode)->where('ct_status',5)->count();
        $ct_cash = DB::table('ct_list')->select(DB::raw('SUM(total_cash) as total'))->where('hcode',$hcode)->first();
        $ct_total = DB::table('ct_list')->select(DB::raw('SUM(total_payment + total_contrast) as total'))->where('hcode',$hcode)->first();
        $creditor = DB::table('ct_list')
            ->select('hcode','h_name',DB::raw('SUM(total_payment + total_contrast) AS paid'))
            ->join('hospital','hospital.h_code','ct_list.hcode')
            ->where('hospmain','=',$hcode)
            ->groupBy('hcode','h_name')
            ->get();
        $debtor = DB::table('ct_list')
            ->select('hcode','h_name',DB::raw('SUM(total_payment + total_contrast) AS paid'))
            ->join('hospital','hospital.h_code','ct_list.hospmain')
            ->where('hcode','=',$hcode)
            ->groupBy('hcode','h_name')
            ->get();
        $hos = DB::table('hospital')->get();

        return view('ctmri.index',
        [
            'count'=>$count,
            'process'=>$process,
            'ct_cash'=>$ct_cash,
            'ct_total'=>$ct_total,
            'deny'=>$deny,
            'creditor'=>$creditor,
            'debtor'=>$debtor,
            'hos'=>$hos,
        ]);
    }

    public function import(Request $request) 
    {
        $hcode = Auth::user()->hcode;
        $validatedData = $request->validate(
            [
                'file' => 'required|max:2048|mimes:xls,xlsx',
            ],
            [
                'file.required' => 'กรุณาแนบไฟล์',
            ],
        );
  
        Excel::import(new CtmriImport, $request->file('file'));
        $file  = $request->file('file');
        $fileName = $hcode."_".date('Ymdhis').".xls";
        $destination = public_path('uploads/ctmri/');

        File::makeDirectory($destination, 0755, true, true);
        $file->move(public_path('uploads/ctmri/'), $fileName);

        DB::table('import_log')->insert(
            [
                'ex_file' => $fileName,
                'import_date' => date("Y-m-d"),
                'hcode' => $hcode,
                'type' => 'CT - MRI',
            ]
        );

        return redirect()->route('ctmri.list')->with('success', 'นำเข้าข้อมูลสำเร็จ');
    }

    public function list()
    {
        $hcode = Auth::user()->hcode;
        $data = DB::table('ct_list')
            ->leftjoin('hospital','hospital.h_code','ct_list.hospmain')
            ->leftjoin('p_status','p_status.id','ct_list.ct_status')
            ->where('ct_status', 1)
            ->where('hcode',$hcode)
            ->orderby('ct_list.visitdate','asc')
            ->get();
        return view('ctmri.list',['data'=>$data]);
    }

    public function search(Request $request)
    {
        $hcode = Auth::user()->hcode;
        $hos = DB::table('hospital')->get();
        if($request->hos != 0){
            $data = DB::table('ct_list')
                ->leftjoin('hospital','hospital.h_code','ct_list.hospmain')
                ->leftjoin('p_status','p_status.id','ct_list.ct_status')
                ->where('hcode',$hcode)
                ->where('hospmain',$request->hos)
                ->whereBetween('ct_list.visitdate', [$request->dstart, $request->dend])
                ->orderby('ct_list.visitdate','asc')
                ->get();
        }else{
            $data = DB::table('ct_list')
                ->leftjoin('hospital','hospital.h_code','ct_list.hospmain')
                ->leftjoin('p_status','p_status.id','ct_list.ct_status')
                ->where('hcode',$hcode)
                ->whereBetween('ct_list.visitdate', [$request->dstart, $request->dend])
                ->orderby('ct_list.visitdate','asc')
                ->get();
        }

        return view('ctmri.search',
            [
                'data'=>$data,
                'hos'=>$hos,
            ]
        );
    }

    public function send()
    {
        $currentDate = date('Y-m-d');
        $hcode = Auth::user()->hcode;
        $transCode = 'CTMRI'.$hcode.date('Ym').substr(rand(),1,5);

        DB::table('ct_list')
            ->where('hcode',$hcode)
            ->whereNull('trans_code')
            ->update(
                [
                    'trans_code' => $transCode,
                    'ct_status' => 2,
                    'updated_at' => $currentDate
                ]
            );
    }

    public function hospital()
    {
        $hcode = Auth::user()->hcode;
        $data = DB::table('ct_list')
                ->select(DB::raw('COUNT(DISTINCT uuid) AS num,SUM(total_payment) AS total_p,SUM(total_contrast) AS total_c'),'hospmain','h_name',)
                ->join('hospital','h_code','ct_list.hospmain')
                ->where('hcode','=',$hcode)
                // ->where('ct_status',3)
                ->whereRaw('MONTH(process_date) = MONTH(CURDATE())')
                ->whereRaw('YEAR(process_date) = YEAR(CURDATE())')
                ->groupBy('hospmain','h_name')
                ->get();
        return view('ctmri.hospital',
        [
            'data'=>$data
        ]);
    }

    public function hospitalSearch(Request $request)
    {
        $hcode = Auth::user()->hcode;
        $year = $request->year - 543;
        $data = DB::table('ct_list')
                ->select(DB::raw('COUNT(DISTINCT uuid) AS num,SUM(total_payment) AS total_p,SUM(total_contrast) AS total_c'),'hospmain','h_name',)
                ->join('hospital','h_code','ct_list.hospmain')
                ->where('hcode','=',$hcode)
                // ->where('ct_status',3)
                ->whereRaw('MONTH(process_date) = '.$request->month.'')
                ->whereRaw('YEAR(process_date) = '.$year.'')
                ->groupBy('hospmain','h_name')
                ->get();
        return view('ctmri.hospitalMonth',
        [
            'data'=>$data
        ]);
    }

    public function hospitalList(string $id,$month)
    {
        $hcode = Auth::user()->hcode;
        $data = DB::table('ct_list')
            // ->select(DB::raw('hn , SUM(total_payment + total_contrast) as total'),'visitdate','cid','p_name','hospmain','h_name')
            ->leftjoin('hospital','hospital.h_code','ct_list.hospmain')
            ->leftjoin('p_status','p_status.id','ct_list.ct_status')
            ->where('hcode',$hcode)
            ->where('hospmain',$id)
            ->whereRaw('MONTH(process_date) = '.$month.'')
            // ->where('ct_status',3)
            // ->groupby('hn','visitdate','cid','p_name','hospmain','h_name')
            ->get();
        return view('ctmri.hospitalList',
        [
            'data'=>$data,
            'id'=>$id
        ]);
    }
}
