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
            $table->foreignId('mortage_id')->references('id')->on('mortages')->onDelete('cascade');
            $table->integer('install_id')->nullable();
            $table->integer('parent_id')->nullable();
            $table->string('date')->nullable();
            $table->string('payment')->nullable();
            $table->string('late_fee')->nullable();
            $table->string('principal')->nullable();
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
        Schema::dropIfExists('payments');
    }
}
