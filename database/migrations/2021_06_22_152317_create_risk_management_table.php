<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRiskManagementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('risk_management', function (Blueprint $table) {
            $table->id();
            $table->string('DescriptionRisk');
            $table->integer('ProjectID')->unsigned();
            $table->bigInteger('PersonilID')->unsigned();
            $table->foreign('ProjectID')->references('ProjectID')->on('projects')->onUpdate('cascade')
            ->onDelete('cascade');
            $table->foreign('PersonilID')->references('id')->on('Personil')->onUpdate('cascade')
            ->onDelete('cascade');
            $table->string('Rank');
            $table->date('DueDateRisk');
            $table->string('Mitigation');

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
        Schema::dropIfExists('risk_management');
    }
}
