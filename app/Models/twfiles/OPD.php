<?php

namespace App\Models\twfiles;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OPD extends Model
{
    protected $table = 'OPD';
    protected $fillable = [
        'HN',
        'CLINIC',
        'DATEOPD',
        'TIMEOPD',
        'SEQ',
        'UUC',
        'DETAIL',
        'BTEMP',
        'SBP',
        'DBP',
        'PR',
        'RR',
        'OPTYPE',
        'TYPEIN',
        'TYPEOUT',
        'HOWNER',
    ];
    protected $guarded = [];
    public $timestamps = true;
}