<?php

namespace App\Models\twfiles;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LAB extends Model
{
    protected $table = 'LAB';
    protected $fillable = [
        'HCODE',
        'HN',
        'PERSON_ID',
        'DATESERV',
        'SEQ',
        'LABTEST',
        'LABRESULT',
        'HOWNER',
    ];
    protected $guarded = [];
    public $timestamps = true;
}