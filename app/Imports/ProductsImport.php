<?php

namespace App\Imports;

use App\Models\Product;
use GuzzleHttp\Handler\Proxy;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterImport;
use Throwable;


class ProductsImport implements 
    ToModel, 
    WithHeadingRow, 
    SkipsOnError, 
    WithValidation, 
    SkipsOnFailure,
    WithBatchInserts,
    WithChunkReading,
    ShouldQueue,
    WithEvents
    
{
    use Importable, SkipsErrors, SkipsFailures, RegistersEventListeners;

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

    public function rules(): array
    {
        return [
            'name' => ['required','string'],
            'description' => ['required','string'],
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
