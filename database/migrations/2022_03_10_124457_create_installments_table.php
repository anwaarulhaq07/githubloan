<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInstallmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('installments', function (Blueprint $table) {
            $table->id();
            $table->string('mortage_id');
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('install_id')->nullable();
            $table->string('status')->nullable();
            $table->string('payment_dues')->nullable();
            $table->string('late_fee')->nullable();
            $table->string('interest_dues')->nullable();
            $table->string('principal_dues')->nullable();
            $table->string('balance')->nullable();
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
        Schema::dropIfExists('installments');
    }
}
