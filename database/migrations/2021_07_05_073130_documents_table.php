<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->string('documentName')->nullable();
            $table->string('documentType')->nullable();
            $table->string('size')->nullable();
            $table->integer('author')->unsigned();
            $table->string('status')->nullable();
            $table->text('desc')->nullable();


            $table->integer('ProjectID')->nullable()->unsigned();

            $table->foreign('ProjectID')
            ->nullable()->constrained()
            ->references('ProjectID')
            ->on('projects')
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
        //
        Schema::dropIfExists('documents');
    }
}
