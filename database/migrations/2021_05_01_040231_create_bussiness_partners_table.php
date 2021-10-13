<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBussinessPartnersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('BussinessPartner', function (Blueprint $table) {
            $table->id('id');
            $table->string('BussinessName');
            $table->integer('BussinessTypeID');
            $table->string('Address');
            $table->integer('CountryID');
            $table->integer('CityID');
            $table->bigInteger('Phone');
            $table->bigInteger('Fax');
            $table->bigInteger('MobilePhone');
            $table->string('Email');
            $table->string('Web');

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
        Schema::dropIfExists('BussinessPartner');
    }
}
