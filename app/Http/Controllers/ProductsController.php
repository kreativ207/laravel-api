<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

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
}
