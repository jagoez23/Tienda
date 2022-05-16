<?php

namespace App\Imports;

use App\Models\Product;
use GuzzleHttp\Handler\Proxy;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductsImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Product([
           'name' => $row['name'],
           'description' => $row['description'],
           'price' => $row['price'],
           'image' => $row['image'],
           'status_product' => $row['status_product'],
        ]);
    }

    public function headingRow(): int
    {
        return 1;
    }
}
