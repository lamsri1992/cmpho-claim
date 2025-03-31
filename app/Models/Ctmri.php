<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ctmri extends Model
{
    protected $table = 'ct_list';
    protected $fillable = [
        'cid',
        'visitdate',
        'hospmain',
        'hcode',
        'name',
        'age',
        'hn',
        'icd10',
        'icd9',
        'red',
        'contrast_description',
        'total_cash',
        'point',
        'total_payment',
        'total_contrast',
        'id',
        'uuid',
    ];
    protected $guarded = [];
    public $timestamps = true;
}