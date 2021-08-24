<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermissaosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permissoes', function (Blueprint $table) {
            $table->id('id');
            $table->string('perm_titulo');
            $table->string('perm_nome');
            $table->timestamps();
        });

        Schema::create('nivel_permissao', function (Blueprint $table) {
            $table->id('id');
            $table->unsignedBigInteger('permissao_id');
            $table->unsignedBigInteger('nivel_id');

            $table->foreign('permissao_id')
                    ->references('id')
                    ->on('permissoes')
                    ->onDelete('cascade');

            $table->foreign('nivel_id')
                    ->references('id')
                    ->on('niveis')
                    ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nivel_permissao');
        Schema::dropIfExists('permissoes');
    }
}
