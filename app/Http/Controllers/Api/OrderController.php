<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Helpers\ResponseHelper as R;
use App\Models\Order;
use App\Models\PaymentMethod;
use App\Models\ProductOption;
use Auth;
use Illuminate\Validation\ValidationException;

class OrderController extends Controller
{

    public function fetchPrice(Request $request){

        $validator = Validator::make($request->all(), [
            'item_id' => 'required',
        ]);

        if ($validator->fails()) {
            return R::validationError($validator);
        }

        $productOption = ProductOption::find($request->item_id);

        if (!$productOption) {
            return R::error('Data produk tidak ditemukan', 404);
        }

        $basePrice = (float) $productOption->base_price;
        $vat = (float) $productOption->vat;
        $discount = (float) $productOption->discount;

        $totalVatPrice = $basePrice * $vat / 100;
        $totalDiscountPrice = $basePrice * $discount / 100;

        $finalPrice = $basePrice + $totalVatPrice - $totalDiscountPrice;

        $data = [
            'product_id'      => (int) $productOption->product_id,
            'product_name'    => $productOption->title,
            'product_price'   => $basePrice,
            'vat'             => $vat,
            'discount'        => $discount,
            'total_vat'       => round($totalVatPrice, 2),
            'total_discount'  => round($totalDiscountPrice, 2),
            'total_price'     => round($finalPrice, 2),
        ];

        return R::success($data);
    }

    public function fetchPaymentMethod()
    {
        $payments = PaymentMethod::get();

        if(!$payments){
            return R::error();
        }

        return R::success($payments,'Payment method tersedia.');
    }

    public function createOrder(Request $request)
    {
        try {
            $validated = $request->validate([
                'product_id'        => 'required|exists:products,id',
                'product_option_id' => 'required|exists:product_options,id',
                'payment_method_id' => 'required|exists:payment_methods,id',
                'game_id'           => 'required',
                'server'            => 'nullable|string|max:10',
            ]);
        } catch (ValidationException $e) {
            return R::error('Validasi gagal', 422, $e->errors());
        }

        $order = Order::create([
            'user_id'           => Auth::id(),
            'product_id'        => $validated['product_id'],
            'topup_option_id'   => $validated['product_option_id'],
            'payment_method_id' => $validated['payment_method_id'],
            'user_game_id'      => $validated['game_id'],
            'server'            => $validated['server'] ?? '',
            'qr_code_url'       => 'localhost',
        ]);

        return R::success($order, message: 'Berhasil membuat order', status: 201);
    }
}
