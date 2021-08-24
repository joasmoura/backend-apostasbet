w<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNivelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('niveis', function (Blueprint $table) {
            $table->id('id');
            $table->string('nivel_nome');
            $table->string('nivel_titulo');
            $table->integer('igreja_id')->nullable();
            $table->timestamps();
        });

        Schema::create('nivel_user', function (Blueprint $table) {
            $table->id('id');
            $table->unsignedBigInteger('nivel_id');
            $table->unsignedBigInteger('user_id');

            $table->foreign('user_id')
                    ->references('id')
                    ->on('users')
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
        Schema::dropIfExists('nivel_user');
        Schema::dropIfExists('niveis');
    }
}
