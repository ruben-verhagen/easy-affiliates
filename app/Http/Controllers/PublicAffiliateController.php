<?php namespace App\Http\Controllers;

use App\Affiliate;
use App\Payment;
use App\UserInfusionsoft;
use iSDK;
use Illuminate\Database\Eloquent;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class PublicAffiliateController extends Controller {

    /**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{

	}

	/**
	 * Show the affiliate dashboard to the user.
	 *
	 * @return Response
	 */
	public function index(Request $request, $link, $app_name, $aff_code)
	{
        $affiliate_row = Affiliate::where('external_link', '=', $link)->first();
        if ($affiliate_row == null) {
            return redirect('error');
        }

        //$user_infusionsoft = UserInfusionsoft::where('app_name','=', $app_name)->first();
        $user_infusionsoft = $affiliate_row->infusionsoft_user;
        $app_infusionsoft = new iSDK();
        if ( !$app_infusionsoft->cfgCon($user_infusionsoft->app_name, $user_infusionsoft->app_apikey) ) {
            return redirect('error');
        }

        $affiliate_id = $affiliate_row->aff_id;

        $payout = 0;
        $payment_sum = DB::table('payments')
            ->select(DB::raw('sum(amount) as amount'))
            ->where('affiliate_id', '=', $affiliate_row->id)
            ->where('status', '=', 1)
            ->first();

        if ($payment_sum) $payout = $payment_sum->amount;

        $payments = Payment::where('affiliate_id', '=', $affiliate_row->id)->where('status', '=', 1)->get();

        $aff_fields = array('Id', 'AffCode', 'AffName', 'ContactId', 'ParentId', 'PayoutType', 'SalePercent', 'Status');
        $query = array('Id' => $affiliate_id);
        $results = $app_infusionsoft->dsQuery("Affiliate", 1, 0, $query, $aff_fields);
        if (count($results) < 1) {
            return redirect('/')->with('error', 'No affiliate has been found.');
        }

        $affiliate = $results[0];

        $start = date('Ymd\TH:i:s', mktime(00,00,00,1,01,2014));
        $end = date('Ymd\TH:i:s');
        $clawbacks = $app_infusionsoft->affClawbacks($affiliate_id, $start, $end);
        $commissions = $app_infusionsoft->affCommissions($affiliate_id, $start, $end);
        $payouts = $app_infusionsoft->affPayouts($affiliate_id, $start, $end);
        $total = $app_infusionsoft->affRunningTotals(array($affiliate_id));
        $total_record = $total[0];
        $amount = $total_record['RunningBalance'] - $payout;

        return view('affiliates.public', compact( 'affiliate', 'payments', 'total_record', 'payout', 'affiliate_row', 'clawbacks', 'commissions', 'payouts', 'amount' ));
	}

    public function uploadW9(Request $request, $link, $app_name, $aff_code)
    {
        $affiliate_row = Affiliate::where('external_link', '=', $link)->first();
        if ($affiliate_row == null) {
            return redirect('error');
        }

        //$user_infusionsoft = UserInfusionsoft::where('app_name','=', $app_name)->first();
        $user_infusionsoft = $affiliate_row->infusionsoft_user;
        $app_infusionsoft = new iSDK();
        if ( !$app_infusionsoft->cfgCon($user_infusionsoft->app_name, $user_infusionsoft->app_apikey) ) {
            return redirect('error');
        }

        $file = $request->file('w9file');
        if ($file) {
            $extension = $file->getClientOriginalExtension();
            $mimeType =  $file->getMimeType();
            if (strtolower($extension) != 'pdf' || $mimeType != 'application/pdf') {
                return redirect(URL::to('aff/' . $link . '/' . $app_name . '/' . $aff_code))->with('error', 'You can upload pdf files only.');
            }
            Storage::disk('local')->put($file->getFilename().'.'.$extension,  File::get($file));

            $affiliate_row->w9_file_original_name = $file->getClientOriginalName();
            $affiliate_row->w9_file = $file->getFilename().'.'.$extension;
            $affiliate_row->save();
            return redirect(URL::to('aff/' . $link . '/' . $app_name . '/' . $aff_code))->with('success', 'Congratulations! Your W9 is uploaded.');
        }
        return redirect(URL::to('aff/' . $link . '/' . $app_name . '/' . $aff_code))->with('error', 'No file is selected.');



    }



}