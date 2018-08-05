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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('crafts', 'API\CraftController');

Route::get('/crafts/home-page/{page}/{count?}', 'API\CraftController@homePageCrafts');

Route::get('/crafters/popular/{page}/{count?}', 'API\UserController@mostPopularCrafters');

Route::get('/user-crafts-main/{username}/{page}', function ($username, $page) {
    $user = User::where(['name' => $username])->first();

    $craftsDto = Craft::where(['author_id' => $user['id']])->skip(($page-1)*10)->take(10)->get();

    return ['crafts' => $craftsDto, 'logged_user' => Auth::user()];
})->middleware('web');