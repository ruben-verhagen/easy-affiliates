<?php

use Illuminate\Database\Seeder;

class PaymentsTableSeeder extends Seeder {

	public function run()
	{

        DB::table('payments')->delete();

        //$user = \App\User::where('email','=','admin@admin.com')->first();

        $affiliate = \App\Affiliate::where('id','>', 0)->first();

        \App\Payment::create([
            'affiliate_id' => $affiliate->id,
            'payment_key' => 'AB029309',
            'amount' => 1.00,
            'pay_result' => '{}',
            'ipn_result' => '',
            'status' => 1
        ]);

    }

}
