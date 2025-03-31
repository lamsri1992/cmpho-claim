<?php

namespace App\Http\Controllers\Creditor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Auth;

class transaction extends Controller
{
    public function index()
    {
        $hcode = Auth::user()->hcode;
        $data = DB::table('transactions')
            ->leftjoin('trans_status','t_id','transactions.trans_status')
            ->where('trans_hcode',$hcode)
            ->get();
        return view('creditor.ct.transaction.index',['data' => $data]);
    }

    public function view($id)
    {
        $hcode = Auth::user()->hcode;
        $data = DB::table('ct_list')
            ->leftjoin('hospital','hospital.h_code','ct_list.hcode')
            ->where('transaction',$id)
            ->where('hospmain',$hcode)
            ->get();

        $trans = DB::table('transactions')
            ->where('trans_code',$id)
            ->first();
        return view('creditor.ct.transaction.view',['data' => $data,'trans' => $trans,'id'=>$id]);
    }

    public function upload(Request $request, $id)
    {
        $hcode = Auth::user()->hcode;
        $currentDate = date('Y-m-d H:i:s');
        $validatedData = $request->validate(
            [
                'file' => 'required|mimes:pdf',
            ],
            [
                'file.required' => 'กรุณาแนบไฟล์',
            ],
        );
        $fileName = $id.'.'.$request->file->extension();  
        $request->file->move(public_path('uploads/paid'), $fileName);

        DB::table('transactions')->where('trans_code',$id)->update([
            'trans_file' => $fileName,
            'trans_upload' => $currentDate,
            'trans_status' => 2
        ]);

        DB::table('ct_list')->where('transaction',$id)->update([
            'ct_status' => 8,
            'trans_date' => $currentDate,
        ]);

        return redirect()->route('transaction.index')->with('success','อัพโหลดไฟล์เอกสารสำเร็จ '.$fileName);
    }
}
