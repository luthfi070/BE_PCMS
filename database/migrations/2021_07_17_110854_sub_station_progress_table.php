<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SubStationProgressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_station_progress', function (Blueprint $table) {
            $table->id();
            $table->string('itemID');
            $table->string('parentID');
            $table->integer('stationID')->nullable();
            $table->integer('completedStatus');
            $table->date('completionDate')->nullable();
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
        Schema::dropIfExists('sub_station_progress');
    }
}
