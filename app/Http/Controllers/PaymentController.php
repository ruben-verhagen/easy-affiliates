<?php namespace App\Http\Controllers;

use App\Affiliate;
use App\Payment;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Database\Eloquent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller {

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{

	}

	/**
	 * Validates Paypal IPN and updates the status.
	 *
	 * @return Response
	 */
	public function paypal(Request $request)
	{
        if ($request->status != 'COMPLETED') {
            abort(404, 'Not Found.');
            return;
        }
        $payment = Payment::where('payment_key', '=', $request->pay_key)->first();
        if ($payment) {
            $payment -> status = 1;
            $payment -> ipn_result = json_encode($request->all());
            $payment -> save();
            echo 'success';
        } else {
            abort(404, 'Not Found.');
        }
    }

}