<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class invoices extends Model
{
    use HasFactory,SoftDeletes,Notifiable;

    protected $fillable = [



    'invoice_number',
    'invoice_Date',
    'Due_date',
    'product',
    'section_id'
    ,'Amount_collection'
    ,'Amount_Commission'
    ,'Discount'
    ,'Value_VAT'
    ,'Rate_VAT'
    ,'Total'
    ,'Status'
    ,'Value_Status'
    ,'note'
    ,'Payment_DateF'

];
public function section()
{
    return $this->belongsTo(sections::class);
}
public function product()
{
    return $this->belongsTo(products::class);
}
}
