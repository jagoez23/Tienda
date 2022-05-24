<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductApiController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return response()->json(['products'=>$products]);
    }

    public function show($id)
    {
        $products = Product::find($id);
        if($products)
        {
            return response()->json(['products'=>$products]);
        
        }else{
            return response()->json(['message'=>'Producto no encontrado']);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:190',
            'description' => 'required|max:190',
            'price' => 'required',
            'status_product' => 'required',
            'image' => 'required'
        ]);
        $products = new Product();
        $products -> name = $request -> name;
        $products -> description = $request -> description;
        $products -> price = $request -> price;
        $products -> status_product = $request -> status_product;
        $products -> image = $request -> image;
        $products -> save();

        return response()->json([
            'status' => 1,
            'messagge' => "Producto creado con éxito!"
        ]);   
    }
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:190',
            'description' => 'required|max:190',
            'price' => 'required',
            'status_product' => 'required',
            'image' => 'required'
        ]);
        $products = Product::find($id);
        if($products)
        {
            $products -> name = $request -> name;
            $products -> description = $request -> description;
            $products -> price = $request -> price;
            $products -> status_product = $request -> status_product;
            $products -> image = $request -> image;
            $products -> update();

            return response()->json([
                'status' => 1,
                'messagge' => "Producto actualizado con éxito!"
            ]);
        }else{
            return response()->json(['message'=>'Producto no encontrado']);
        }
    }

    public function destroy($id)
    {
        $products = Product::find($id);
        if($products)
        {
            $products->delete();
            return response()->json([
                'status' => 1,
                'messagge' => "Producto eliminado con éxito!"
            ]);
        }else{
            return response()->json(['message'=>'Producto no encontrado']);
        }
    }
}
