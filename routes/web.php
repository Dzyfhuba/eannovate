<?php
use App\Http\Controllers\RoomController;
use App\Http\Controllers\StudentController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::middleware(['auth'])->group(function () {

    // students
    Route::get('/', [StudentController::class, 'index'])->name('student.index');
    Route::get('/json', [StudentController::class, 'json'])->name('student.json');
    Route::get('/create', [StudentController::class, 'create'])->name('student.create');
    Route::get('/edit/{id}', [StudentController::class, 'edit'])->name('student.edit');
    Route::post('/store', [StudentController::class, 'store'])->name('student.store');
    Route::put('/update/{id}', [StudentController::class, 'update'])->name('student.update');
    Route::delete('/delete/{id}', [StudentController::class, 'destroy'])->name('student.destroy');

    Route::post('/student/assign', [StudentController::class, 'assignClass'])->name('student.assign');

    // rooms
    Route::get('/room', [RoomController::class, 'index'])->name('room.index');
    Route::get('/room/json', [RoomController::class, 'json'])->name('room.json');
    Route::get('/room/create', [RoomController::class, 'create'])->name('room.create');
    Route::get('/room/edit/{id}', [RoomController::class, 'edit'])->name('room.edit');
    Route::post('/room/store', [RoomController::class, 'store'])->name('room.store');
    Route::put('/room/update/{id}', [RoomController::class, 'update'])->name('room.update');
    Route::delete('/room/delete/{id}', [RoomController::class, 'destroy'])->name('room.destroy');
});

Route::get('/home', 'HomeController@index')->name('home');
