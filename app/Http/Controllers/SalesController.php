<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Sales;
use App\Models\Product;
use Carbon\Carbon;

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

    public function callSales(){

        $specificdate = Carbon::create(2024, 10, 1); //Current Date Simulation
        $last28days = $specificdate->copy()->subDays(28); //get the last 28 days of the $specific days
    
        $sales = Sales::with('product')->whereBetween('sale_date',[$last28days, $specificdate])->orderBy('sale_date', 'asc')->get();
        return response()->json($sales);

        //orderBy function sets everything into ascending format according to sale_date
        //where between logs 
    }

    public function callMostItemsSold(){
        $sortedSales = Sales::select('product_id', DB::raw('SUM(quantity) as total_quantity'))
        ->groupBy('product_id')
        ->orderBy('total_quantity', 'desc')
        ->with('product')
        ->get();
    
        return response()->json($sortedSales);
    }
}