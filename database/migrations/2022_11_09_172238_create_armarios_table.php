<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArmariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('armarios', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('numero')->nullable(false);
            $table->enum('estado', ['LIVRE', 'OCUPADO', 'BLOQUEADO'])->default('LIVRE')->nullable(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('armarios');
    }
}
