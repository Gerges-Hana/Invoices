<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class products extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable=[
        'Product_name',
        'description',
        'section_id',
    ];



    public function section()
    {
        return $this->belongsTo(sections::class);
    }
}
