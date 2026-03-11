<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupplierPayment extends Model
{

    protected $fillable = [

        'supplier_id',
        'amount',
        'payment_date',
        'payment_method',
        'notes'

    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

}
