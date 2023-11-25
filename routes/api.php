<?php

use App\Http\Controllers\api\StudentController;
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

Route::middleware(['api.bearer'])->group(function () {
    Route::get('/mobile/student', [StudentController::class, 'index']);
    Route::post('/mobile/student/insert', [StudentController::class, 'store']);
});

Route::post('/login', function (Request $request) {
    try {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {

            $user = User::find(auth()->user()->id);
            $user->api_token = Str::random(80);
            $user->save();

            return response([
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'authorization' => $user->api_token,
            ], 200);
        }

        return response([
            'status' => 400,
            'message' => 'Bad Request',
        ]);
    } catch (\Exception $e) {
        return response([
            'status' => 500,
            'message' => 'Internal Server Error',
        ], 500);
    }
});
