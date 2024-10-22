<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Auth\Events\Validated;

class ProductController extends Controller
{

    // public function create(){
    
    //     return view('products.create');
    // }
    public function store(Request $request){
        $data = $request->validate([
            'product_name' => 'required',
            'product_price' => 'required|decimal:0,2',
            'category' => 'required'
        ]);
        $newProduct = Product::create($data);
        return redirect(route('product.create'));
    }

    public function calltable(){
        $products = Product::all();
        return response()->json($products);
    }

    public function update(Request $request){
        $validated = $request->validate([
            'id' => 'required|integer',
            'name' => 'required|string|max:255',
            'price' => 'required',
            'desc' => 'required|string',
            'stocks' => 'required|integer',
            'category' => 'required|string',
            'image' => 'nullable|string'
        ]);
        $product = Product::find($validated['id']);

        $product->product_name = $validated['name'];
        $product->desc = $validated['desc'];
        $product->product_price = $validated['price'];
        $product->stocks = $validated['stocks'];
        $product->img_url = $validated['image'];

        $product->save();
        return response()->json(['message' => 'Product updated successfully'] , 201);
        // return response()->json(['message' => 'Product updated successfully', 'product' => $product] , 201);
        
        
    }

    public function create(Request $request){

        $validated = $request->validate([
            'name' => 'required|string',
            'price' => 'required',
            'desc' => 'required|string',
            'stocks' => 'required|integer',
            'category' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp'
        ]);

       $product = Product::create([
            'product_name' => $validated['name'],
            'product_price' => $validated['price'],
            'desc' => $validated['desc'],
            'stocks' => $validated['stocks'],
            'category' => $validated['category'],
        ]);

        if($request->hasFile('image')){
            $file = $request->file('image');
            $destinationPath = '/Users/runielle/Desktop/DSA Frontend/dsafrontend/public/images/';
            $file->move($destinationPath, $file->getClientOriginalName());
            $product->update(['img_url' => './images/' . $file->getClientOriginalName()]); 
        }

    return response()->json(['message' => 'Product created successfully', 'product' => $product], 201);

    }

    //Delete Snippet i just need to grab an ID using POST
    public function destroy(Request $request)
    {   
        $validated = $request->valudate([
            'id' => 'required|integer',
        ]);
        // Find the product by ID
        $product = Product::find($validated['id']);
        
        if ($product) {
            $product->delete();
            return response()->json(['message' => 'Product deleted successfully'], 201);
        }

        return response()->json(['message' => 'Product not found'], 404);
    }

}