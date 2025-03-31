<?php

namespace App\Http\Controllers\Cmpho;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Auth;
use Hash;

class configController extends Controller
{
    public function hospital()
    {
        $data = DB::table('hospital')
            ->leftjoin('hospital_type','hospital_type.h_type_id','hospital.h_type')
            ->get();
        $type = DB::table('hospital_type')->get();
        return view('cmpho.config.hospital',['data'=>$data,'type'=>$type]);
    }

    public function hospitalCreate(Request $request)
    {
        $validatedData = $request->validate(
            [
                'h_code' => 'required',
                'h_name' => 'required',
                'h_type' => 'required',

            ],
            [
                'h_code.required' => 'ระบุรหัสหน่วยบริการ',
                'h_name.required' => 'ระบุชื่อหน่วยบริการ',
                'h_type.required' => 'ระบุประเภทหน่วยบริการ',
            ],
        );
        DB::table('hospital')->insert(
            [
                'h_code' => $request->h_code,
                'h_name' => $request->h_name,
                'h_type' => $request->h_type,
            ]
        );
        return back()->with('success','เพิ่ม '.$request->h_name. ' สำเร็จ');
    }

    public function users()
    {
        $data = DB::table('users')
            ->leftjoin('hospital','hospital.h_code','users.hcode')
            ->leftjoin('hospital_type','hospital_type.h_type_id','hospital.h_type')
            ->get();
        $hosp = DB::table('hospital')->get();
        return view('cmpho.config.user',['data'=>$data,'hosp'=>$hosp]);
    }

    public function userCreate(Request $request)
    {
        $validatedData = $request->validate(
            [
                'name' => 'required',
                'email' => 'required',
                'hcode' => 'required',

            ],
            [
                'name.required' => 'ระบุชื่อผู้ใช้งาน',
                'email.required' => 'ระบุ Username',
                'hcode.required' => 'ระบุหน่วยบริการ',
            ],
        );
        DB::table('users')->insert(
            [
                'name' => $request->name,
                'email' => $request->email,
                'hcode' => $request->hcode,
                'password' => Hash::make('12345'),
            ]
        );
        return back()->with('success','เพิ่ม '.$request->name. ' สำเร็จ');
    }

}
