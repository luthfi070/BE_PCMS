<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class VisualProgressImageTable extends Migration
{
    public function up()
    {
        Schema::create('visual_progress_image', function (Blueprint $table) {
            $table->id();
            $table->text('visualDesc');
            $table->text('imgUrl');
            $table->date('visualDate');
            $table->string('imgName');
            $table->string('imgExt');
            $table->integer('visualProgressID')->nullable();
            
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
        Schema::dropIfExists('visual_progress_image');
    }
}
