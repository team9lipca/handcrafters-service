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

Route::get('/crafts-main/{page}', function ($page) {
    $craftsDto = Craft::skip(($page-1)*10)->take(10)->get();

    foreach($craftsDto as $key => $craft) {
        $craftsDto[$key]['author'] = User::findOrFail($craft['author_id']);
    }

    return ['crafts' => $craftsDto];
});

Route::get('/users-main/{page}', function ($page) {
    $usersDto = User::skip(($page-1)*10)->take(10)->get();

    foreach($usersDto as $key => $user) {
        $usersDto[$key]['last-crafts'] = Craft::where(['author_id' => $user['id']])->orderBy('created_at')->take(5)->get();
    }

    return ['users' => $usersDto];
});

Route::get('/user-crafts-main/{username}/{page}', function ($username, $page) {
    $user = User::where(['name' => $username])->first();

    $craftsDto = Craft::where(['author_id' => $user['id']])->skip(($page-1)*10)->take(10)->get();

    return ['crafts' => $craftsDto, 'logged_user' => Auth::user()];
})->middleware('web');

Route::get('dbtest', function() {
    DB::connection()->getPdo();
});