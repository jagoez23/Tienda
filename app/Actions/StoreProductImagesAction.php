<?php

namespace App\Actions;

use App\Models\Product;
use Illuminate\Support\Str;

class StoreProductImagesAction
{
    public function execute(array $images, Product $product): void
    {
        foreach($images as $image) {
            $image->storeAs('product_images', (string) Str::uuid() . '_' . $image->getClientOriginalExtension(),
            config(key:'filesystem.images_disk'));
        }
    }
}    