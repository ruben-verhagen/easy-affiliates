<?php namespace App\Http\Controllers;

use App\Affiliate;
use App\Payment;
use App\UserInfusionsoft;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Database\Eloquent;
use Illuminate\Http\Request;
use App\Http\Requests\AffiliateRequest;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Contracts\Mail\Mailer as MailerContract;

class AffiliateController extends Controller {

    protected $auth;

    /**
     * The mailer instance.
     *
     * @var \Illuminate\Contracts\Mail\Mailer
     */
    protected $mailer;

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct(Guard $auth, MailerContract $mailer)
	{
        $this->auth = $auth;
        $this->mailer = $mailer;
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
        $returnFields = array('Id', 'AffiliateId', 'InvoiceTotal', 'ProductSold', 'TotalPaid', 'PayStatus', 'Description');
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

        //$total_commission = 0;
        //$total_payout = 0;
        //$total_owed = 0;
        $start_date = $request->start_date;
        if ($start_date == NULL) $start_date = '01/01/2015';
        $finish_date = $request->finish_date;
        if ($finish_date == NULL) $finish_date = date('m/d/Y');

        $start = $app->infuDate($start_date);
        $finish = $app->infuDate($finish_date);

        $names_without_w9 = '';
        foreach($all_affiliates as &$affiliate) {

            $affiliate['commission'] = 0;
            $affiliate['payout'] = 0;
            $affiliate_id = $affiliate['Id'];

            $commissions = $app->affCommissions($affiliate_id, $start, $finish);
            foreach($commissions as $commission) {
                $affiliate['commission'] += $commission['AmtEarned'];
            }
            //$total_commission += $affiliate['commission'];

            $payouts = $app->affPayouts($affiliate_id, $start, $finish);
            foreach($payouts as &$payout) {
                $affiliate['payout'] += $payout['PayAmt'];
            }

            $payout = 0;
            $affiliate_row = Affiliate::where('user_is_id', '=', $user_is->id)->where('aff_id', '=', $affiliate_id)->first();
            if ($affiliate_row) {
                $payment_sum = DB::table('payments')
                    ->select(DB::raw('sum(amount) as amount'))
                    ->where('affiliate_id', '=', $affiliate_row->id)
                    ->where('created_at', '>=', date("Y-m-d H:i:s", strtotime($start_date)))
                    ->where('created_at', '<=', date("Y-m-d H:i:s", strtotime($finish_date)))
                    ->where('status', '=', 1)
                    ->first();

                if ($payment_sum) $payout = $payment_sum->amount;

                if ($affiliate_row->w9_file == null || $affiliate_row->w9_file == '') $names_without_w9 .= $affiliate_row->first_name . ' ' . $affiliate_row->last_name . ', ';
            }
            $affiliate['payout'] += $payout;
            //$total_payout += $payout;
            $affiliate['balance'] = $affiliate['commission'] - $affiliate['payout'];
            $affiliate['row'] = $affiliate_row;
            $affiliate['link'] = $app->getRedirectLinksForAffiliate($affiliate_id);

            if ($affiliate['Id'] >= 8) {
                $app->dsDelete("Affiliate", $affiliate['Id']);
            }
        }

        //$total_owed = $total_commission - $total_payout;
        return view('affiliates.index', compact( 'user_is', 'affiliates_count', 'start_date', 'finish_date', 'all_affiliates', 'names_without_w9' ));
	}

