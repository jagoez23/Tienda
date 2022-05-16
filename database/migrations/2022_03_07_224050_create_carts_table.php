<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up()
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product');
            $table->unsignedBigInteger('user');
            $table->integer('quantity');
            $table->float('price');
            $table->unsignedBigInteger('user_id');
            $table->foreign('product')->references('id')->on('products');
            $table->foreign('user')->references('id')->on('users');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('carts');
    }
};
