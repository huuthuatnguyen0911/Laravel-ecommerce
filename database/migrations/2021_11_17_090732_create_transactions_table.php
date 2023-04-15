<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('transactions_user_id')->nullable();
            $table->string('transactions_name')->nullable();
            $table->string('transactions_phone')->nullable();
            $table->string('transactions_address')->nullable();
            $table->string('transactions_email')->nullable();
            $table->string('transactions_note')->nullable();
            $table->decimal('transactions_price',20,2)->nullable();
            $table->timestamp('transactions_date')->nullable();
            $table->string('transactions_method')->nullable();
            $table->integer('transactions_status')->default(0)->nullable();
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
        Schema::dropIfExists('transactions');
    }
}
