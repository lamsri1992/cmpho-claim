<?php

namespace App\Models\twfiles;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OOP extends Model
{
    protected $table = 'OOP';
    protected $fillable = [
        'HN',
        'DATEOPD',
        'CLINIC',
        'OPER',
        'DROPID',
        'PERSON_ID',
        'SEQ',
        'HOWNER',
    ];
    protected $guarded = [];
    public $timestamps = true;
}