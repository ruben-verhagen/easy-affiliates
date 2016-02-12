<?php

use Illuminate\Database\Seeder;

class UsersInfusionsoftTableSeeder extends Seeder {

	public function run()
	{

        DB::table('users_infusionsoft')->delete();

        $user = \App\User::where('email','=','admin@admin.com')->first();

		\App\UserInfusionsoft::create([
			'user_id' => $user->id,
			'first_name' => '',
			'last_name' => '',
			'app_name' => '',
			'app_apikey' => '',
      'paypal_api_username' => '',
      'paypal_api_password' => '',
      'paypal_api_signature' => '',
      'paypal_business_account' => '',
      'paypal_app_id' => ''
		]);

	}

}
