<?php

use Illuminate\Http\Request;
use App\Craft;
use App\User;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*
Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('login', 'AuthController@login');
    Route::post('signup', 'AuthController@signup');

    Route::group([
        'middleware' => 'auth:api'
    ], function() {
        Route::get('logout', 'AuthController@logout');
        Route::get('user', 'AuthController@user');
    });
});
*/
//require __DIR__ . '/auth/auth.php';
/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::apiResource('shots', 'CraftController');

Route::apiResource('handcrafters', 'UserController');

Route::get('/crafts/home-page/{page}/{count?}', 'CraftController@homePageCrafts');

Route::get('/crafters/popular/{page}/{count?}', 'UserController@mostPopularCrafters');


Route::any('/{any}', function ($any) {
    return response(["messages" => ["Route not found"]], 404);
})->where('any', '.*');

/*Route::get('/user-crafts-main/{username}/{page}', function ($username, $page) {
    $user = User::where(['name' => $username])->first();

    $craftsDto = Craft::where(['author_id' => $user['id']])->skip(($page-1)*10)->take(10)->get();

    return ['crafts' => $craftsDto, 'logged_user' => Auth::user()];
})->middleware('web');*/