<?php
Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function() {
    Route::pattern('id', '[0-9]+');
    Route::pattern('id2', '[0-9]+');

    #Admin Dashboard
    Route::get('dashboard',             'Admin\DashboardController@index');

    #Users
    Route::get('users/',                'Admin\UserController@index');
    Route::get('users/create',          'Admin\UserController@getCreate');
    Route::post('users/create',         'Admin\UserController@postCreate');
    Route::get('users/{id}/edit',       'Admin\UserController@getEdit');
    Route::post('users/{id}/edit',      'Admin\UserController@postEdit');
    Route::get('users/{id}/delete',     'Admin\UserController@getDelete');
    Route::post('users/{id}/delete',    'Admin\UserController@postDelete');
    Route::get('users/data',            'Admin\UserController@data');

    #Roles
    Route::get('roles/',                'Admin\RoleController@index');
    Route::get('roles/create',          'Admin\RoleController@getCreate');
    Route::post('roles/create',         'Admin\RoleController@postCreate');
    Route::get('roles/{id}/edit',       'Admin\RoleController@getEdit');
    Route::post('roles/{id}/edit',      'Admin\RoleController@postEdit');
    Route::get('roles/{id}/delete',     'Admin\RoleController@getDelete');
    Route::post('roles/{id}/delete',    'Admin\RoleController@postDelete');
    Route::get('roles/data',            'Admin\RoleController@data');

});
