<?php

namespace App\Models\twfiles;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class INS extends Model
{
    protected $table = 'INS';
    protected $fillable = [
        'HN',
        'INSCL',
        'SUBTYPE',
        'CID',
        'DATEIN',
        'DATEEXP',
        'HOSPMAIN',
        'HOSPSUB',
        'GOVCODE',
        'GOVNAME',
        'PERMITNO',
        'DOCNO',
        'OWNRPID',
        'OWNNAME',
        'AN',
        'SEQ',
        'SUBINSCL',
        'RELINSCL',
        'HTYPE',
        'HOWNER',
    ];
    protected $guarded = [];
    public $timestamps = true;
}