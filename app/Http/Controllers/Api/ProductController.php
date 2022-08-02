<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Support\Str;
use App\Imports\UsersImport;
use Illuminate\Http\Request;
use GuzzleHttp\Handler\Proxy;
use App\Exports\ProductsExport;
use App\Imports\ProductsImport;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use App\Actions\StoreProductImagesAction;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx\Rels;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Http\Requests\ProductRequest;

class ProductController extends Controller
{
    public function index(Request  $request): LengthAwarePaginator
    {
        $per_page = $request -> per_page;
        return Product::paginate($per_page);
    }


    public function store(ProductRequest $request)
    {
        $product = new Product();
        $IdCreado = $product-> create($request->all())->id;
        /* RECEPCION IMAGEN */
        if ($request->hasFile('image')) {
            $imagen = $request->file("image");
            $nombreimagen = Str::slug($request->name)."-".time()."-tienda".".".$imagen->guessExtension();
            $ruta = public_path("img/tienda/".$IdCreado."/");
            if (!file_exists($ruta)) {
                mkdir($ruta, 0777, true);
            }
            copy($imagen->getRealPath(), $ruta.$nombreimagen);
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


    public function update(ProductRequest $request, int $id): void
    {
        $product= Product::find($id);
        $product-> update($request->all());
        /* RECEPCION IMAGEN */
        if ($request->hasFile('image')) {
            $imagen = $request->file("image");
            $nombreimagen = Str::slug($request->name)."-".time()."-tienda".".".$imagen->guessExtension();
            $ruta = public_path("img/tienda/".$id."/");
            if (!file_exists($ruta)) {
                mkdir($ruta, 0777, true);
            }
            copy($imagen->getRealPath(), $ruta.$nombreimagen);
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

    public function import(Request $request)
    {
        Excel::import(new ProductsImport(), $request->file('file'));
    }

    public function export()
    {
        return Excel::download(new ProductsExport(), 'product.xlsx');
    }
}
