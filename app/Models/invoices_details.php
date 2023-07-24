<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class invoices_details extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable=[
        'invoice_id',
        'invoice_number',
        'product',
        'Section',
        'Value_Status',
        'Payment_Date',
        'note',
        'user',
        'Status',
    ];


}
