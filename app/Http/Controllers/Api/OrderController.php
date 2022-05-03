<?php

namespace App\Http\Controllers\Api;


use App\Models\Order;
use Illuminate\Http\Request;
use Laravel\Ui\Presets\React;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\LengthAwarePaginator;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $per_page = $request -> per_page;
        //dd(auth()->user());
        return Order::paginate($per_page);
        
    }

    public function show(int $id)
    {
        $order = Order::find($id);
        return $order;
    }

}
