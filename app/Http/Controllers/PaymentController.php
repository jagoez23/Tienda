<?php

namespace App\Http\Controllers;

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
        //dd(\Cart::getTotal());
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
            'returnUrl'=>'http://127.0.0.1:8000'
        ];
        $webcheckoutService=$this->webcheckoutService->createSession($data);
        //dd($webcheckoutService['processUrl']);
        return redirect($webcheckoutService['processUrl']);
    }


}
