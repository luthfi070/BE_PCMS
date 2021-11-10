<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->increments('ProjectID');
            $table->string('ProjectName');
            $table->string('ProjectOwner');
            $table->string('ProjectDesc');
            $table->string('ProjectManager');
            $table->integer('ContractAmount');
            $table->integer('Length')->nullable();
            $table->date('CommencementDate')->nullable();
            $table->date('CompletionDate')->nullable();
            $table->integer('ProjectDuration')->nullable();
            $table->integer('setDefault')->default('0');
            $table->string('CurrencyType');

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
        Schema::dropIfExists('projects');
    }
}
