<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmpresasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empresas', function (Blueprint $table) {
            $table->id('id');
            $table->string('emp_nome');

            $table->uuid('uuid');
            $table->string('db_servidor');
            $table->string('db_base')->unique();
            $table->string('db_usuario');
            $table->string('db_senha');
            $table->string('db_host')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('empresas');
    }
}
