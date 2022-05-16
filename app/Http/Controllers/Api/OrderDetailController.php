<?php

namespace App\Http\Controllers\Api;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\OrdersDetails;
use App\Http\Controllers\Controller;

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
        return OrdersDetails::join("products", "products.id", "=", "orders_details.product_id")
                            ->join("orders", "orders.id", "=", "orders_details.order_id")
                            ->select(
                                "products.name",
                                "orders.status",
                                "orders_details.price",
                                "orders_details.quantity",
                                "orders_details.created_at"
                            )
                            ->where("orders_details.order_id", $id)
                            ->get();
    }
}
