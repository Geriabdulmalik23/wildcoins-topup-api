<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';

    protected $fillable = [
        'user_id',
        'product_id',
        'topup_option_id',
        'payment_method_id',
        'user_game_id',
        'server',
        'qr_code_url',
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function product(){
        return $this->belongsTo(Product::class,'product_id');
    }

    public function productOption(){
        return $this->belongsTo(ProductOption::class,'topup_option_id');
    }

    public function paymentMethod(){
        return $this->belongsTo(PaymentMethod::class,'payment_method_id');
    }
}
