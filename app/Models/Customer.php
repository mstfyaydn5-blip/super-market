<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{

protected $fillable = [

'name',
'phone',
'email',
'address',
'opening_balance',
'notes'

];

public function payments()
{
return $this->hasMany(CustomerPayment::class);
}

public function sales()
{
    return $this->hasMany(\App\Models\Sale::class);
}

}
