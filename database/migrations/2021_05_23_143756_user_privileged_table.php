<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UserPrivilegedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('UserPrivileged', function (Blueprint $table) {
            $table->id();
            $table->string('UserPrivileged');
            $table->bigInteger('PrivilegedNameID')->unsigned();
            $table->foreign('PrivilegedNameID')->references('id')->on('PrivilegedName')->onUpdate('cascade')
            ->onDelete('cascade');
            $table->integer('status')->unsigned();
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
        Schema::dropIfExists('UserPrivileged');
    }
}
