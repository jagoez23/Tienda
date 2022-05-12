<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrdersDetails;
use Illuminate\Http\Request;
use App\Services\WebcheckoutService;


class PaymentController extends Controller
{
    private WebcheckoutService $webcheckoutService;

    public function __construct(WebcheckoutService $webcheckoutService)
    {
        $this->webcheckoutService=$webcheckoutService;
    }

    public function store(Request $request) 
    {
        $order= new Order();
        $order->user_id=auth()->user()->id;
        $order->save();

        //dd(\Cart::getContent());
        
        foreach(\Cart::getContent() as $item){
            //dd($item->id);
            $order_details= new OrdersDetails();
            $order_details->product_id=$item->id;
            $order_details->order_id=$order->id;
            $order_details->price=$item->price;
            $order_details->quantity=$item->quantity;
            $order_details->save();   
        }
        
        $data=[
            'payment'=>[
                "reference"=> "1122334455",
                "description"=>"Prueba",
                "amount"=>[
                "currency"=> "COP",
                "total"=>\Cart::getTotal()
                ],
                "allowPartial"=> false
            ],
            'expiration'=>now()->addDay(),
            'returnUrl'=>route('order.show',$order->id)
        ];
        $webcheckoutService=$this->webcheckoutService->createSession($data);
        $order->requestId = $webcheckoutService['requestId'];
        $order->processUrl = $webcheckoutService['processUrl'];
        $order->save();
        return redirect($webcheckoutService['processUrl']);
    }

}
