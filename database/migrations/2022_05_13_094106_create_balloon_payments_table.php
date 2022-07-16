<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBalloonPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('balloon_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ballon_id')->references('id')->on('balloons')->onDelete('cascade');
            $table->string('install_id')->nullable();
            $table->string('parent_id')->nullable();
            $table->string('date')->nullable();
            $table->string('payment')->nullable();
            $table->string('late_fee')->nullable();
            $table->string('note')->nullable();
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
        Schema::dropIfExists('balloon_payments');
    }
}
