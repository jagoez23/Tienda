<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    
    public function index()
    {
        return view("orders.index");
        
    }
    public function store(Request $request)
    {
        //
    }

   
    public function show(int $id)
    {
        $ventastotales=Order::join("orders_details","orders.id","=","orders_details.order_id")
                            ->select("orders_details.created_at","orders_details.price",
                                    "orders_details.quantity","orders.status")
                            ->where("orders.id","=",$id)        
                            ->get();
                            //dd($ventastotales);
                            return view("orders.show");

    }

  
}
