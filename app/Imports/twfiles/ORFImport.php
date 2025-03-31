<?php

namespace App\Imports\twfiles;

use App\Models\twfiles\ORF;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Auth;

class ORFImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new ORF([
            'HN' => $row[0],
            'DATEOPD' => $row[1],
            'CLINIC' => $row[2],
            'REFER' => $row[3],
            'REFERTYPE' => $row[4],
            'SEQ' => $row[5],
            'HOWNER' => Auth::user()->hcode,
        ]);
    }
}
