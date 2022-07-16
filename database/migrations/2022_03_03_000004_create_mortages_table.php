<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMortagesTable extends Migration
{
    public function up()
    {
        Schema::create('mortages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade'); 
            $table->string('bank_id')->nullable();           
            $table->string('parent_id')->nullable();           
            $table->float('loandamoutn')->nullable();
            $table->float('downpayment')->nullable();
            $table->float('extra_fee')->nullable();
            $table->float('total_paid')->nullable();
            $table->float('total_profit')->nullable();
            $table->float('percentage')->nullable();
            $table->string('loan_terms')->nullable();
            $table->string('property_address')->nullable();
            $table->string('start_date')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
