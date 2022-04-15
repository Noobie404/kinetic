<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bills', function (Blueprint $table) {
            $table->increments('id', true);;
            $table->string('bill_name');
            $table->timestamp('bill_date');
            $table->float('amount');
            $table->integer('status')->default(0);
            $table->float('due');
            $table->float('paid');
            $table->integer('created_by');
            $table->integer('f_customer_no');
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
        Schema::dropIfExists('bills');
    }
}
