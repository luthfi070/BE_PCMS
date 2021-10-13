<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class VisualProgressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visual_progress', function (Blueprint $table) {
            $table->id();
            $table->string('itemVisualName')->nullable();
            $table->integer('itemID')->nullable();
            $table->integer('contractorID');
            $table->integer('projectID');
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
        Schema::dropIfExists('visual_progress');
    }
}
