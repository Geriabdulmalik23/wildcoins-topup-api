<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'product_id',
        'topup_option_id',
        'payment_method_id',
        'user_game_id',
        'server',
        'qr_code_url',
    ];
}
