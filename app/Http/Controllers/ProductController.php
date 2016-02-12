<?php namespace App\Http\Controllers;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
class ProductController extends Controller {

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

	public function index(Request $request)
	{
        $user_is = $request->user_infusionsoft;
        $app = $request->app_infusionsoft;

        $order_fields = array('Id', 'ProductId', 'ItemName', 'Qty', 'OrderId');
        $orders = $app->dsQuery("OrderItem", 1000, 0, array('Id' => '%'), $order_fields );

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

        return view('products.index', compact( 'user_is', 'products' ));
	}




}