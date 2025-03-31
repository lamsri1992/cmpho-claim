<?php

namespace App\Imports\twfiles;

use App\Models\twfiles\AER;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Auth;

class AERImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new AER([
            'HN' => $row[0],
            'AN' => $row[1],
            'DATEOPD' => $row[2],
            'AUTHAE' => $row[3],
            'AEDATE' => $row[4],
            'AETIME' => $row[5],
            'AETYPE' => $row[6],
            'REFER_NO' => $row[7],
            'REFMAINI' => $row[8],
            'IREFTYPE' => $row[9],
            'REFMAINO' => $row[10],
            'OREFTYPE' => $row[11],
            'UCAE' => $row[12],
            'EMTYPE' => $row[13],
            'SEQ' => $row[14],
            'AESTATUS' => $row[15],
            'DALERT' => $row[16],
            'TALERT' => $row[17],
            'HOWNER' => Auth::user()->hcode,
        ]);
    }
}
