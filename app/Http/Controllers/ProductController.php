<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    //
    public function index()
    {
        $products = Product::orderByDesc('id')->get();

        return response()->json([
            'products' => $products
        ], 200);
    }
}
