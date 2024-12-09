<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tests;
use Carbon\Carbon;
use App\Models\Product;

class TestsController extends Controller
{
    public function store(Request $request)
    {
        // Log the incoming request data for debugging
        $validated = $request->validate([
            'sales' => 'required|array',
            'sales.*.id' => 'required|integer',                  // Adjusted to reflect the expected field
            'sales.*.newStocks' => 'required|integer',          // Required newStocks field
            'sales.*.product_img_url' => 'required|string',     // Required image URL field
            'sales.*.quantity' => 'required|integer',           // Required quantity field
            'sales.*.stocks' => 'required|integer',             // Required stocks field
        ]);
    
        $specificdate = Carbon::create(2024, 11, 1);
        
        foreach($validated['sales'] as $sale){
            $product = Product::find($sale['id']);
            $totalprice = $product->product_price * $sale['quantity'];
            Tests::create([
                'product_id' => $sale['id'],
                'quantity' => $sale['quantity'],
                'total_price' => $totalprice,
                'sale_date' => $specificdate,
            ]);

            if($product){
                $product->stocks = $sale['newStocks'];
                $product->save();
            }
        }

        return response()->json(['message' => 'Sales recorded successfully'], 201);
    }
}