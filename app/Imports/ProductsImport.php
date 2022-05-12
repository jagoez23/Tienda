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
        //dd($row);
        /*return new Product([
           'name' => $row['name'],
           'description' => $row['description'],
           'price' => $row['price'],
           'image' => $row['image'],
           'status_product' => $row['status_product'],
        ]);*/
        $product = new Product();
        $product->name=$row['name'];
        $product->description=$row['description'];
        $product->price=$row['price'];
        $product->image=$row['image'];
        $product->status_product=$row['status_product'];

        $product->save();
        return $product;
    }

    public function headingRow(): int
    {
        return 1;
    }
}
