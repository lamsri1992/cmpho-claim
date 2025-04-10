<?php

namespace App\Http\Controllers\Debtor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ClaimImport;
use Illuminate\Support\Str;
use DB;
use Auth;
use File;

class debtor extends Controller
{
    public function index()
    {
        $hcode = Auth::user()->hcode;
        $sum_debtor = DB::table('claim_list')
                ->select(DB::raw('SUM(total) as total'))
                ->where('hcode',$hcode)
                ->first();
        $count_check = DB::table('claim_list')->where('hcode',$hcode)->where('p_status',1)->count();
        $count_sents = DB::table('claim_list')->where('hcode',$hcode)->whereIn('p_status', [2, 3, 4, 7])->count();
        $count_deny = DB::table('claim_list')->where('hcode',$hcode)->where('p_status', 5)->count();
        $history = DB::table('import_log')->where('hcode',$hcode)->get();

        return view('debtor.index',
        [
            'sum_debtor'=>$sum_debtor,
            'count_check'=>$count_check,
            'count_sents'=>$count_sents,
            'count_deny'=>$count_deny,
            'history'=>$history,
        ]);
    }

    public function hospital()
    {
        $hcode = Auth::user()->hcode;
        $query = "SELECT hospmain,h_name,COUNT(vn) AS `count`,
                    SUM(total) AS total,SUM(nhso_cost * cl.num) AS nh_cost,SUM(rate * cl.num) AS d_cost
                    FROM claim_list cl
                    INNER JOIN hospital h ON h.h_code = cl.hospmain
                    LEFT JOIN nhso nh ON nh.nhso_code = cl.fs_code
                    LEFT JOIN drug d ON d.tid = cl.fs_code
                    WHERE cl.hcode = $hcode
                    AND cl.p_status = 3
                    AND MONTH(cl.process_date) = MONTH(CURDATE())
                    AND YEAR(cl.process_date) = YEAR(CURDATE())
                    GROUP BY cl.hospmain";

        $data = DB::select($query);
        return view('debtor.hospital',['data'=>$data]);
    }

    public function hospitalSearch(Request $request)
    {
        $hcode = Auth::user()->hcode;
        $year = $request->year - 543;
        $query = "SELECT hospmain,h_name,COUNT(vn) AS `count`,
                    SUM(total) AS total,SUM(nhso_cost * cl.num) AS nh_cost,SUM(rate * cl.num) AS d_cost
                    FROM claim_list cl
                    INNER JOIN hospital h ON h.h_code = cl.hospmain
                    LEFT JOIN nhso nh ON nh.nhso_code = cl.fs_code
                    LEFT JOIN drug d ON d.tid = cl.fs_code
                    WHERE cl.hcode = $hcode
                    AND cl.p_status = 3
                    AND MONTH(process_date) = $request->month
                    AND YEAR(process_date) = $year
                    GROUP BY cl.hospmain";

        $data = DB::select($query);
        return view('debtor.hospitalMonth',['data'=>$data]);
    }

