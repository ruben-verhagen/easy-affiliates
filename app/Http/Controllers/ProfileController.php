<?php namespace App\Http\Controllers;

use iSDK;
use iSDKException;
use App\UserInfusionsoft;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Database\Eloquent;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\URL;
use Illuminate\Contracts\Auth\PasswordBroker;

class ProfileController extends Controller {

    protected $auth;

    protected $passwords;
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct(Guard $auth, PasswordBroker $passwords)
	{
        $this->auth = $auth;
        $this->passwords = $passwords;
        $this->middleware('auth');
        $this->middleware('user_is', ['except' => ['getApp', 'updateApp']]);
	}

    /**
     * Show the profile to the user.
     *
     * @return Response
     */
    public function getProfile(Request $request)
    {
        $user_is = $request->user_infusionsoft;
        $app = $request->app_infusionsoft;
        $user = $this->auth->user();

        return view('profile.index', compact( 'user', 'user_is' ));
    }

    /**
     * Update the profile of the user.
     *
     * @return Response
     */
    public function updateProfile(Request $request)
    {

        $app = $request->app_infusionsoft;
        $user_is = $request->user_infusionsoft;

        if ($request->cmd == 'password') {
            $user = $this->auth->user();

            $user->password = bcrypt($request->password);
            if ($user->save())
                return redirect(URL::to('profile/'))->with('pwd_success', 'Update was successful.');
            else
                return redirect(URL::to('profile/'))->with('pwd_error', 'Update was not successful.');

        } elseif ($request->cmd == 'general') {
            $user_is->first_name = $request->first_name;
            $user_is->last_name = $request->last_name;

            if ($user_is->save())
                return redirect(URL::to('profile/'))->with('gen_success', 'Update was successful.');
            else
                return redirect(URL::to('profile/'))->with('gen_error', 'Update was not successful.');
        } else {
            $user_is->paypal_app_id = $request->paypal_app_id;
            $user_is->paypal_api_username = $request->paypal_api_username;
            $user_is->paypal_api_password = $request->paypal_api_password;
            $user_is->paypal_api_signature = $request->paypal_api_signature;
            $user_is->paypal_business_account = $request->paypal_business_account;

            if ($user_is->save())
                return redirect(URL::to('profile/'))->with('pay_success', 'Update was successful.');
            else
                return redirect(URL::to('profile/'))->with('pay_error', 'Update was not successful.');
        }
    }

    /**
     * Show the app details to the user.
     *
     * @return Response
     */
    public function getApp(Request $request)
    {
        $user_id = $this->auth->user()->id;
        $user_is = UserInfusionsoft::where('user_id','=', $user_id)->first();

        $app_infusionsoft = new iSDK();
        $connected = false;
        try {
            //$user_is->app_name == '' || $user_is->app_apikey == '' ||
            if ($app_infusionsoft->cfgCon($user_is->app_name, $user_is->app_apikey) ) {
                $connected = true;
            }
        } catch (iSDKException $e) {

        } catch (\ErrorException $e) {

        }

        return view('profile.app', compact( 'user_is', 'connected' ));
    }

    /**
     * Show the app details to the user.
     *
     * @return Response
     */
    public function updateApp(Request $request)
    {
        $user_id = $this->auth->user()->id;
        $user_is = UserInfusionsoft::where('user_id','=', $user_id)->first();

        $user_is->app_name = $request->app_name;
        $user_is->app_apikey = $request->app_apikey;
        $user_is->save();

        return redirect(URL::to('profile/app'))->with('app_success', 'App details are updated.');
    }
}