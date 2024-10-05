<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sales;
use App\Models\Product;

class SalesController extends Controller
{
    public function goToSales(){
        $products = Product::all();
        return view('products.sales' , ['products' => $products]);
    }
    public function addToSales(Request $request){
        $request->validate([
        'product_id' => 'required',
        'quantity' => 'required|numeric|int',
        'sale_date' => 'required|date',
       ]);

       $product = Product::find($request->product_id);
       $totalprice = $product->product_price * $request->quantity;

       $salesData = [
        'product_id' => $request->product_id,
        'quantity' => $request->quantity,
        'total_price' => $totalprice,
        'sale_date' => $request->sale_date
       ];

       Sales::create($salesData);

       return redirect(route('sales.history'))->with('success', 'Sale Recorded');
    }
}