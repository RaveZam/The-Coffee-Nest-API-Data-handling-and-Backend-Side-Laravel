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

    public function callCountedCategory()
    {
        
        $specificdate = Carbon::create(2024, 10, 1); //Current Date Simulation
        $last28days = $specificdate->copy()->subDays(28); //get the last 28 days of the $specific days
        $sortedCategory = Sales::join('products', 'sales.product_id', '=', 'products.id')  // Join products with sales
            ->select('products.category', DB::raw('SUM(sales.quantity) as category_count'))  
            ->groupBy('products.category') 
            ->orderBy('category_count', 'desc') 
            ->whereBetween('sale_date', [$last28days, $specificdate])
            ->get();
        
        return response()->json($sortedCategory);
    }
    public function callMostItemsSold(){
        
        $specificdate = Carbon::create(2024, 10, 1); //Current Date Simulation
        $last28days = $specificdate->copy()->subDays(28); //get the last 28 days of the $specific days

        $sortedSales = Sales::select('product_id', DB::raw('SUM(quantity) as total_quantity, SUM(total_price) as final_price'))
        ->groupBy('product_id')
        ->orderBy('total_quantity', 'desc')
        ->with('product')
        ->whereBetween('sale_date', [$last28days, $specificdate])
        ->get();
        return response()->json($sortedSales); 
    }

    public function callTotalSalesAndDate(){
        $specificdate = Carbon::create(2024, 10, 1); //Current Date Simulation
        $last28days = $specificdate->copy()->subDays(28); //get the last 28 days of the $specific d

        $summedSalesperDay = Sales::select('sale_date', DB::raw('SUM(total_price) AS final_price'))
        ->groupBy('sale_date')
        ->whereBetween('sale_date',[$last28days, $specificdate])
        ->orderBy('sale_date')
        ->get();

        return response()->json($summedSalesperDay);
    }

    // Calling The Previous Month Data We Need To Take, Total Gross, Total Items Sold == and then the Sales Per Week 
    // Total Gross = We Just need the Total of The whole previous month 
    // Total Items Sold = We Need the total Quantity of the whole previous Month
    // Sales Per Week, by product_id from previous month, sum all of the sales within the same sale_Date, 

     public function previousTotalGross(){
        //
     }
     public function previousTotalQuantity(){
        //
     }
     public function previousMonthSales(){
        //
     }

}

// i need to call only the sale_date and their total price per day 