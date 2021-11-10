<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMobilizationDatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mobilization_dates', function (Blueprint $table) {
            $table->id();
            $table->integer('CurrentManMonth');
            $table->integer('Schedule');
            $table->integer('ProjectID')->unsigned();
            $table->integer('BusinessPartnerID')->unsigned();
            $table->integer('PersonilID')->unsigned();
            $table->integer('PositionCatID')->unsigned();
            $table->integer('PositionID')->unsigned();
            $table->date('StarDateMobilization');
            $table->date('EndDateMobilization');

            
            
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
        Schema::dropIfExists('mobilization_dates');
    }
}