    public function getAdd(Request $request)
    {

        $user_is = $request->user_infusionsoft;
        $app = $request->app_infusionsoft;

        $affiliates = array();
        $page = 0;
        $returnFields = array('Id', 'AffCode', 'AffName', 'ContactId');
        $query = array('Id' => '%');
        while(true)
        {
            $results = $app->dsQuery("Affiliate", 1000, $page, $query, $returnFields);
            $affiliates = array_merge($affiliates, $results);
            if(count($results) < 1000) {
                break;
            }
            $page++;
        }

        $tags_grouped = array();
        $tag_categories_fields = array('Id', 'CategoryName', 'CategoryDescription');
        $query = array('CategoryName' => '%');
        $tag_categories = $app->dsQuery("ContactGroupCategory", 500, 0, $query, $tag_categories_fields, 'CategoryName' );

        foreach($tag_categories as $tag_category) {
            $tags_fields = array('Id', 'GroupName', 'GroupCategoryId', 'GroupDescription');
            $query = array('GroupCategoryId' => $tag_category['Id']);
            $tags = $app->dsQuery("ContactGroup", 500, 0, $query, $tags_fields);
            foreach($tags  as $tag) {
                $tags_grouped[$tag['Id']] = $tag_category['CategoryName'] . ' - ' . $tag['GroupName'];
            }
        }

        $programs = $app->getAffiliatePrograms();
        return view('affiliates.add', compact( 'affiliates', 'programs', 'tags_grouped' ));
    }

    public function postAdd(AffiliateRequest $request)
    {

        $user_is = $request->user_infusionsoft;
        $app = $request->app_infusionsoft;

        $contactData = array(
            'FirstName'     => $request->first_name,
            'LastName'      => $request->last_name,
            'Email'         => $request->email,
            'Phone1'        => $request->phone,
            'Password'      => $request->password,
        );
        $contact_id = $app->dsAdd("Contact", $contactData);

        $aff_data = array(
            'ContactId' => $contact_id,
            'AffCode'   => $request->aff_code ,
            'AffName'   => $request->first_name . ' ' . $request->last_name,
            'Password'  => $request->password
        );

        if ($request->parent) $aff_data['ParentId'] = $request->parent;
        $aff_id = $app->dsAdd("Affiliate", $aff_data);

        $tag_id = $request->tag_id;
        $tag_name = $request->tag_name;

        $result = false;
        if ($tag_id !== '') {
            $app->grpAssign($contact_id, $tag_id);
        } else if ($tag_name !== '') {
            $tagData = array(
                'GroupName'     => $tag_name
            );
            $tag_id = $app->dsAdd("ContactGroup", $tagData);
            $app->grpAssign($contact_id, $tag_id);
        }

        if (is_numeric($aff_id) && $aff_id > 0) {

            $affiliate = new Affiliate();
            $affiliate -> user_is_id = $user_is->id;
            $affiliate -> first_name = $request->first_name;
            $affiliate -> last_name = $request->last_name;
            $affiliate -> phone = $request->phone;
            $affiliate -> email = $request->email;
            $affiliate -> paypal_email = $request->paypal;
            $affiliate -> password = $request->password;
            $affiliate -> aff_code = $request->aff_code;
            $affiliate -> aff_id = $aff_id;
            $affiliate -> contact_id = $contact_id;
            $affiliate -> external_link = md5(microtime() . env('APP_KEY'));
            $affiliate -> confirm_w9 = $request->w9 ? $request->w9 : false;
            $affiliate -> send_confirmation = $request->confirmation ? $request->confirmation : false;
            $affiliate -> send_monthly_stat = $request->monthlystats ? $request->monthlystats : false;

            $affiliate -> save();

            return redirect('/')->with('success', 'New affiliate has been successfully created.');
        }

        return redirect('affiliates/add')->with('error', $aff_id);
    }

