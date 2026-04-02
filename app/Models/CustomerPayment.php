<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerPayment extends Model
{

protected $fillable = [

'customer_id',
'amount',
'payment_date',
'payment_method',
'notes'

];



public function payments()
{
    return $this->hasMany(CustomerPayment::class);
}

public function sales()
{
    return $this->hasMany(Sale::class);
}

public function customer()
{
    return $this->belongsTo(\App\Models\Customer::class);
}

}
