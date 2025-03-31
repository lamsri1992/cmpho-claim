<?php

namespace App\Models\twfiles;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ADP extends Model
{
    protected $table = 'ADP';
    protected $fillable = [
        'HN',
        'AN',
        'DATEOPD',
        'BILLMAUD',
        'TYPE',
        'CODE',
        'QTY',
        'RATE',
        'SEQ',
        'CAGCODE',
        'DOSE',
        'CA_TYPE',
        'SERIALNO',
        'TOTCOPAY',
        'USE_STATUS',
        'TOTAL',
        'QTYDAY',
        'TMLTCODE',
        'STATUS1',
        'BI',
        'GRAVIDA',
        'GA_WEEK',
        'DCIP',
        'LMP',
        'SP_ITEM',
        'HOWNER',
    ];
    protected $guarded = [];
    public $timestamps = true;
}