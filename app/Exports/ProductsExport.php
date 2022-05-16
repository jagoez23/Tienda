<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;

class ProductsExport implements FromCollection
{
    public function collection()
    {
        return Product::all();
    }
}

/*class ProductsExport implements FromQuery
{
    use Exportable;
    protected $product;

    public function __construct($products)
    {
        $this->products=$products;
    }

    public function query()
    {
        return Product::query()->whereKey($this->products);
    }
}*/
