<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ProductProviders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_providers', function (Blueprint $table) {
            $table->id('idProductProviders');
            $table->foreignId('idProduct');
            $table->foreignId('idProvider');
            $table->float('price', 8, 2);
            $table->date('creation_date');
            $table->date('update_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_providers');
    }
}
