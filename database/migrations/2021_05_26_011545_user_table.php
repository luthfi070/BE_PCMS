<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('user', function (Blueprint $table) {
            $table->id();
            $table->string('Userfullname');
            $table->string('UserLogin');
            $table->string('UserMail');
            $table->bigInteger('UserProfile')->unsigned();
            $table->foreign('UserProfile')->references('id')->on('UserPrivileged')->constrained()
            ->onUpdate('cascade')
            ->onDelete('cascade');
            $table->integer('PrivilegedStatus');
            $table->string('password');
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
        Schema::dropIfExists('user');
    }
}