    public function showLedger(Request $request, $affiliate_id)
    {
        $user_is = $request->user_infusionsoft;
        $app = $request->app_infusionsoft;

        $affiliate_row = Affiliate::where('user_is_id', '=', $user_is->id)->where('aff_id', '=', $affiliate_id)->first();

        $start_date = $request->start_date;
        if ($start_date == NULL) $start_date = '01/01/2015';
        $finish_date = $request->finish_date;
        if ($finish_date == NULL) $finish_date = date('m/d/Y');

        $start = $app->infuDate($start_date);
        $finish = $app->infuDate($finish_date);

        $payout = 0;
        if ($affiliate_row) {
            $payment_sum = DB::table('payments')
                ->select(DB::raw('sum(amount) as amount'))
                ->where('affiliate_id', '=', $affiliate_row->id)
                ->where('status', '=', 1)
                ->first();

            if ($payment_sum) $payout = $payment_sum->amount;
        }

        $payments = Payment::where('affiliate_id', '=', $affiliate_row->id)->where('status', '=', 1)->get();

        $tags_fields = array('GroupId', 'ContactGroup', 'ContactId', 'Contact.FirstName');
        $query = array('ContactId' => $affiliate_row->contact_id);
        //$query = array('ContactId' => 308);
        $tags_assigned = $app->dsQuery("ContactGroupAssign", 500, 0, $query, $tags_fields);

        $clawbacks = $app->affClawbacks($affiliate_id, $start, $finish);
        $commissions = $app->affCommissions($affiliate_id, $start, $finish);
        $payouts = $app->affPayouts($affiliate_id, $start, $finish);
        $total = $app->affRunningTotals(array($affiliate_id));
        $total_record = $total[0];
        $amount = $total_record['RunningBalance'] - $payout;

        $tags_grouped = array();
        $tag_categories_fields = array('Id', 'CategoryName', 'CategoryDescription');
        $query = array('CategoryName' => '%');
        $tag_categories = $app->dsQuery("ContactGroupCategory", 500, 0, $query, $tag_categories_fields, 'CategoryName' );

        foreach ($tag_categories as $tag_category) {
            $tags_fields = array('Id', 'GroupName', 'GroupCategoryId', 'GroupDescription');
            $query = array('GroupCategoryId' => $tag_category['Id']);
            $tags = $app->dsQuery("ContactGroup", 500, 0, $query, $tags_fields);
            foreach($tags  as $tag) {
                $tags_grouped[$tag['Id']] = $tag_category['CategoryName'] . ' - ' . $tag['GroupName'];
            }
        }

        $order_fields = array('Id', 'ProductId', 'ItemName', 'Qty', 'OrderId');
        $orders = array();
        foreach ($commissions as $commission) {
            $results = $app->dsQuery("OrderItem", 1000, 0, array('OrderId' => $commission['InvoiceId']), $order_fields );
            $orders = array_merge($orders, $results);
        }

        $products = array();
        $returnFields = array('Id', 'ProductName', 'ProductPrice', 'ShortDescription', 'Shippable', 'Taxable');
        $query = array('Id' => '%');
        $page = 0;
        while(true) {
            $results = $app->dsQuery("Product", 1000, $page, $query, $returnFields);
            $products = array_merge($products, $results);
            if(count($results) < 1000){
                break;
            }
            $page++;
        }

        foreach($products as &$product) {
            $qty = 0;
            foreach ($orders as $order) {
                if ($product['Id'] == $order['ProductId']) $qty += $order['Qty'];
            }
            $product['Qty'] = $qty;
        }



        $aff_link = URL::to('/aff/' . $affiliate_row->external_link . '/' . $user_is->app_name . '/' . $affiliate_row->aff_code);
        return view('affiliates.ledger', compact( 'affiliate_row', 'payments', 'total_record', 'payout', 'aff_link', 'clawbacks', 'commissions', 'start_date', 'finish_date', 'payouts', 'amount', 'tags_assigned', 'tags_grouped', 'products'));
    }

    public function getPaynow(Request $request, $affiliate_id)
    {
        $user_is = $request->user_infusionsoft;
        $app = $request->app_infusionsoft;

        $affiliate_row = Affiliate::where('user_is_id', '=', $user_is->id)->where('aff_id', '=', $affiliate_id)->first();

        $payout = 0;
        if ($affiliate_row) {
            $payment_sum = DB::table('payments')
                ->select(DB::raw('sum(amount) as amount'))
                ->where('affiliate_id', '=', $affiliate_row->id)
                ->where('status', '=', 1)
                ->first();

            if ($payment_sum) $payout = $payment_sum->amount;
        }

        $payments = Payment::where('affiliate_id', '=', $affiliate_row->id)->where('status', '=', 1)->get();

        $total = $app->affRunningTotals(array($affiliate_id));
        $total_record = $total[0];
        $amount = $total_record['RunningBalance'] - $payout;

        return view('affiliates.pay', compact( 'affiliate_row', 'payments', 'total_record', 'payout', 'amount' ));
    }

