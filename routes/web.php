<?php
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

    Route::get('/', [StudentController::class, 'index'])->name('student.index');
    Route::get('/json', [StudentController::class, 'json'])->name('student.json');
    Route::get('/create', [StudentController::class, 'create'])->name('student.create');
    Route::get('/edit/{id}', [StudentController::class, 'edit'])->name('student.edit');
    Route::post('/store', [StudentController::class, 'store'])->name('student.store');
    Route::put('/update/{id}', [StudentController::class, 'update'])->name('student.update');
    Route::delete('/delete/{id}', [StudentController::class, 'destroy'])->name('student.destroy');
});

Route::get('/home', 'HomeController@index')->name('home');
