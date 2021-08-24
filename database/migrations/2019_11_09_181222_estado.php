<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Estado extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estado', function (Blueprint $table) {
            $table->id('id');
            $table->string('uf_nome');
            $table->string('uf_uf');
            $table->integer('uf_ibge');
            $table->integer('uf_pais');
            $table->string('uf_ddd');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('estado');
    }
}
