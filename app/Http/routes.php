<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::pattern('id',        '[0-9]+');
Route::pattern('app',       '[0-9a-zA-Z]+');
Route::pattern('affcode',   '[0-9a-zA-Z]+');
Route::pattern('rand',      '[0-9a-zA-Z]+');

Route::get  ('/',                            'HomeController@index');
Route::post ('/',                            'HomeController@index');
Route::get  ('profile',                      'ProfileController@getProfile');
Route::post ('profile',                      'ProfileController@updateProfile');
Route::get  ('profile/app',                  'ProfileController@getApp');
Route::post ('profile/app',                  'ProfileController@updateApp');
Route::get  ('affiliates',                   'AffiliateController@index');
Route::post ('affiliates',                   'AffiliateController@index');
Route::get  ('affiliates/add',               'AffiliateController@getAdd');
Route::post ('affiliates/add',               'AffiliateController@postAdd');
Route::post ('affiliates/payall',            'AffiliateController@postPayAll');
Route::get  ('affiliates/{id}',              'AffiliateController@showLedger');
Route::post ('affiliates/{id}',              'AffiliateController@showLedger');
Route::get  ('affiliates/{id}/notify',       'AffiliateController@notify');
Route::get  ('affiliates/{id}/pay',          'AffiliateController@getPaynow');
Route::post ('affiliates/{id}/pay',          'AffiliateController@postPaynow');
Route::post ('affiliates/{id}/addtag',       'AffiliateController@postAddtag');
Route::get  ('products',                     'ProductController@index');
Route::post ('paypal/ipn',                   'PaymentController@paypal');

// Public Affiliate
Route::get('aff/{rand}/{app}/{affcode}',    'PublicAffiliateController@index');
Route::post('aff/{rand}/{app}/{affcode}',   'PublicAffiliateController@uploadW9');
Route::get('w9files/{id}',                  'FileController@downloadW9');

//Route::get('news/{id}', 'ArticlesController@show');
//Route::get('video/{id}', 'VideoController@show');
//Route::get('photo/{id}', 'PhotoController@show');

Route::get('error', 'PagesController@error' );

Route::controllers([
    'auth' => 'Auth\AuthController',
    'password' => 'Auth\PasswordController',
]);

if (Request::is('admin/*'))
{
    require __DIR__.'/admin_routes.php';
}
