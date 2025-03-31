<?php

namespace App\Imports\twfiles;

use App\Models\twfiles\LAB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Auth;

class LABImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new LAB([
            'HCODE' => $row[0],
            'HN' => $row[1],
            'PERSON_ID' => $row[2],
            'DATESERV' => $row[3],
            'SEQ' => $row[4],
            'LABTEST' => $row[5],
            'LABRESULT' => $row[6],
            'HOWNER' => Auth::user()->hcode,
        ]);
    }
}
