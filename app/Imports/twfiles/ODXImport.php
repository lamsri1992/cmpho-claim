<?php

namespace App\Imports\twfiles;

use App\Models\twfiles\ODX;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Auth;

class ODXImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new ODX([
            'HN' => $row[0],
            'DATEDX' => $row[1],
            'CLINIC' => $row[2],
            'DIAG' => $row[3],
            'DXTYPE' => $row[4],
            'DRDX' => $row[5],
            'PERSON_ID' => $row[6],
            'SEQ' => $row[7],
            'HOWNER' => Auth::user()->hcode,
        ]);
    }
}
