<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class WbsHistoryTable extends Migration
{
    public function up()
    {
        //
        Schema::create('wbs_history', function (Blueprint $table) {
            $table->id();
            $table->integer('actualWbsID');
            $table->string('itemName');
            $table->string('parentItem')->nullable();
            $table->text('hasChild')->nullable();
            $table->integer('qty')->nullable();
            $table->integer('price')->nullable();
            $table->date('startDate');
            $table->date('endDate');
            $table->integer('amount')->nullable();
            $table->double('weight', 15, 8)->nullable();

            $table->integer('ProjectID')->nullable()->unsigned();
            $table->bigInteger('unitID')->nullable()->unsigned();
            $table->bigInteger('contractorID')->nullable()->unsigned();
            $table->bigInteger('CurrencyID')->nullable()->unsigned();
            $table->integer('level');
            $table->integer('parentLevel');

            $table->foreign('CurrencyID')
            ->nullable()->constrained()
            ->references('id')
            ->on('Currency')
            ->onUpdate('cascade')
            ->onDelete('cascade');

            $table->foreign('ProjectID')
            ->nullable()->constrained()
            ->references('ProjectID')
            ->on('projects')
            ->onUpdate('cascade')
            ->onDelete('cascade');

            $table->foreign('unitID')
            ->nullable()->constrained()
            ->references('id')
            ->on('unit')
            ->onUpdate('cascade')
            ->onDelete('cascade');

            $table->foreign('contractorID')
            ->nullable()->constrained()->references('id')
            ->on('BussinessPartner')
            ->onUpdate('cascade')
            ->onDelete('cascade');
            $table->timestamps();

            $table->integer('Created_By');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::dropIfExists('wbs_history');
    }
}
