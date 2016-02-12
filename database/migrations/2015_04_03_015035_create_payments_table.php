<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('payments', function(Blueprint $table)
		{
			$table->increments('id');
            $table->integer('affiliate_id')->unsigned()->index();
            $table->string('payment_key');
            $table->decimal('amount', 11, 4);
            $table->text('pay_result');
            $table->text('ipn_result');
            $table->integer('status')->unsigned()->index();
			$table->timestamps();
            $table->foreign('affiliate_id')->references('id')->on('affiliates')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('payments');
	}

}
