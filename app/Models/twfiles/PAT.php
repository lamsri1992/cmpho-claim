<?php

namespace App\Models\twfiles;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PAT extends Model
{
    protected $table = 'PAT';
    protected $fillable = [
        'HCODE',
        'HN',
        'CHANGWAT',
        'AMPHUR',
        'DOB',
        'SEX',
        'MARRIAGE',
        'OCCUPA',
        'NATION',
        'PERSON_ID',
        'NAMEPAT',
        'TITLE',
        'FNAME',
        'LNAME',
        'IDTYPE',
        'HOWNER',
    ];
    protected $guarded = [];
    public $timestamps = true;
}