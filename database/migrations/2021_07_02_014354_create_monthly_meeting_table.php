<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMonthlyMeetingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('monthly_meeting', function (Blueprint $table) {
            $table->id();
            $table->integer('ProjectID')->nullable()->unsigned();
            $table->date('meeting_date');
            $table->text('subject');
            $table->text('agenda');
            $table->text('file');
            $table->text('attendee');
            $table->timestamps();

            $table->foreign('ProjectID')
            ->nullable()->constrained()
            ->references('ProjectID')
            ->on('projects')
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
        Schema::dropIfExists('monthly_meeting');
    }
}
