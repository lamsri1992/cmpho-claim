<?php

namespace App\Imports\twfiles;

use App\Models\twfiles\OPD;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Auth;

class OPDImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new OPD([
            'HN' => $row[0],
            'CLINIC' => $row[1],
            'DATEOPD' => $row[2],
            'TIMEOPD' => $row[3],
            'SEQ' => $row[4],
            'UUC' => $row[5],
            'DETAIL' => $row[6],
            'BTEMP' => $row[7],
            'SBP' => $row[8],
            'DBP' => $row[9],
            'PR' => $row[10],
            'RR' => $row[11],
            'OPTYPE' => $row[12],
            'TYPEIN' => $row[13],
            'TYPEOUT' => $row[14],
            'HOWNER' => Auth::user()->hcode,
        ]);
    }
}
