<?php

namespace App\Models\twfiles;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CHA extends Model
{
    protected $table = 'CHA';
    protected $fillable = [
        'HN',
        'AN',
        'DATE',
        'CHRGITEM',
        'AMOUNT',
        'PERSON_ID',
        'SEQ',
        'HOWNER',
    ];
    protected $guarded = [];
    public $timestamps = true;
}