<?php

namespace App\Imports;

use App\Models\Ctmri;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Support\Str;

class CtmriImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        try {
            return new Ctmri([
                'visitdate' => $row['visitdate'],
                'name' => $row['name'],
                'age' => $row['age'],
                'hn' => $row['hn'],
                'cid' => $row['cid'],
                'hospmain' => $row['hospmain'],
                'hcode' => $row['hcode'],
                'icd10' => $row['icd10'],
                'icd9' => $row['icd9'],
                'red' => $row['red'],
                'total_cash' => $row['total_cash'],
                'point' => $row['point'],
                'total_payment' => $row['total_payment'],
                'contrast_description' => $row['contrast_description'],
                'total_contrast' => $row['total_contrast'],
                'uuid' => Str::uuid()->toString(),
            ]);
        } catch (\ErrorException $e) {
            ("Error importing row: " . json_encode($row));
            ($e->getMessage());
            return null; 
        }
    }

    public function headingRow(): int
    {
        return 1;
    }

    public function rules(): array
    {
        return [
            'cid' => 'required',
            'visitdate' => 'required',
            'hospmain' => 'required',
            'hcode' => 'required',
            'name' => 'required',
            'hn' => 'required',
            'point' => 'required',
            'total_payment' => 'required',
        ];
    }
}
