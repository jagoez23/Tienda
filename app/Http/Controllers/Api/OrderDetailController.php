<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\OrdersDetails;

class OrderDetailController extends Controller
{
    public function index(Request $request)
    {
        $per_page = $request -> per_page;
        //dd(auth()->user());
        return OrdersDetails::paginate($per_page);
        
    }

    public function show(int $id)
    {
        $order = OrdersDetails::find($id);
        return $order;
    }
}
