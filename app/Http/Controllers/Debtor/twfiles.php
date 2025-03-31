<?php

namespace App\Http\Controllers\debtor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\twfiles\ADPImport;
use App\Imports\twfiles\AERImport;
use App\Imports\twfiles\CHAImport;
use App\Imports\twfiles\CHTImport;
use App\Imports\twfiles\DRUImport;
use App\Imports\twfiles\INSImport;
use App\Imports\twfiles\LABImport;
use App\Imports\twfiles\ODXImport;
use App\Imports\twfiles\OOPImport;
use App\Imports\twfiles\OPDImport;
use App\Imports\twfiles\ORFImport;
use App\Imports\twfiles\PATImport;
use App\Imports\twfiles\AER;
use App\Imports\twfiles\CHA;
use App\Imports\twfiles\CHT;
use App\Imports\twfiles\DRU;
use App\Imports\twfiles\INS;
use App\Imports\twfiles\LAB;
use App\Imports\twfiles\ODX;
use App\Imports\twfiles\OOP;
use App\Imports\twfiles\OPD;
use App\Imports\twfiles\ORF;
use App\Imports\twfiles\PAT;
use DB;
use Auth;
use File;

class twfiles extends Controller
{
    public function index()
    {
        $hcode = Auth::user()->hcode;
        $query_count = "SELECT
            (SELECT COUNT(*) FROM ADP WHERE HOWNER = $hcode) AS 'ADP',
            (SELECT COUNT(*) FROM AER WHERE HOWNER = $hcode) AS 'AER',
            (SELECT COUNT(*) FROM CHA WHERE HOWNER = $hcode) AS 'CHA',
            (SELECT COUNT(*) FROM CHT WHERE HOWNER = $hcode) AS 'CHT',
            (SELECT COUNT(*) FROM DRU WHERE HOWNER = $hcode) AS 'DRU',
            (SELECT COUNT(*) FROM INS WHERE HOWNER = $hcode) AS 'INS',
            (SELECT COUNT(*) FROM LAB WHERE HOWNER = $hcode) AS 'LAB',
            (SELECT COUNT(*) FROM ODX WHERE HOWNER = $hcode) AS 'ODX',
            (SELECT COUNT(*) FROM OOP WHERE HOWNER = $hcode) AS 'OOP',
            (SELECT COUNT(*) FROM OPD WHERE HOWNER = $hcode) AS 'OPD',
            (SELECT COUNT(*) FROM ORF WHERE HOWNER = $hcode) AS 'ORF',
            (SELECT COUNT(*) FROM PAT WHERE HOWNER = $hcode) AS 'PAT'";
        $count = DB::select($query_count);
        return view('twfiles.index',['count'=>$count]);
    }

    public function import(Request $request) 
    {
        $hcode = Auth::user()->hcode;
        $validatedData = $request->validate(
            [
                'ADP' => 'required|max:2048|mimes:txt',
                // 'AER' => 'required|max:2048|mimes:txt',
                // 'CHA' => 'required|max:2048|mimes:txt',
                // 'CHT' => 'required|max:2048|mimes:txt',
                // 'DRU' => 'required|max:2048|mimes:txt',
                // 'INS' => 'required|max:2048|mimes:txt',
                // 'LAB' => 'required|max:2048|mimes:txt',
                // 'ODX' => 'required|max:2048|mimes:txt',
                // 'OOP' => 'required|max:2048|mimes:txt',
                // 'OPD' => 'required|max:2048|mimes:txt',
                // 'ORF' => 'required|max:2048|mimes:txt',
                // 'PAT' => 'required|max:2048|mimes:txt',
            ],
            [
                'ADP.required' => 'กรุณาแนบไฟล์ ADP',
                // 'AER.required' => 'กรุณาแนบไฟล์ AER',
                // 'CHA.required' => 'กรุณาแนบไฟล์ CHA',
                // 'CHT.required' => 'กรุณาแนบไฟล์ CHT',
                // 'DRU.required' => 'กรุณาแนบไฟล์ DRU',
                // 'INS.required' => 'กรุณาแนบไฟล์ INS',
                // 'LAB.required' => 'กรุณาแนบไฟล์ LAB',
                // 'ODX.required' => 'กรุณาแนบไฟล์ ODX',
                // 'OOP.required' => 'กรุณาแนบไฟล์ OOP',
                // 'OPD.required' => 'กรุณาแนบไฟล์ OPD',
                // 'ORF.required' => 'กรุณาแนบไฟล์ ORF',
                // 'PAT.required' => 'กรุณาแนบไฟล์ PAT',
            ],
        );
  
        Excel::import(new ADPImport, $request->file('ADP'));
        // Excel::import(new AERImport, $request->file('AER'));
        // Excel::import(new CHAImport, $request->file('CHA'));
        // Excel::import(new CHTImport, $request->file('CHT'));
        // Excel::import(new DRUImport, $request->file('DRU'));
        // Excel::import(new INSImport, $request->file('INS'));
        // Excel::import(new LABImport, $request->file('LAB'));
        // Excel::import(new ODXImport, $request->file('ODX'));
        // Excel::import(new OOPImport, $request->file('OOP'));
        // Excel::import(new OPDImport, $request->file('OPD'));
        // Excel::import(new ORFImport, $request->file('ORF'));
        // Excel::import(new PATImport, $request->file('PAT'));
        
        $deleted = DB::table('ADP')->where('HN', 'HN')->delete();
        // $deleted = DB::table('AER')->where('HN', 'HN')->delete();
        // $deleted = DB::table('CHA')->where('HN', 'HN')->delete();
        // $deleted = DB::table('CHT')->where('HN', 'HN')->delete();
        // $deleted = DB::table('DRU')->where('HN', 'HN')->delete();
        // $deleted = DB::table('INS')->where('HN', 'HN')->delete();
        // $deleted = DB::table('LAB')->where('HN', 'HN')->delete();
        // $deleted = DB::table('ODX')->where('HN', 'HN')->delete();
        // $deleted = DB::table('OOP')->where('HN', 'HN')->delete();
        // $deleted = DB::table('OPD')->where('HN', 'HN')->delete();
        // $deleted = DB::table('ORF')->where('HN', 'HN')->delete();
        // $deleted = DB::table('PAT')->where('HN', 'HN')->delete();
        return back()->with('success', 'นำเข้าข้อมูล 12 แฟ้มสำเร็จ');
    }

    public function view(string $table)
    {
        $hcode = Auth::user()->hcode;
        $data = DB::table($table)->where('HOWNER',$hcode)->get();
        return view('twfiles.view',['data'=>$data,'table'=>$table]);
    }

}
