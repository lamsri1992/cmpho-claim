<?php

namespace App\Imports\twfiles;

use App\Models\twfiles\CHT;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Auth;

class CHTImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new CHT([
            'HN' => $row[0],
            'AN' => $row[1],
            'DATE' => $row[2],
            'TOTAL' => $row[3],
            'PAID' => $row[4],
            'PTTYPE' => $row[5],
            'PERSON_ID' => $row[6],
            'SEQ' => $row[7],
            'HOWNER' => Auth::user()->hcode,
        ]);
    }
}
