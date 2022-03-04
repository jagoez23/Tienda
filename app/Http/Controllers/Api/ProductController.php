<?php

namespace App\Http\Controllers\Api;

use App\Actions\StoreProductImagesAction;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use GuzzleHttp\Handler\Proxy;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductController extends Controller
{
    
    public function index(Request  $request): LengthAwarePaginator
    {
        $per_page = $request -> per_page;
        return Product::paginate($per_page);
    }

    
    public function store(Request $request)
    {
        $product = new Product;
        $product-> create($request->all());

    }

    
    public function show(int $id): Product
    {
        $product = Product::find($id);
        return  $product;
    }

    
    public function update(Request $request, int $id): void
    {
        
        $product= Product::find($id);
        $product-> update($request->all());

    }

    
    public function destroy(int $id): void
    {
        $product = Product::find($id);
        $product -> delete();
    }
}