    public function hospitalList(string $id,$month)
    {
        $hcode = Auth::user()->hcode;
        $data = DB::table('claim_list')
            ->select(DB::raw('DISTINCT vn ,COUNT(vn) AS cases,
            SUM(total) as total,
            SUM(nhso_cost * num) AS nh_cost,
            SUM(rate * num) AS d_cost'),
            'visitdate','person_id','name','hospmain','h_name','p_name','p_color')
            ->leftjoin('hospital','hospital.h_code','claim_list.hospmain')
            ->leftjoin('nhso','nhso.nhso_code','claim_list.fs_code')
            ->leftjoin('drug','drug.tid','claim_list.fs_code')
            ->join('p_status','p_status.id','claim_list.p_status')
            ->where('hcode',$hcode)
            ->where('hospmain',$id)
            ->whereRaw('MONTH(process_date) = '.$month.'')
            // ->where('p_status',3)
            ->groupby('vn','visitdate','person_id','name','hospmain','h_name','p_name','p_color')
            ->get();
        return view('debtor.hospitalList',['data'=>$data,'id'=>$id]);
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
        
        $import = new ClaimImport();

        try {
            Excel::import($import, $request->file('file'));

            $duplicateVns = $import->getDuplicateVns();

            if (!empty($duplicateVns)) {
                $message = 'ไม่สามารถนำเข้ารหัส VN ต่อไปนี้ได้เนื่องจากมีอยู่ในระบบแล้ว : ' . implode(', ', array_unique($duplicateVns));
                return redirect()->back()->with('invalid', $message);
            }
            
            $file  = $request->file('file');
            $fileName = $hcode."_".date('Ymdhis').".xls";
            $destination = public_path('uploads/opae');

            File::makeDirectory($destination, 0755, true, true);
            $file->move(public_path('uploads/opae'), $fileName);

            DB::table('import_log')->insert(
                [
                    'ex_file' => $fileName,
                    'import_date' => date("Y-m-d"),
                    'hcode' => $hcode,
                    'type' => 'OPAE',
                ]
            );
            return back()->with('success', 'นำเข้าข้อมูลสำเร็จ');

            } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
                $failures = $e->failures();
                $errorMessages = [];
                foreach ($failures as $failure) {
                    $errorMessages[] = "แถว: " . $failure->row() . ", คอลัมน์: " . $failure->attribute() . ", ข้อผิดพลาด: " . implode(", ", $failure->errors());
                }
                return redirect()->back()->with('invalid', 'เกิดข้อผิดพลาดในการนำเข้า: ' . implode("<br>", $errorMessages));
            } catch (\Exception $e) {
                return redirect()->back()->with('invalid', 'เกิดข้อผิดพลาดที่ไม่คาดคิด: ' . $e->getMessage());
            }
  
        // Excel::import(new ClaimImport, $request->file('file'));
        
        // $file  = $request->file('file');
        // $fileName = $hcode."_".date('Ymdhis').".xls";
        // $destination = public_path('uploads/opae');

        // File::makeDirectory($destination, 0755, true, true);
        // $file->move(public_path('uploads/opae'), $fileName);

        // DB::table('import_log')->insert(
        //     [
        //         'ex_file' => $fileName,
        //         'import_date' => date("Y-m-d"),
        //         'hcode' => $hcode,
        //         'type' => 'OPAE',
        //     ]
        // );
        // return back()->with('success', 'นำเข้าข้อมูลสำเร็จ');
    }

    public function create()
    {
        $nhso = DB::table('nhso')->get();
        $hosp = DB::table('hospital')->where('h_type',1)->get();
        return view('debtor.create',['nhso'=>$nhso,'hosp'=>$hosp]);
    }

    public function add(Request $request)
    {
        $hcode = Auth::user()->hcode;
        $currentDate = date('Y-m-d H:i:s');

        $validatedData = $request->validate(
            [
                'vn' => 'required',
                'visitdate' => 'required',
                'hospmain' => 'required',
                'person_id' => 'required',
                'hn' => 'required',
                'name' => 'required',
                'age' => 'required',
                'sex' => 'required',
                'icd10' => 'required',
            ],
            [
                'vn.required' => 'ระบุ VN',
                'visitdate.required' => 'ระบุวันที่รับบริการ',
                'hospmain.required' => 'ระบุโรงพยาบาล',
                'person_id.required' => 'ระบุเลข 13 หลัก',
                'hn.required' => 'ระบุ HN',
                'name.required' => 'ระบุชื่อ-สกุล',
                'age.required' => 'ระบุอายุ',
                'sex.required' => 'ระบุเพศ',
                'icd10.required' => 'ระบุ ICD10',
            ],
        );

        foreach ($request->addField as $key => $value) {
            DB::table('claim_list')->insert(
                [
                    'uuid' => Str::uuid()->toString(),
                    'vn' => $request->vn,
                    'visitdate' => $request->visitdate,
                    'hospmain' => $request->hospmain,
                    'person_id' => $request->person_id,
                    'hn' => $request->hn,
                    'name' => $request->name,
                    'age' => $request->age,
                    'sex' => $request->sex,
                    'auth_code' => $request->auth_code,
                    'icd10' => $request->icd10,
                    'fs_code' => $value['fs_code'],
                    'total' => $value['total'],
                    'num' => $value['num'],
                    'hcode' => $hcode,
                    'process_date' => $currentDate,
                    'updated_at' => $currentDate
                ]
            );
        }
        return back()->with('success','เพิ่มข้อมูลลูกหนี้สำเร็จ');
    }

