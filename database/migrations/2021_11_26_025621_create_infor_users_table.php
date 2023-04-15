<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInforUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('infor_users', function (Blueprint $table) {
            $table->id();
            $table->integer('id_user');
            $table->string('id_province')->nullable();
            $table->string('id_district')->nullable();
            $table->string('id_ward')->nullable();
            $table->string('street')->nullable();
            $table->string('phone')->nullable();
            $table->timestamp('date_birth')->nullable();
            $table->string('content')->nullable();
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
        Schema::dropIfExists('infor_users');
    }
}
