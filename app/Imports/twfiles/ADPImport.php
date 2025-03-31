<?php

namespace App\Imports\twfiles;

use App\Models\twfiles\ADP;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Auth;

// class ADPImport implements ToModel, WithHeadingRow, WithValidation
class ADPImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new ADP([
            'HN' => $row[0],
            'AN' => $row[1],
            'DATEOPD' => $row[2],
            'BILLMAUD' => $row[3],
            'TYPE' => $row[4],
            'CODE' => $row[5],
            'QTY' => $row[6],
            'RATE' => $row[7],
            'SEQ' => $row[8],
            'CAGCODE' => $row[9],
            'DOSE' => $row[10],
            'CA_TYPE' => $row[11],
            'SERIALNO' => $row[12],
            'TOTCOPAY' => $row[13],
            'USE_STATUS' => $row[14],
            'TOTAL' => $row[15],
            'QTYDAY' => $row[16],
            'TMLTCODE' => $row[17],
            'STATUS1' => $row[18],
            'BI' => $row[19],
            'GRAVIDA' => $row[20],
            'GA_WEEK' => $row[21],
            'DCIP' => $row[22],
            'LMP' => $row[23],
            'SP_ITEM' => $row[24],
            'HOWNER' => Auth::user()->hcode,
        ]);
    }
}
