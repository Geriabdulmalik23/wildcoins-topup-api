<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductOption extends Model
{
    protected $table = 'product_options';

    protected $fillable = [
       'product_id',
       'title',
       'base_price',
       'discount',
       'vat'
    ];

    public function product()
    {
        return $this->hasMany(Product::class, 'product_id');
    }
}
