<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $guarded = [
        'nombre',
        'descripcion',
        'precio',
        'estado',
        'imagen',
        
    ];   
}

class FileUpload extends Model
{
    use HasFactory;
    protected $fillable = [
        'image',
        'path',
    ];     
}