    public function addList(string $id,Request $request)
    {
        $hcode = Auth::user()->hcode;
        $currentDate = date('Y-m-d H:i:s');

        $validatedData = $request->validate(
            [
                'icd10' => 'required',
                'fs_code' => 'required',
                'num' => 'required',
                'total' => 'required',
            ],
            [
                'icd10.required' => 'ระบุ ICD10',
                'fs_code.required' => 'ระบุรหัสบริการ',
                'num.required' => 'ระบุจำนวน',
                'total.required' => 'ระบุค่าใช้จ่ายจริง',
            ],
        );

        $data = DB::table('claim_list')->where('vn',$id)->first();
        DB::table('claim_list')->insert(
            [
                'uuid' => Str::uuid()->toString(),
                'vn' => $id,
                'visitdate' => $data->visitdate,
                'hospmain' => $data->hospmain,
                'person_id' => $data->person_id,
                'hn' => $data->hn,
                'name' => $data->name,
                'age' => $data->age,
                'sex' => $data->sex,
                'auth_code' => $data->auth_code,
                'icd10' => $data->icd10,
                'fs_code' => $request->fs_code,
                'num' => $request->num,
                'total' => $request->total,
                'hcode' => $hcode,
                'process_date' => $currentDate,
                'updated_at' => $currentDate
            ]
        );
        return back()->with('success','เพิ่มข้อมูลลูกหนี้สำเร็จ');
    }

    public function list()
    {
        $hcode = Auth::user()->hcode;
        $query = "SELECT visitdate,hn,claim_list.vn,hcode,hospmain,h_name,fs_code,nhso_code,tid,
                dname,total,nhso_cost,num,p_text_color,p_name,p_icon,nhso_name,rate,
                IF(N.vn IS NULL,'Y','N') AS is_status
                    FROM claim_list
                    LEFT JOIN nhso ON `nhso`.`nhso_code` = `claim_list`.`fs_code` 
                    LEFT JOIN drug ON `drug`.`tid` = `claim_list`.`fs_code` 
                    LEFT JOIN hospital ON `hospital`.`h_code` = `claim_list`.`hospmain` 
                    LEFT JOIN p_status ON `p_status`.`id` = 1
                    LEFT JOIN(
                        SELECT DISTINCT vn
                        FROM claim_list
                        LEFT JOIN nhso ON `nhso`.`nhso_code` = `claim_list`.`fs_code` 
                        LEFT JOIN drug ON `drug`.`tid` = `claim_list`.`fs_code` 
                        INNER JOIN hospital ON `hospital`.`h_code` = `claim_list`.`hospmain` 
                        WHERE hcode = $hcode AND `claim_list`.`p_status`=1 
                        AND IF(NOT nhso_code IS NULL OR NOT tid IS NULL,'Y','N') = 'N'
                ) N ON claim_list.vn = N.vn
                WHERE hcode = $hcode AND p_status = '1'
                ORDER BY claim_id DESC";

        $data = DB::select($query);
        return view('debtor.list',['data'=>$data]);
    }

