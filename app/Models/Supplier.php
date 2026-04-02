<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $fillable = [
        'name',
        'phone',
        'email',
        'address',
        'opening_balance',
        'balance',
        'notes'
    ];

    protected $casts = [
        'opening_balance' => 'decimal:2',
        'balance' => 'decimal:2',
    ];

    public function payments()
    {
        return $this->hasMany(SupplierPayment::class);
    }

    public function purchaseInvoices()
    {
        return $this->hasMany(\App\Models\PurchaseInvoice::class);
    }
}
