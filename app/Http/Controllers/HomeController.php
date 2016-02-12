<?php namespace App\Http\Controllers;

use App\Affiliate;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Database\Eloquent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller {

    protected $auth;

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct(Guard $auth)
	{
        $this->auth = $auth;
        $this->middleware('auth');
        $this->middleware('user_is');
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
        $user_is = $request->user_infusionsoft;
        $app = $request->app_infusionsoft;

        $all_invoices = array();
        $returnFields = array('Id', 'AffiliateId', 'InvoiceTotal', 'TotalPaid', 'PayStatus', 'InvoiceTotal', 'Description');
        $query = array('Id' => '%');
        $page = 0;
        while(true) {
            $results = $app->dsQuery("Invoice", 1000, $page, $query, $returnFields);
            $all_invoices = array_merge($all_invoices, $results);
            if(count($results) < 1000){
                break;
            }
            $page++;
        }

        $all_affiliates = array();
        $page = 0;
        $aff_fields = array('Id', 'AffCode', 'AffName', 'ContactId', 'ParentId', 'PayoutType', 'SalePercent', 'Status');
        $query = array('Id' => '%');
        while(true) {
            $results = $app->dsQuery("Affiliate", 1000, $page, $query, $aff_fields);
            $all_affiliates = array_merge($all_affiliates, $results);
            if(count($results) < 1000) {
                break;
            }
            $page++;
        }
        $affiliates_count = count($all_affiliates);

        $total_sales = 0;
        foreach($all_invoices as $invoice) {
            if ($invoice['PayStatus']) $total_sales += $invoice['TotalPaid'];
        }

        $total_commission = 0;
        $total_payout = 0;
        $start_date = $request->start_date;
        if ($start_date == NULL) $start_date = '01/01/2015';
        $finish_date = $request->finish_date;
        if ($finish_date == NULL) $finish_date = date('m/d/Y');

        $start = $app->infuDate($start_date);
        $finish = $app->infuDate($finish_date);

        foreach($all_affiliates as &$affiliate) {
            $affiliate['commission'] = 0;
            $affiliate['payout'] = 0;
            $affiliate_id = $affiliate['Id'];

            $commissions = $app->affCommissions($affiliate_id, $start, $finish);
            foreach($commissions as $commission) {
                $affiliate['commission'] += $commission['AmtEarned'];
            }
            $total_commission += $affiliate['commission'];

            $payouts = $app->affPayouts($affiliate_id, $start, $finish);
            foreach($payouts as &$payout) {
                $affiliate['payout'] += $payout['PayAmt'];
            }

            $affiliate_row = Affiliate::where('user_is_id', '=', $user_is->id)->where('aff_id', '=', $affiliate_id)->first();
            $payment_sum = DB::table('payments')
                        ->select(DB::raw('sum(amount) as amount'))
                        ->where('affiliate_id', '=', $affiliate_row->id)
                        ->where('created_at', '>=', date("Y-m-d H:i:s", strtotime($start_date)))
                        ->where('created_at', '<=', date("Y-m-d H:i:s", strtotime($finish_date)))
                        ->where('status', '=', 1)
                        ->first();

            $payout = 0;
            if ($payment_sum) $payout = $payment_sum->amount;
            $affiliate['payout'] += $payout;
            $total_payout += $payout;
            $affiliate['balance'] = $affiliate['commission'] - $affiliate['payout'];
            $affiliate['row'] = $affiliate_row;
        }

        $total_owed = $total_commission - $total_payout;
        return view('pages.home', compact('total_sales', 'total_commission', 'start_date', 'finish_date', 'total_owed', 'affiliates_count', 'all_affiliates' ));
	}

}