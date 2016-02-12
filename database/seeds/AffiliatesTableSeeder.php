<?php

use Illuminate\Database\Seeder;

class AffiliatesTableSeeder extends Seeder {

	public function run()
	{

        DB::table('affiliates')->delete();

        $user = \App\User::where('email','=','admin@admin.com')->first();
        $user_infusionsoft = \App\UserInfusionsoft::where('user_id','=',$user->id)->first();

        \App\Affiliate::create([
            'user_is_id' => $user_infusionsoft->id,
            'first_name' => 'Alex',
            'last_name' => 'Santa',
            'email' => 'aff1@yourdomain.com',
            'phone' => '00',
            'paypal_email' => 'mrabrams23-buyer@gmail.com',
            'password' => '',
            'aff_code' => 'santa',
            'aff_id' => 2,
            'aff_program' => 2,
            'send_confirmation' => false,
            'confirm_w9' => false,
            'send_monthly_stat' => false
        ]);

        \App\Affiliate::create([
            'user_is_id' => $user_infusionsoft->id,
            'first_name' => 'Mikael',
            'last_name' => 'Laine',
            'email' => 'mikael.laine211@gmail.com',
            'phone' => '01',
            'paypal_email' => 'buyer@yourdomain.com',
            'password' => '',
            'aff_code' => 'afafaf',
            'aff_id' => 6,
            'parent_aff_id' => 2,
            'aff_program' => 2,
            'send_confirmation' => false,
            'confirm_w9' => false,
            'send_monthly_stat' => false
        ]);

        \App\Affiliate::create([
            'user_is_id' => $user_infusionsoft->id,
            'first_name' => 'Test',
            'last_name' => 'User',
            'email' => 'testuser101@gmail.com',
            'phone' => '03',
            'paypal_email' => '',
            'password' => '',
            'aff_code' => 'atest',
            'aff_id' => 4,
            'parent_aff_id' => 2,
            'aff_program' => 2,
            'send_confirmation' => false,
            'confirm_w9' => false,
            'send_monthly_stat' => false
        ]);


    }

}
