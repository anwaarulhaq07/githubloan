<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBalloonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('balloons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('bank_id')->nullable();
            $table->string('parent_id')->nullable();
            $table->float('amount')->nullable();
            $table->float('downpayment')->nullable();
            $table->float('extra_fee')->nullable();
            $table->float('total_paid')->nullable();
            $table->float('total_profit')->nullable();
            $table->float('percentage')->nullable();
            $table->string('balloon_period')->nullable();
            $table->string('loan_terms')->nullable();
            $table->string('property_address')->nullable();
            $table->string('starttime')->nullable();
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
        Schema::dropIfExists('balloons');
    }
}
