<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CashTransaction extends Model
{

    protected $fillable = [

        'amount',
        'type',
        'reference_type',
        'reference_id',
        'description',
        'date'

    ];

}
