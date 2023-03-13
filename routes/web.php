<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemsController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\Auth\SignInController;
use App\Http\Controllers\Auth\RegisterController;

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
    Route::get('adding-new-item', [PagesController::class,'addItem'])->name('add_item');
    Route::get('pdf-view', [PagesController::class, 'printPDF'])->name('pdf_view');;
    // FOR ITEMS
    Route::get('list-of-items', [ItemsController::class,'index'])->name('view_items');
    Route::post('saving-new-item', [ItemsController::class,'saveNewItem'])->name('save_new_item');
    Route::get('viewing-item-{serial_number}', [ItemsController::class,'viewItemDetails'])->name('view_item_details');
    Route::get('edit-item-{serial_number}', [ItemsController::class,'editItemPage'])->name('edit_item_details');
    Route::put('updating-item-{serial_number}', [ItemsController::class, 'saveEditedItemDetails'])->name('update_item_details');
    Route::post('deleting-item-{serial_number}', [ItemsController::class,'deleteItem'])->name('delete_item');
    Route::get('generate-report', [ItemsController::class, 'generateReportPage'])->name('generate_report');
    Route::post('download-report', [ItemsController::class, 'downloadReport'])->name('download_pdf');
});

//student
Route::middleware(['auth','user-role:student'])->group(function(){
    Route::get('/student-dashboard',[StudentController::class, 'index'])->name('student.dashboard');
});

//unapproved
Route::middleware(['auth','user-role:queue'])->group(function(){
    Route::get('/approve', [PagesController::class,'approve'])->name('approval');
});
