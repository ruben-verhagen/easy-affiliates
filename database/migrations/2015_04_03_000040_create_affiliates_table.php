<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAffiliatesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('affiliates', function(Blueprint $table)
		{
			$table->increments('id');
            $table->integer('user_is_id')->unsigned()->index();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->string('phone');
            $table->string('paypal_email');
            $table->string('password');
            $table->string('aff_code');
            $table->integer('aff_id');
            $table->integer('parent_aff_id')->nullable();
            $table->integer('aff_program');
            $table->string('w9_file')->nullable();
            $table->string('w9_file_original_name')->nullable();
            $table->boolean('send_confirmation')->default(0);
            $table->boolean('confirm_w9')->default(0);
            $table->boolean('send_monthly_stat')->default(0);

            $table->timestamps();
            $table->foreign('user_is_id')->references('id')->on('users_infusionsoft')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('affiliates');
	}

}
