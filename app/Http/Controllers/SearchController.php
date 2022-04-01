<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class SearchController extends Controller
{
    public function buscador(Request $request)
    {
        $products = Product::where("products", 'like', $request->texto."%")->take(10)->get();
        return view('shop', compact('products'));
    }
}
