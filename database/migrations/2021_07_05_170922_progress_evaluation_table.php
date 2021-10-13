<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ProgressEvaluationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('progress_evaluation', function (Blueprint $table) {
            $table->id();
            $table->date('periode');
            $table->string('progressName');
            $table->integer('estimatedQty');
            $table->integer('accumulatedLastMonthQty')->nullable();
            $table->integer('thisMonthQty');
            $table->integer('accumulatedThisMonthQty');
            $table->integer('amount')->nullable();
            $table->double('weight', 15, 8)->nullable();

            $table->bigInteger('contractorID')->nullable()->unsigned();
            $table->integer('ProjectID')->nullable()->unsigned();
            $table->bigInteger('ItemID')->nullable()->unsigned();
            $table->bigInteger('docID')->nullable()->unsigned();

            $table->foreign('ItemID')
            ->nullable()->constrained()
            ->references('id')
            ->on('actual_wbs');

            $table->foreign('docID')
            ->nullable()->constrained()
            ->references('id')
            ->on('documents')
            ->onUpdate('cascade')
            ->onDelete('cascade');

            $table->foreign('ProjectID')
            ->nullable()->constrained()
            ->references('ProjectID')
            ->on('projects')
            ->onUpdate('cascade')
            ->onDelete('cascade');

            $table->foreign('contractorID')
            ->nullable()->constrained()->references('id')
            ->on('BussinessPartner')
            ->onUpdate('cascade')
            ->onDelete('cascade');

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
        Schema::dropIfExists('progress_evaluation');
    }
}
