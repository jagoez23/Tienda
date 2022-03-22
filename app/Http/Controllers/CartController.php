<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Darryldecode\Cart\Facades\CartFacade;

use App\Models\Product;

class CartController extends Controller
{
    public function shop() {
        $products = Product::all();
        /*return view('shop',compact('products'));*/
        return view('shop')->with('E-COMERCE | CART')->with(['products' => $products]);

    }

    public function cart() {
        $cartCollection = CartFacade::getContent();
        return view('cart')->with('E-COMERCE | CART')->with(['cartCollection' => $cartCollection]);
    }

    public function add(Request$request){
        CartFacade::add(array(
            'id' => $request->id,
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'attributes' => array(
                'image' => $request->image,
            )
        ));
        return redirect()->route('cart.index')->with('success_msg', 'Item is Added to Cart!');
    }


}
