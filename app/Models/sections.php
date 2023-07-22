<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class sections extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable=[
        'section_name',
        'description',
        'Created_by',
    ];
}
