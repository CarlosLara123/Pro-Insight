<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Container extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('container', function (Blueprint $table) {
            $table->id('idContainer');
            $table->string('arrival_date');
            $table->string('destination');
            $table->integer('quantityProducts');
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
        Schema::dropIfExists('container');
    }
}
