<?php

namespace App\Imports;

use App\Models\Claim;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Support\Str;

class ClaimImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Claim([
            'visitdate' => $row['visitdate'],
            'vn' => $row['vn'],
            'hospmain' => $row['hospmain'],
            'hcode' => $row['hcode'],
            'name' => $row['name'],
            'person_id' => $row['person_id'],
            'age' => $row['age'],
            'sex' => $row['sex'],
            'hn' => $row['hn'],
            'icd10' => $row['icd10'],
            'fs_code' => $row['fs_code'],
            'num' => $row['num'],
            'auth_code' => $row['auth_code'],
            'total' => $row['total'],
            'uuid' => Str::uuid()->toString(),
        ]);
    }

    public function rules(): array
    {
        return [
            'vn' => 'required',
            'visitdate' => 'required',
            'hospmain' => 'required',
            'hcode' => 'required',
            'name' => 'required',
            'person_id' => 'required',
            'age' => 'required',
            'sex' => 'required',
            'hn' => 'required',
            'icd10' => 'required',
            'num' => 'required',
            'fs_code' => 'required',
            'total' => 'required',
        ];
    }
}
