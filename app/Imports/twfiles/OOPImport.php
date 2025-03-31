<?php

namespace App\Imports\twfiles;

use App\Models\twfiles\OOP;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Auth;

class OOPImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new OOP([
            'HN' => $row[0],
            'DATEOPD' => $row[1],
            'CLINIC' => $row[2],
            'OPER' => $row[3],
            'DROPID' => $row[4],
            'PERSON_ID' => $row[5],
            'SEQ' => $row[6],
            'HOWNER' => Auth::user()->hcode,
        ]);
    }
}
