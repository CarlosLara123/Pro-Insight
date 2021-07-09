<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ContainerProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('container_products', function (Blueprint $table) {
            $table->id('idContainerProducts');
            $table->foreignId('idContainer');
            $table->foreignId('idProduct');
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
        Schema::dropIfExists('container_products');
    }
}
