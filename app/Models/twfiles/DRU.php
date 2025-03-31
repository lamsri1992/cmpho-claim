<?php

namespace App\Models\twfiles;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DRU extends Model
{
    protected $table = 'DRU';
    protected $fillable = [
        'HCODE',
        'HN',
        'AN',
        'CLINIC',
        'PERSON_ID',
        'DATE_SERV',
        'DID',
        'DIDNAME',
        'AMOUNT',
        'DRUGPRIC',
        'DRUGCOST',
        'DIDSTD',
        'UNIT',
        'UNIT_PACK',
        'SEQ',
        'DRUGTYPE',
        'DRUGREMARK',
        'PA_NO',
        'TOTCOPAY',
        'USE_STATUS',
        'TOTAL',
        'HOWNER',
    ];
    protected $guarded = [];
    public $timestamps = true;
}