<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Validator;

class ProductsController extends Controller
{
    public function showProducts()
    {
        $products = Product::all();
        return response()->json([
            'status' => true,
            'data' => $products
        ]);
    }

    public function showProduct($id)
    {
        $product = Product::find($id);
        if(!$product) {
            return response()->json([
                'status' => false,
                'message' => 'Product Not Found'
            ])->setStatusCode('404', 'Product Not Found');
        }

        return response()->json($product);
    }

    public function storeProduct(Request $request)
    {
        $request_data = $request->only(['title', 'description', 'category']);

        $validator_status = $this->validateStoreProduct($request_data);

        if($validator_status->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator_status->messages()
            ])->setStatusCode('422');
        }

        $product = Product::create([
            "title" => $request->title,
            "description" => $request->description,
            "category" => $request->category
        ]);

        return response()->json([
            'status' => true,
            'product' => $product
        ])->setStatusCode('201', 'Product is store');
    }

    public function validateStoreProduct($request_data)
    {
        $validator = Validator::make($request_data, [
            "title" => ['required', 'string'],
            "description" => ['required', 'string'],
            "category" => ['required', 'integer'],
        ]);

        return $validator;
    }
}
