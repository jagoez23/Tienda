<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdersDetails extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'product_id',
        'order_id',
        'price',
        'quantity',
        'created_at',
        'updated_at',
    ];
}
