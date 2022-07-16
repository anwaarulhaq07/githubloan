<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBalloonInstallmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('balloon_installments', function (Blueprint $table) {
            $table->id();
            $table->string('actual_num_amount')->nullable();
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('balloon_id');
            $table->integer('install_id')->nullable();
            $table->integer('type')->nullable();
            $table->string('status')->nullable();
            $table->string('late_fee')->nullable();
            $table->string('schedule_payment')->nullable();
            $table->string('total_payment')->nullable();
            $table->string('principal')->nullable();
            $table->string('interest')->nullable();
            $table->string('additional_principal')->nullable();
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
        Schema::dropIfExists('balloon_installments');
    }
}
