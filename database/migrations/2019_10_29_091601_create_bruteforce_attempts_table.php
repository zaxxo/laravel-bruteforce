<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBruteforceAttemptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bruteforce_attempts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('ident');
            $table->dateTime('attempted')->index();
            $table->index(['ident', 'attempted']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bruteforce_attempts');
    }
}
