<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Sales;
use App\Models\Product;
use App\Models\Tests;
use Carbon\Carbon;


class TestController extends Controller
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
        }

        return response()->json(['message' => 'Sales recorded successfully'], 201);
    }
} 