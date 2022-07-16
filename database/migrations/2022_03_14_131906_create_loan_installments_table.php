<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoanInstallmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loan_installments', function (Blueprint $table) {
            $table->id();
            $table->string('loan_id')->nullable();
            $table->string('install_id')->nullable();
            $table->string('status')->nullable();
            $table->string('begin_balance')->nullable();
            $table->string('late_fee')->nullable();
            $table->string('interest_dues')->nullable();
            $table->string('principal_dues')->nullable();
            $table->string('end_balance')->nullable();
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
        Schema::dropIfExists('loan_installments');
    }
}
