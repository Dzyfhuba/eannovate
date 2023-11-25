<?php

use App\User;
use Illuminate\Http\Request;

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

Route::middleware(['api.bearer'])->get('/user', function (Request $request) {
    return response([
        'hello' => 'user'
    ]);
});

Route::post('/login', function (Request $request) {
    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {

        $user = User::find(auth()->user()->id);
        $user->api_token = Str::random(80);
        $user->save();

        return response([
            'message' => 'success',
            'user' => $user,
        ]);
    }

    return response([
        'message' => 'failed'
    ]);
});
