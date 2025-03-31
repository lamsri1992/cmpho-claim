<?php

namespace App\Models\twfiles;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CHT extends Model
{
    protected $table = 'CHT';
    protected $fillable = [
        'HN',
        'AN',
        'DATE',
        'TOTAL',
        'PAID',
        'PTTYPE',
        'PERSON_ID',
        'SEQ',
        'HOWNER',
    ];
    protected $guarded = [];
    public $timestamps = true;
}