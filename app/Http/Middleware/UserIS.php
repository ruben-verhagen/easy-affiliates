<?php namespace App\Http\Middleware;

use iSDK;
use iSDKException;
use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Routing\Middleware;


use App\UserInfusionsoft;

class UserIS implements Middleware {

    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;


    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
        $user_id = $this->auth->user()->id;
        $user_infusionsoft = UserInfusionsoft::where('user_id','=', $user_id)->first();
        $request['user_infusionsoft'] = $user_infusionsoft;

        $app_infusionsoft = new iSDK();
        try {
            if ( $user_infusionsoft->app_name == '' || $user_infusionsoft->app_apikey == '' || !$app_infusionsoft->cfgCon($user_infusionsoft->app_name, $user_infusionsoft->app_apikey) ) {
                return redirect('profile/app');
            }
        } catch (iSDKException $e) {
            return redirect('profile/app');
        }
        $request['app_infusionsoft'] = $app_infusionsoft;

        return $next($request);

	}

}
