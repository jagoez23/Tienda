<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
   
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['admin','user'])->default('user');
            $table->boolean('active_user')->default(true);
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
        });
    }
};
