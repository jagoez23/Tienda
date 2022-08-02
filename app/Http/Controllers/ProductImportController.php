<?php

namespace App\Http\Controllers;

use App\Imports\ProductsImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ProductImportController extends Controller
{
    public function show()
    {
         return view ('import');
    }

    public function store(Request $request)
    {
        $file = $request->file('file');
        //Excel::import(new ProductsImport, $file);
        $import = new ProductsImport;
        $import->import($file);
        //($import)->queue($file);

        //dd($import->failures());
        if($import->failures()->isNotEmpty()) {
            return back()->withFailures($import->failures());
        }
        return back()->withStatus('Importación exitosa');
    }
}
