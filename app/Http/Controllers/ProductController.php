<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{

    public function create(){
        return view('products.create');
    }

    public function store(Request $request){
        $data = $request->validate([
            'product_name' => 'required',
            'product_price' => 'required|decimal:0,2'
        ]);
        $newProduct = Product::create($data);
        return redirect(route('product.create'));
    }

    public function calltable(){
        $products = Product::all();
        return response()->json($products);
    }

}