<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class sections extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable=[
        'section_name',
        'description',
        'Created_by',
    ];
    /**
     * Get all of the comments for the sections
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function products(): HasMany
    {
        return $this->hasMany(products::class);
    }
    public function invoices(): HasMany
    {
        return $this->hasMany(invoices::class);
    }
}
