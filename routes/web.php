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

// Route::group(['middleware' => 'auth','is.admin'], function(){
//     Route::get('/dashboard', [PagesController::class,'index'])->name('dashboard');
// });

// //students
// Route::group(['middlewawre' => 'is.student'], function(){
//     Route::get('/student-dashboard',[StudentController::class, 'index']);
// });


//admin
Route::middleware(['auth','user-role:admin'])->group(function(){
    Route::get('admin-dashboard', [PagesController::class,'index'])->name('admin.dashboard');
});

//student
Route::middleware(['auth','user-role:student'])->group(function(){
    Route::get('/student-dashboard',[StudentController::class, 'index'])->name('student.dashboard');
});

//unapproved
Route::middleware(['auth','user-role:queued'])->group(function(){
    Route::get('/approve', [PagesController::class,'approve'])->name('approval');
});
