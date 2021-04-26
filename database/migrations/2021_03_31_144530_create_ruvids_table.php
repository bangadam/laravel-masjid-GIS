<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRuvidsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ruvids', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->string('address')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->string('link')->nullable();
            $table->string('pengurus')->nullable();
            $table->string('imam')->nullable();
            $table->string('khatib')->nullable();
            $table->string('remas')->nullable();
            $table->string('muazin')->nullable();
            $table->string('luasTanah')->nullable();
            $table->string('luasBangunan')->nullable();
            $table->string('dayaTampung')->nullable();
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
        Schema::dropIfExists('ruvids');
    }
}
