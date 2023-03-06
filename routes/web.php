<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\Auth\SignInController;
use App\Http\Controllers\Auth\RegisterController;
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

// Route::get('/', function () {
//     return view('pages.landing');
// });

Route::get('/register', [RegisterController::class,'index'])->name('register');
Route::post('/register', [RegisterController::class,'store']);

Route::get('/signin', [SignInController::class,'index'])->name('signin');
Route::post('/signin', [SignInController::class,'store']);

Route::group(['middleware' => 'is.admin'], function(){
    Route::get('/dashboard', [PagesController::class,'index'])->name('dashboard');
});

// Route::get('/dashboard', [PagesController::class,'index'])->name('dashboard');



//students
Route::get('/student-dashboard',[StudentController::class, 'index']);
