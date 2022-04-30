<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentDeductionItem extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_deduction_item', function (Blueprint $table) {
            $table->id();
            $table->string('DeductionItem');
            $table->integer('Value');
            $table->integer('type');
            $table->bigInteger('PaymentID')->unsigned();
            $table->timestamps();
            $table->foreign('PaymentID')
            ->nullable()->constrained()
            ->references('id')
            ->on('payment_certificate')
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
        Schema::dropIfExists('payment_deduction_item');
    }
}