    public function deny()
    {
        $hcode = Auth::user()->hcode;
        $data = DB::table('claim_list')
            ->select('uuid','claim_id','vn','visitdate','hospmain','hcode','name','hn','h_name','deny_note',
            'icd10','fs_code','total','nhso_code','nhso_name','nhso_unit','nhso_cost','p_name','p_icon','p_text_color')
            ->leftjoin('nhso','nhso.nhso_code','claim_list.fs_code')
            ->leftjoin('hospital','hospital.h_code','claim_list.hospmain')
            ->leftjoin('p_status','p_status.id','claim_list.p_status')
            ->where('p_status', 5)
            ->where('hcode',$hcode)
            ->orderby('claim_id','desc')
            ->get();
        return view('debtor.deny',['data'=>$data]);
    }

    public function show(string $id)
    {
        $data = DB::table('claim_list')
            ->select('vn','visitdate','hospmain','hcode','name','hn','trans_code','p_status',
            'h_name','auth_code','person_id','age','sex_name','sex_icon','pd_date')
            ->leftjoin('hospital','hospital.h_code','claim_list.hospmain')
            ->leftjoin('sex_type','sex_type.sex_id','claim_list.sex')
            ->where('vn', $id)
            ->first();

        $list = DB::table('claim_list')
            ->leftjoin('nhso','nhso.nhso_code','claim_list.fs_code')
            ->leftjoin('drug','drug.tid','claim_list.fs_code')
            ->leftjoin('hospital','hospital.h_code','claim_list.hospmain')
            ->leftjoin('p_status','p_status.id','claim_list.p_status')
            // ->where('nhso.active','Y')
            ->where('vn', $id)
            ->orderBy('claim_id','ASC')
            ->get();
        // dd($list);
        return view('debtor.show',['data'=>$data,'list'=>$list]);
    }

    public function listDelete(string $id)
    {
        DB::table('claim_list')->where('uuid',$id)->delete();
        return back()->with('success','ลบรายการแล้ว');
    }

    public function search(Request $request)
    {
        $data = DB::table('claim_list')
            ->select('vn','visitdate','hospmain','hcode','name','hn',
            'h_name','auth_code','person_id','age','sex_name','sex_icon')
            ->leftjoin('nhso','nhso.nhso_code','claim_list.fs_code')
            ->leftjoin('hospital','hospital.h_code','claim_list.hospmain')
            ->leftjoin('sex_type','sex_type.sex_id','claim_list.sex')
            ->where('vn', $request->vn)
            ->first();

        $list = DB::table('claim_list')
            ->select('icd10','fs_code','total','nhso_code','nhso_name','nhso_unit','nhso_cost')
            ->leftjoin('nhso','nhso.nhso_code','claim_list.fs_code')
            ->leftjoin('hospital','hospital.h_code','claim_list.hospmain')
            ->where('vn', $request->vn)
            ->get();

        if(isset($data)){
            return view('debtor.show',['data'=>$data,'list'=>$list]);
        }else{
            return back()->with('error','ไม่พบ VN : '.$request->vn);
        }
    }

    public function send(Request $request)
    {
        $vns = rtrim($request->vns, ",");
        $currentDate = date('Y-m-d H:i:s');
        $hcode = Auth::user()->hcode;
        $transCode = $hcode.date('Ym').substr(rand(),1,5);
        $query = "UPDATE claim_list
                SET p_status = 2 , trans_code = $transCode
                WHERE vn IN (
                    SELECT vn
                    FROM (
                        SELECT vn, fs_code
                        FROM claim_list
                        WHERE hcode = $hcode
                    ) AS subquery_claim_list
                    GROUP BY vn
                    HAVING COUNT(*) = SUM(CASE
                        WHEN EXISTS (SELECT 1 FROM nhso WHERE nhso_code = subquery_claim_list.fs_code)
                            OR EXISTS (SELECT 1 FROM drug WHERE tid = subquery_claim_list.fs_code)
                        THEN 1
                        ELSE 0
                    END)
                )
                AND hcode = $hcode;";
        $data = DB::select($query);
    }

    public function remove(Request $request)
    {
        $hcode = Auth::user()->hcode;
        $query = "DELETE FROM claim_list WHERE hcode = $hcode AND p_status = 1";
        $data = DB::select($query);
    }
}
