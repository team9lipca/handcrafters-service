<?php
Route::group([
    'namespace' => 'Auth',
    'middleware' => 'api'
], function () {
    Route::post('login', 'AuthController@login');
    Route::post('signup', 'AuthController@signup');
    Route::get('signup/activate/{token}', 'AuthController@signupActivate');
    Route::group([
        'middleware' => 'guest:api'
    ], function() {
        Route::get('logout', 'AuthController@logout');
        Route::get('user', 'AuthController@user');
    });
});

/*
Route::group([
    'namespace' => 'Auth',
    'middleware' => 'auth:api',
    'prefix' => 'auth'
], function () {
    Route::get('user', 'AuthController@user');
});
*/