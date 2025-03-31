<?php

namespace App\Models\twfiles;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ORF extends Model
{
    protected $table = 'ORF';
    protected $fillable = [
        'HN',
        'DATEOPD',
        'CLINIC',
        'REFER',
        'REFERTYPE',
        'SEQ',
        'HOWNER',
    ];
    protected $guarded = [];
    public $timestamps = true;
}