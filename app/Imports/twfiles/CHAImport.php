<?php

namespace App\Imports\twfiles;

use App\Models\twfiles\CHA;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Auth;

class CHAImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new CHA([
            'HN' => $row[0],
            'AN' => $row[1],
            'DATE' => $row[2],
            'CHRGITEM' => $row[3],
            'AMOUNT' => $row[4],
            'PERSON_ID' => $row[5],
            'SEQ' => $row[6],
            'HOWNER' => Auth::user()->hcode,
        ]);
    }
}
