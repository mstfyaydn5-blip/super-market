<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;


class Product extends Model
{
     protected $fillable = [
  'name','price','quantity','category_id','description','image','user_id','updated_by'
];


    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function user()
    {
    return $this->belongsTo(\App\Models\User::class);
    }



    public function updatedBy()
    {
    return $this->belongsTo(User::class, 'updated_by');
    }

    public function activities()
    {
    return $this->hasMany(ProductActivity::class)->latest();
    }

    public function purchaseItems()
{
    return $this->hasMany(\App\Models\PurchaseInvoiceItem::class);
}

public function saleItems()
{
    return $this->hasMany(\App\Models\SaleItem::class);
}


}
