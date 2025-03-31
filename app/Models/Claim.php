<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Claim extends Model
{
    protected $table = 'claim_list';
    protected $fillable = [
        'visitdate',
        'vn',
        'hospmain',
        'hcode',
        'name',
        'person_id',
        'age',
        'sex',
        'hn',
        'icd10',
        'fs_code',
        'num',
        'auth_code',
        'total',
        'p_status',
        'trans_code',
        'uuid',
    ];
    protected $guarded = [];
    public $timestamps = true;
}