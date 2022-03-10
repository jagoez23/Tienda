<?php

namespace App\Http\Controllers\Api;

use App\Actions\StoreProductImagesAction;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use GuzzleHttp\Handler\Proxy;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

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
            $IdCreado = $product-> create($request->all())->id;
            /* RECEPCION IMAGEN */
            if ($request->hasFile('image')) {
                $imagen = $request->file("image");
                $nombreimagen = Str::slug($request->name)."-".time()."-tienda".".".$imagen->guessExtension();
                $ruta = public_path("img/tienda/".$IdCreado."/");
                if(!file_exists($ruta)){
                    mkdir($ruta, 0777, true);
                }
                copy($imagen->getRealPath(),$ruta.$nombreimagen);
                // actualizar imagen nombre
                $productos = DB::table('products')->where('id', $IdCreado);
                $productos->update(['image'=>$nombreimagen]);
            }
        
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
        /* RECEPCION IMAGEN */
        if ($request->hasFile('image')) {
            $imagen = $request->file("image");
            $nombreimagen = Str::slug($request->name)."-".time()."-tienda".".".$imagen->guessExtension();
            $ruta = public_path("img/tienda/".$id."/");
            if(!file_exists($ruta)){
                mkdir($ruta, 0777, true);
            }
            copy($imagen->getRealPath(),$ruta.$nombreimagen);
            // actualizar imagen nombre
            $productos = DB::table('products')->where('id', $id);
            $productos->update(['image'=>$nombreimagen]);
        }
    }

    
    public function destroy(int $id): void
    {
        $product = Product::find($id);
        $product -> delete();
    }
}
