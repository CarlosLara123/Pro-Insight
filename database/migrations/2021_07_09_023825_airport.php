<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Airport extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('airport', function (Blueprint $table) {
            $table->id('idAirport');
            $table->string('name');
            $table->string('ubication');
            $table->enum('maritime', ['Si', 'No']);
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
