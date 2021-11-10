<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIssueManagementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('issue_management', function (Blueprint $table) {
            $table->id();
            $table->integer('ProjectID')->nullable()->unsigned();
            $table->date('raised_date');
            $table->integer('initiated_by')->unsigned();
            $table->integer('assign_to')->unsigned();
            $table->text('description');
            $table->string('priority');
            $table->string('status');
            $table->date('due_date');
            $table->date('closed_date')->nullable();
            $table->text('resolution')->nullable();
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
        Schema::dropIfExists('issue_management');
    }
}
