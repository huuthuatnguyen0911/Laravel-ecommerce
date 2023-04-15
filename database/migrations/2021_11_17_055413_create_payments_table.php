<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_id')->nullable();
            $table->string('user_id')->nullable();
            $table->decimal('money',20,2)->nullable()->comment('số tiền thanh toán');
            $table->string('transaction_code')->nullable();
            $table->string('note')->nullable()->comment('Nội dung thanh toán');
            $table->string('vnp_response_code', 255)->nullable()->comment('Mã phản hồi');
            $table->string('code_vppay', 255)->nullable()->comment('Mã giao dịch vnpay');
            $table->string('code_bank', 255)->nullable()->comment('Mã ngân hàng');
            $table->datetime('time')->nullable()->comment('Thời gian chuyển khoảng');
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
        Schema::dropIfExists('payments');
    }
}
