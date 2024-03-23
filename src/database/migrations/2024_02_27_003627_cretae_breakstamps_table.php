<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CretaeBreakstampsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('breakstamps', function (Blueprint $table) {
            $table->id();
            $table->integer('timestamp_id')->unsigned()->index();
            $table->dateTime('breakIn')->nullable();
            $table->dateTime('breakOut')->nullable();
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
        Schema::dropIfExists('breakstamps');
    }
}
