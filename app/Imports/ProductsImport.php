<?php

namespace App\Imports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Illuminate\Contracts\Queue\ShouldQueue;


class ProductsImport implements 
    ToModel, 
    WithHeadingRow,
    SkipsOnError,
    WithValidation,
    SkipsOnFailure,
    WithBatchInserts,
    WithChunkReading,
    ShouldQueue
     
{
    use Importable, SkipsErrors, SkipsFailures;

    public function model(array $row)
    {
        
              return new Product([
                'name' => $row['name'],
                'description' => $row['description'],   
                'price' => $row['price'],
                'image' => $row['image'],
                'status_product' => $row['status_product']
            ]);   
    }

    public function rules(): array
    {
        return [
            'name' => ['required','string','unique:products,name'],
            'description' => ['required'],
            'price' => ['required','int'],
            'image' => ['required'],
            'status_product' => ['required','int'],
        ];
    }

    public function batchSize(): int
    {
        return 1000;
    }

    public function chunkSize(): int
    {
        return 1000;
    }
    
  
}
