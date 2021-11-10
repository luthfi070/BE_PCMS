<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonilsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Personil', function (Blueprint $table) {
            $table->id('id');
            $table->integer('BussinessPartnerID');
            $table->string('PersonilName');
            $table->string('Address');
            $table->string('Postzip');
            $table->integer('CountryID');
            $table->integer('CityID');
            $table->bigInteger('Phone');
            $table->bigInteger('Hp');
            $table->string('Email');
            $table->integer('PositionID');

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
        Schema::dropIfExists('personils');
    }
}
