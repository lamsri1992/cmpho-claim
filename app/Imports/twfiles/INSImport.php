<?php

namespace App\Imports\twfiles;

use App\Models\twfiles\INS;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Auth;

class INSImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new INS([
            'HN' => $row[0],
            'INSCL' => $row[1],
            'SUBTYPE' => $row[2],
            'CID' => $row[3],
            'DATEIN' => $row[4],
            'DATEEXP' => $row[5],
            'HOSPMAIN' => $row[6],
            'HOSPSUB' => $row[7],
            'GOVCODE' => $row[8],
            'GOVNAME' => $row[9],
            'PERMITNO' => $row[10],
            'DOCNO' => $row[11],
            'OWNRPID' => $row[12],
            'OWNNAME' => $row[13],
            'AN' => $row[14],
            'SEQ' => $row[15],
            'SUBINSCL' => $row[16],
            'RELINSCL' => $row[17],
            'HTYPE' => $row[18],
            'HOWNER' => Auth::user()->hcode,
        ]);
    }
}
