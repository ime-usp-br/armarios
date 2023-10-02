<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDatafinalToEmprestimos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('emprestimos', function (Blueprint $table) {
            $table->timestamp('datafinal')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('emprestimos', function (Blueprint $table) {
            $table->dropColumn('datafinal');
        });
    }
}
