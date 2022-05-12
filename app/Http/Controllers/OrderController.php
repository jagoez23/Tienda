<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\WebcheckoutService;

class OrderController extends Controller
{
    private WebcheckoutService $webcheckoutService;

    public function __construct(WebcheckoutService $webcheckoutService)
    {
        $this->webcheckoutService=$webcheckoutService;
    }
    
    public function index()
    {
        return view("orders.index");
        
    }
    public function store(Request $request)
    {
        //
    }

   
    public function show(Order $order)
    {
        $id = $order->id;
        $webcheckoutService=$this->webcheckoutService->getInformation($order->requestId);
        $order->status = $webcheckoutService['status']['status'];
        $order->save();
        return view("orders.show", compact('id'));                       
    }

    

  
}
