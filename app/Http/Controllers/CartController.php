<?php

namespace App\Http\Controllers;

use App\Models\Product;

use Darryldecode\Cart\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;

class CartController extends Controller
{
    public function shop(Request $request)
    {
        $texto=trim($request->get('texto'));
        $products=DB::table('products')
                    ->select('id', 'name', 'description', 'price', 'image')
                    ->where('name', 'LIKE', '%'.$texto.'%')
                    ->orWhere('price', 'LIKE', '%'.$texto.'%')
                    ->orWhere('description', 'LIKE', '%'.$texto.'%')
                    ->orderBy('name', 'asc')
                    ->paginate(4);
        return view('shop', compact('products', 'texto'));
    }
    
    public function cart()
    {
        $cartCollection = \Cart::getContent();
        return view('cart', compact('cartCollection'));
    }

    public function add(Request $request, int $id)
    {
        /*dd($request->all(),$id);*/
        \Cart::add([
            'id' => $id,
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'attributes' => array(
            'image' => $request->image,
            )
        ]);
        return redirect()->route('cart')->with('succes_msg', 'Producto agregado correctamente');
    }

    public function update(Request $request)
    {
        \Cart::update(
            $request->id,
            [
            'quantity' => [
                'relative' => false,
                'value' => $request->quantity
            ],
        ]
        );
        session()->flash('succes', 'Item Cart is Updated Successfully !');
        return redirect()->route('cart');
    }

    public function remove(Request $request)
    {
        \Cart::remove($request->id);
        session()->flash('success', 'Item Cart Remove Successfully !');
        return redirect()->route('cart');
    }

    public function clear()
    {
        \Cart::clear();
        session()->flash('success', 'All Item Cart Clear Successfully !');
        return redirect()->route('cart');
    }
}
