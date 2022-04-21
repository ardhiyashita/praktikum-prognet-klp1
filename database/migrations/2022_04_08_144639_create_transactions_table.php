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
            $table->timestamp('timeout');
            $table->string('address');
            $table->string('regency');
            $table->string('province');
            $table->double('total')->default(0);
            $table->double('shipping_cost')->default(0);
            $table->double('sub_total')->default(0);
            $table->foreignId('user_id');
            $table->foreignId('courier_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('courier_id')->references('id')->on('couriers');
            $table->string('proof_of_payment');
            $table->timestamps();
            $table->enum('status', ['waiting', 'proccess', 'success'])->default('waiting');
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