    public function postPayall(Request $request)
    {

        $user_is = $request->user_infusionsoft;
        $app = $request->app_infusionsoft;
        //$affiliates = Affiliate::where('user_is_id', '=', $user_is->id)->get();

        $paid_affiliates = '';
        foreach ($request->affiliate_ids as $affiliate_id) {
            $affiliate_row = Affiliate::find($affiliate_id);
            $payment_sum = DB::table('payments')
                ->select(DB::raw('sum(amount) as amount'))
                ->where('affiliate_id', '=', $affiliate_row->id)
                ->where('status', '=', 1)
                ->first();

            $payout = 0;
            if ($payment_sum) $payout = $payment_sum->amount;

            $total = $app->affRunningTotals(array($affiliate_row->aff_id));
            $total_record = $total[0];
            $balance = $total_record['RunningBalance'] - $payout;
            if ($balance <= 0) continue;


            $pay_amount = $balance;
            define('PAYPAL_SANDBOX', 1);
            define('PAYPAL_ACTION_URL', 'https://www.sandbox.paypal.com/cgi-bin/webscr');

            //adaptive payment request
            $payRequest = new \PayRequest();
            $receiver = array();
            $receiver[0] = new \Receiver();
            $receiver[0]->amount = $pay_amount;
            $receiver[0]->email = $affiliate_row['paypal_email'];
            $receiverList = new \ReceiverList($receiver);
            $payRequest->receiverList = $receiverList;
            $payRequest->senderEmail = $user_is->paypal_business_account;

            $requestEnvelope = new \RequestEnvelope("en_US");
            $payRequest->requestEnvelope = $requestEnvelope;
            $payRequest->actionType = "PAY";
            $payRequest->cancelUrl = URL::to('affiliates/');
            $payRequest->returnUrl = URL::to('affiliates/');
            $payRequest->currencyCode = "USD";
            $payRequest->ipnNotificationUrl = URL::to('paypal/ipn');

            $sdkConfig = array(
                "mode"              => PAYPAL_SANDBOX ? "sandbox" : 'live',
                "acct1.UserName"    => $user_is->paypal_api_username,
                "acct1.Password"    => $user_is->paypal_api_password,
                "acct1.Signature"   => $user_is->paypal_api_signature,
                "acct1.AppId"       => $user_is->paypal_app_id
            );

            $adaptivePaymentsService = new \AdaptivePaymentsService($sdkConfig);
            $payResponse = $adaptivePaymentsService->Pay($payRequest);

            $payment = new Payment();
            $payment -> affiliate_id = $affiliate_row->id;
            $payment -> payment_key  = $payResponse->payKey;
            $payment -> amount = $pay_amount;
            $payment -> pay_result = json_encode($payResponse);
            $payment -> status = 1;
            $payment -> save();

            if($payResponse->responseEnvelope->ack == 'Success') {
                $paid_affiliates .= $affiliate_row->first_name . ' ' . $affiliate_row->last_name . ', ';
            }

        }
        return redirect(URL::to('affiliates/'))->with('paid_affiliates', $paid_affiliates);
    }

