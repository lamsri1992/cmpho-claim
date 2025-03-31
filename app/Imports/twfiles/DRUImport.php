<?php

namespace App\Imports\twfiles;

use App\Models\twfiles\DRU;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Auth;

class DRUImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new DRU([
            'HCODE' => $row[0],
            'HN' => $row[1],
            'AN' => $row[2],
            'CLINIC' => $row[3],
            'PERSON_ID' => $row[4],
            'DATE_SERV' => $row[5],
            'DID' => $row[6],
            'DIDNAME' => $row[7],
            'AMOUNT' => $row[8],
            'DRUGPRIC' => $row[9],
            'DRUGCOST' => $row[10],
            'DIDSTD' => $row[11],
            'UNIT' => $row[12],
            'UNIT_PACK' => $row[13],
            'SEQ' => $row[14],
            'DRUGTYPE' => $row[15],
            'DRUGREMARK' => $row[16],
            'PA_NO' => $row[17],
            'TOTCOPAY' => $row[18],
            'USE_STATUS' => $row[19],
            'TOTAL' => $row[20],
            'HOWNER' => Auth::user()->hcode,
        ]);
    }
}
