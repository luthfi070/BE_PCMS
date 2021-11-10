<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContractorEquipmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contractor_equipment', function (Blueprint $table) {

            $table->id();
            $table->string('EquipmentName');
            $table->integer('ProjectID')->unsigned();
            $table->bigInteger('BusinessPartnerID')->unsigned();
            $table->integer('UnitID')->unsigned();
            $table->foreign('ProjectID')->references('ProjectID')->on('projects')->onUpdate('cascade')
            ->onDelete('cascade');
            $table->foreign('BusinessPartnerID')->references('id')->on('BussinessPartner')->onUpdate('cascade')
            ->onDelete('cascade');
            $table->date('MobilizationDate');
            $table->date('DemobilizationDate');



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
        Schema::dropIfExists('contractor_equipment');
    }
}
