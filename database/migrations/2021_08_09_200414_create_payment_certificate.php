<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentCertificate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_certificate', function (Blueprint $table) {
            $table->id();
            $table->date('ReportDate');
            $table->text('Comment');
            // $table->integer('ProjectID')->nullable()->unsigned();
            // $table->bigInteger('contractorID')->nullable()->unsigned();
            $table->bigInteger('docID')->unsigned();
            $table->timestamps();
            
            $table->foreign('docID')
            ->nullable()->constrained()
            ->references('id')
            ->on('documents')
            ->onUpdate('cascade')
            ->onDelete('cascade');
            
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payment_certificate');
    }
}
