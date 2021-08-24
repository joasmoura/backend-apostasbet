<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Pais extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pais', function (Blueprint $table) {
            $table->id('id');
            $table->string('ps_nome');
            $table->string('ps_nome_pt');
            $table->string('ps_sigla');
            $table->integer('ps_bacen');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pais');
    }
}
