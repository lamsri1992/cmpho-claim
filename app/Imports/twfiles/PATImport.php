<?php

namespace App\Imports\twfiles;

use App\Models\twfiles\PAT;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Auth;

class PATImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new PAT([
            'HCODE' => $row[0],
            'HN' => $row[1],
            'CHANGWAT' => $row[2],
            'AMPHUR' => $row[3],
            'DOB' => $row[4],
            'SEX' => $row[5],
            'MARRIAGE' => $row[6],
            'OCCUPA' => $row[7],
            'NATION' => $row[8],
            'PERSON_ID' => $row[9],
            'NAMEPAT' => $row[10],
            'TITLE' => $row[11],
            'FNAME' => $row[12],
            'LNAME' => $row[13],
            'IDTYPE' => $row[14],
            'HOWNER' => Auth::user()->hcode,
        ]);
    }
}
