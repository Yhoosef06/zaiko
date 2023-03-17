<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemsController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\Auth\SignInController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\UserController;

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


Route::get('/register', [RegisterController::class,'index'])->name('register');
Route::post('/register', [RegisterController::class,'store']);

Route::get('/signin', [SignInController::class,'index'])->name('signin');
Route::post('/signin', [SignInController::class,'store']);


//admin
Route::middleware(['auth','user-role:admin'])->group(function(){
    Route::controller(PagesController::class)->group(function(){
        Route::get('/admin-dashboard','index')->name('admin.dashboard');
    });
    // Route::get('admin-dashboard', [PagesController::class,'index'])->name('admin.dashboard');
    Route::get('adding-new-item', [PagesController::class,'addItem'])->name('add_item');
    Route::get('pdf-view', [PagesController::class, 'printPDF'])->name('pdf_view');;
    
    // FOR ITEMS
    Route::get('list-of-items', [ItemsController::class,'index'])->name('view_items');
    Route::get('list-of-items-filtered', [ItemsController::class,'searchItem'])->name('filtered_view');
    Route::post('saving-new-item', [ItemsController::class,'saveNewItem'])->name('save_new_item');
    Route::get('viewing-item-{serial_number}', [ItemsController::class,'viewItemDetails'])->name('view_item_details');
    Route::get('edit-item-{serial_number}', [ItemsController::class,'editItemPage'])->name('edit_item_details');
    Route::put('updating-item-{serial_number}', [ItemsController::class, 'saveEditedItemDetails'])->name('update_item_details');
    Route::post('deleting-item-{serial_number}', [ItemsController::class,'deleteItem'])->name('delete_item');
    Route::get('generate-report', [ItemsController::class, 'generateReportPage'])->name('generate_report');
    Route::post('download-report', [ItemsController::class, 'downloadReport'])->name('download_pdf');

    // FOR USERS
    Route::get('add-new-user', [UserController::class,'addUser'])->name('add_user');
    Route::get('list-of-users', [UserController::class, 'index'])->name('view_users');
    Route::get('list-of-users-filtered', [UserController::class,'searchUser'])->name('filtered_view_users');
    Route::get('viewing-user-{id_number}', [UserController::class,'viewUserInfo'])->name('view_user_info');
    Route::post('saving-new-user', [UserController::class,'saveNewUser'])->name('save_new_user');
    Route::post('deleting-user-{id_number}', [UserController::class,'deleteUser'])->name('delete_user');
}); 

//student
Route::middleware(['auth','user-role:student'])->group(function(){

    Route::middleware(['account_status:pending'])->group(function(){
        Route::get('/approve', [PagesController::class,'approve'])->name('approval');
    });

    Route::middleware(['account_status:approved'])->group(function(){

        Route::controller(StudentController::class)->group(function(){
            Route::get('/student-dashboard','index')->name('student.dashboard');
            Route::get('/items','items')->name('student.items');
        });
    });
    // Route::get('/student-dashboard',[StudentController::class, 'index'])->name('student.dashboard');
});

//unapproved
// Route::middleware(['auth','account_status:for_approval'])->group(function(){
//     Route::get('/approve', [PagesController::class,'approve'])->name('approval');
// });

Route::get('/test',[PagesController::class,'test']);
