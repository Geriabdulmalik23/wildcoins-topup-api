<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\ResponseHelper as R;
use App\Models\Product;
use App\Models\ProductOption;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{

    public function index(Request $request)
    {
        $query = Product::query();

        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->has('category')) {
            $query->where('product_category_id', $request->get('category'));
        }
        return R::paginate($query->paginate($request->get('per_page', 10)), 'Berhasil menampilkan data');
    }


    public function home()
    {
        $data = [
            'balance' => [
                'clover' => 0,
                'energy' => 0
            ],
            'banner' => 'http://google.com',
            'game' => Product::where('product_category_id', 1)->limit(4)->get()->map(function ($item) {
                $item->image_url = url('storage/' . $item->image_url);
                return $item;
            }),
            'e_wallet' => Product::where('product_category_id', 2)->limit(4)->get()->map(function ($item) {
                $item->image_url = url('storage/' . $item->image_url);
                return $item;
            }),
            'mobile_credit' => Product::where('product_category_id', 3)->limit(4)->get()->map(function ($item) {
                $item->image_url = url('assets/' . $item->image_url);
                return $item;
            }),
        ];


        return R::success($data,'Berhasil menampilkan data Product');
    }

    public function fetchItem(Request $request){

        $validator = Validator::make($request->all(),[
            'product_id'     => 'required',
        ]);

        if($validator->fails()){
            return R::validationError($validator);
        }

        $product = ProductOption::where('product_id',$request->product_id)->get();

        return R::success($product,'Berhasil menampilkan data');

    }


}
