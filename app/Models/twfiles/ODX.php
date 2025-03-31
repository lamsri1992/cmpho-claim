<?php

namespace App\Models\twfiles;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ODX extends Model
{
    protected $table = 'ODX';
    protected $fillable = [
        'HN',
        'DATEDX',
        'CLINIC',
        'DIAG',
        'DXTYPE',
        'DRDX',
        'PERSON_ID',
        'SEQ',
        'HOWNER',
    ];
    protected $guarded = [];
    public $timestamps = true;
}