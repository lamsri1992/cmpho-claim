<?php

namespace App\Models\twfiles;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AER extends Model
{
    protected $table = 'AER';
    protected $fillable = [
        'HN',
        'AN',
        'DATEOPD',
        'AUTHAE',
        'AEDATE',
        'AETIME',
        'AETYPE',
        'REFER_NO',
        'REFMAINI',
        'IREFTYPE',
        'REFMAINO',
        'OREFTYPE',
        'UCAE',
        'EMTYPE',
        'SEQ',
        'AESTATUS',
        'DALERT',
        'TALERT',
        'HOWNER',
    ];
    protected $guarded = [];
    public $timestamps = true;
}