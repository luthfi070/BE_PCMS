<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class StationProgressTable extends Migration
{
   /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('station_progress', function (Blueprint $table) {
            $table->id();
            $table->string('stationName');
            $table->string('description');
            $table->integer('itemID');
            $table->integer('ProjectID');
            $table->integer('ContractorID');
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
        Schema::dropIfExists('station_progress');
    }
}