    public function postPaynow(Request $request, $affiliate_id)
    {
        $user_is = $request->user_infusionsoft;
        $affiliate_row = Affiliate::where('user_is_id', '=', $user_is->id)->where('aff_id', '=', $affiliate_id)->first();

        define('PAYPAL_SANDBOX', 1);
        define('PAYPAL_ACTION_URL', 'https://www.sandbox.paypal.com/cgi-bin/webscr');

        //adaptive payment request
        $payRequest = new \PayRequest();
        $receiver = array();
        $receiver[0] = new \Receiver();
        $receiver[0]->amount = $request->amount;
        $receiver[0]->email = $affiliate_row['paypal_email'];
        $receiverList = new \ReceiverList($receiver);
        $payRequest->receiverList = $receiverList;
        $payRequest->senderEmail = $user_is->paypal_business_account;

        $requestEnvelope = new \RequestEnvelope("en_US");
        $payRequest->requestEnvelope = $requestEnvelope;
        $payRequest->actionType = "PAY";
        $payRequest->cancelUrl = URL::to('affiliates/' . $affiliate_id . '/pay');
        $payRequest->returnUrl = URL::to('affiliates/' . $affiliate_id);
        $payRequest->currencyCode = "USD";
        $payRequest->ipnNotificationUrl = URL::to('paypal/ipn');

        $sdkConfig = array(
            "mode"              => PAYPAL_SANDBOX ? "sandbox" : 'live',
            "acct1.UserName"    => $user_is->paypal_api_username,
            "acct1.Password"    => $user_is->paypal_api_password,
            "acct1.Signature"   => $user_is->paypal_api_signature,
            "acct1.AppId"       => $user_is->paypal_app_id
        );

        $adaptivePaymentsService = new \AdaptivePaymentsService($sdkConfig);
        $payResponse = $adaptivePaymentsService->Pay($payRequest);

        $payment = new Payment();
        $payment -> affiliate_id = $affiliate_row->id;
        $payment -> payment_key  = $payResponse->payKey;
        $payment -> amount = $request['amount'];
        $payment -> pay_result =  json_encode($payResponse);
        $payment -> status = 1;
        $payment -> save();

        if($payResponse->responseEnvelope->ack != 'Success') {
            return redirect(URL::to('affiliates/' . $affiliate_id . '/pay'))->with('error', 'Payment was not successful.');
        }

        return redirect(URL::to('affiliates/' . $affiliate_id . '/pay'))->with('success', 'Payment was successful');
    }

    public function notify(Request $request, $affiliate_id)
    {
        $user_is = $request->user_infusionsoft;
        $affiliate_row = Affiliate::where('user_is_id', '=', $user_is->id)->where('aff_id', '=', $affiliate_id)->first();

        $affiliate_name = $affiliate_row->first_name . ' ' . $affiliate_row->last_name;
        $user_name = $user_is->first_name . ' ' . $user_is->last_name;
        $affiliate_link = URL::to('aff/' . $affiliate_row->external_link . '/' . $user_is->app_name . '/' . $affiliate_row->aff_code);

        $this->mailer->send('emails.w9reminder', compact('affiliate_name', 'user_name', 'affiliate_link'), function($message) use ($affiliate_row)
        {
            $message->from('reminders@yourdomain.com', 'EasyAffiliate Reminders');
            $message->to($affiliate_row->email)->subject('Reminder: Don’t forget your W9!');;
        });

        return redirect(URL::to('affiliates/'))->with('success', 'W9 reminder is sent.');
    }

    public function postAddtag(Request $request, $affiliate_id)
    {
        $user_is = $request->user_infusionsoft;
        $app = $request->app_infusionsoft;

        $affiliate_row = Affiliate::where('user_is_id', '=', $user_is->id)->where('aff_id', '=', $affiliate_id)->first();

        $tag_id = $request->tag_id;
        $tag_name = $request->tag_name;

        $result = false;
        if ($tag_id !== '') {
            $result = $app->grpAssign($affiliate_row->contact_id, $tag_id);
        } else if ($tag_name !== '') {
            $tagData = array(
                'GroupName'     => $tag_name
            );
            $tag_id = $app->dsAdd("ContactGroup", $tagData);
            $result = $app->grpAssign($affiliate_row->contact_id, $tag_id);
        }

        $message = $result ? 'Tag has been applied successfully to the affiliate.' : 'Tag is not applied to the affiliate.';
        return redirect('/affiliates/' . $affiliate_id)->with('tag_message', $message);
    }


}
