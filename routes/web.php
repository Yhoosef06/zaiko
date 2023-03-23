<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemsController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\Auth\SignInController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\BorrowController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\CartController;

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

Route::get('/', [SignInController::class,'index'])->name('signin.page');
Route::post('/signin', [SignInController::class,'store'])->name('signin');


Route::group(['middleware' => ['auth']], function(){
    Route::middleware(['user-role:admin'])->group(function(){
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
    });
    
    //student
    Route::middleware(['user-role:student'])->group(function(){
    
        Route::middleware(['account_status:pending'])->group(function(){
            Route::get('/approve', [PagesController::class,'approve'])->name('approval');
        });
    
        Route::middleware(['account_status:approved'])->group(function(){
    
            Route::controller(StudentController::class)->group(function(){
                Route::get('/student-dashboard','index')->name('student.dashboard');
                Route::get('/student-items','items')->name('student.items');
                Route::get('/view-item-{serial_number}','viewItemDetails')->name('student.view.item');
    
            });

            //cart
            Route::post('/student-add-cart/{serial_number}',[CartController::class, 'add_cart'])->name('add.cart');
            Route::get('/student-cart-list',[CartController::class, 'cart_list'])->name('cart.list');
            Route::get('/remove-cart/{serial_number}',[CartController::class, 'remove_cart'])->name('remove.cart');

            // Route::get('/student-cart-list',[BorrowController::class,'cartList'])->name('student.cart.list');
            Route::delete('/remove-from-cart',[BorrowController::class,'remove'])->name('remove.from.cart');
            Route::delete('/deleting-item-{serial_number}', [BorrowController::class,'remove'])->name('remove_item');
        
        });
        // Route::get('/student-dashboard',[StudentController::class, 'index'])->name('student.dashboard');
    });


    //LOGOUT
    Route::post('/logout', [LogoutController::class,'logout'])->name('logout');


});



//unapproved
// Route::middleware(['auth','account_status:for_approval'])->group(function(){
//     Route::get('/approve', [PagesController::class,'approve'])->name('approval');
// });

Route::get('/test',[PagesController::class,'test']);
