<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';

    protected $fillable = [
        'product_category_id',
        'name',
        'image_url',
        'discount',
        'is_active',
        'is_maintenance'
    ];

    public function productCategory()
    {
        return $this->belongsTo(ProductCategory::class,'product_category_id');
    }
}
