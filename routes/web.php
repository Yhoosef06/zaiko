<?php

use Illuminate\Http\Request;
use App\Models\SecurityQuestion;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QRController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\TermController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\ItemsController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\BorrowController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\ModelsController;
use App\Http\Controllers\CollegeController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ReferenceController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\Auth\SignInController;
use App\Http\Controllers\ItemCategoryController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\SecurityQuestionController;

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

Route::get('edit_college', [CollegeController::class, 'editCollege'])->name('modify_college');

Route::get('/qr-reader', function () {
    return view('qr-reader');
});

Route::get('/select-registration-type', [RegisterController::class, 'selectRegistrationType'])->name('select_registration_type');

//for student
Route::get('/student-registration', [RegisterController::class, 'studentRegistration'])->name('student_registration');
Route::post('/student-registration', [RegisterController::class, 'storeStudent']);

//for faculty
Route::get('/faculty-registration', [RegisterController::class, 'facultyRegistration'])->name('faculty_registration');
Route::post('/faculty-registration', [RegisterController::class, 'storeFaculty']);

Route::get('/', [SignInController::class, 'index'])->name('signin.page');
Route::post('/signin', [SignInController::class, 'store'])->name('signin');

Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');

//security question
Route::get('/security-question-input-id-number', [SecurityQuestionController::class, 'getIdNumber'])->name('get_id_number');
Route::get('/security-question/{id_number}', [SecurityQuestionController::class, 'securityQuestion'])->name('security_questions');
Route::get('/verify-security-question/{id_number}', [SecurityQuestionController::class, 'verifySecurityQuestion'])->name('verify_security_question');
Route::post('/reset-password/{id_number}', [SecurityQuestionController::class, 'resetPassword'])->name('reset_password');
Route::get('/setup-security-question-{id_number}', [SecurityQuestionController::class, 'setupSecurityQuestion'])->name('setup_security_question');
Route::post('/store-security-question-{id_number}', [SecurityQuestionController::class, 'storeSecurityQuestion'])->name('store_security_question');

//common
Route::get('change-user-{id_number}-password', [UserController::class, 'changeUserPassword'])->name('change_user_password');
Route::post('updating-user-{id_number}-password', [UserController::class, 'saveUserNewPassword'])->name('save_user_new_password');
Route::get('profile-{id_number}', [UserController::class, 'viewProfile'])->name('view_profile');
Route::get('edit-profile-{id_number}', [UserController::class, 'editProfile'])->name('edit_profile');
Route::post('save-edited-profile-{id_number}', [UserController::class, 'saveEditedProfileInfo'])->name('save_edited_profile_info');
Route::get('modify-security-question-{id_number}', [UserController::class, 'modifySecurityQuestion'])->name('modify_security_question');
Route::post('save-modified-security-question-{id_number}', [UserController::class, 'saveModifiedSecurityQuestion'])->name('save_modified_security_question');

//admin
Route::middleware(['auth', 'user-role:admin|reads|faculty'])->group(function () {
    Route::controller(PagesController::class)->group(function () {
        Route::get('/admin-dashboard', 'index')->name('admin.dashboard');
    });
    // Route::get('admin-dashboard', [PagesController::class,'index'])->name('admin.dashboard');
    // Route::get('adding-new-item', [PagesController::class, 'addItem'])->name('add_item');
    Route::get('pdf-view', [PagesController::class, 'printPDF'])->name('pdf_view');;

    // FOR ITEMS
    Route::get('adding-new-item', [ItemsController::class, 'addItem'])->name('add_item');
    Route::get('list-of-items', [ItemsController::class, 'index'])->name('view_items');
    Route::get('view-item-details-{id}', [ItemsController::class, 'viewItemDetails'])->name('view_item_details');
    Route::get('list-of-items-filtered', [ItemsController::class, 'searchItem'])->name('filtered_view');
    Route::post('saving-new-item', [ItemsController::class, 'saveNewItem'])->name('save_new_item');
    Route::get('get-item-{id}-details', [ItemsController::class, 'getItemDetails'])->name('get_item_details');
    Route::get('edit-item-{id}', [ItemsController::class, 'editItemPage'])->name('edit_item_details');
    Route::put('updating-item-{id}-details', [ItemsController::class, 'saveEditedItemDetails'])->name('update_item_details');
    Route::post('deleting-item-{id}', [ItemsController::class, 'deleteItem'])->name('delete_item');
    Route::get('/get-brand', [ItemsController::class, 'getBrand']);
    Route::get('/get-model', [ItemsController::class, 'getModel']);
    Route::get('/transfer-item-{id}', [ItemsController::class, 'transferItem'])->name('transfer_item');
    Route::post('/save-transfer-item-{id}', [ItemsController::class, 'saveTransferItem'])->name('save_transfer_item');
    Route::get('/add-sub-item-{id}', [ItemsController::class, 'addSubItem'])->name('add_sub_item');
    Route::post('/save-sub-item-{id}', [ItemsController::class, 'saveSubItem'])->name('save_sub_item');
    Route::get('/replace-item-{id}', [ItemsController::class, 'replaceItem'])->name('replace_item');
    Route::post('/save-replaced-item-{id}', [ItemsController::class, 'saveReplacedItem'])->name('save_replaced_item');

    // FOR USERS
    Route::get('add-new-user', [UserController::class, 'addUser'])->name('add_user');
    Route::get('list-of-users', [UserController::class, 'index'])->name('view_users');
    Route::get('list-of-users-filtered', [UserController::class, 'searchUser'])->name('filtered_view_users');
    Route::get('view-user-{id_number}', [UserController::class, 'viewUserInfo'])->name('view_user_info');
    Route::post('saving-new-user', [UserController::class, 'saveNewUser'])->name('save_new_user');
    Route::get('edit-user-{id_number}', [UserController::class, 'editUserInfo'])->name('edit_user_info');
    Route::put('updating-user-{id_number}', [UserController::class, 'saveEditedUserInfo'])->name('update_user_info');
    Route::post('deleting-user-{id_number}', [UserController::class, 'deleteUser'])->name('delete_user');

    // FOR Colleges
    Route::get('colleges', [CollegeController::class, 'index'])->name('view_colleges');
    Route::get('add-college', [CollegeController::class, 'addCollege'])->name('add_college');
    Route::get('edit/college/{id}', [CollegeController::class, 'editCollege'])->name('edit_college');
    Route::post('save-new-college', [CollegeController::class, 'saveNewCollege'])->name('save_new_college');
    Route::post('save-edited-college/{id}', [CollegeController::class, 'saveEditedCollege'])->name('save_edited_college');
    Route::post('delete-college-{id}', [CollegeController::class, 'deleteCollege'])->name('delete_college');

    //FOR Departments
    Route::get('departments', [DepartmentController::class, 'index'])->name('view_departments');
    Route::get('add-department', [DepartmentController::class, 'addDepartment'])->name('add_department');
    Route::post('save-new-department', [DepartmentController::class, 'saveNewDepartment'])->name('save_new_department');
    Route::get('edit/department/{id}', [DepartmentController::class, 'editDepartment'])->name('edit_department');
    Route::post('save-edited-department/{id}', [DepartmentController::class, 'saveEditedDepartment'])->name('save_edited_department');
    Route::post('delete-department/{id}', [DepartmentController::class, 'deleteDepartment'])->name('delete_department');

    // FOR ROOM
    Route::get('rooms', [RoomController::class, 'index'])->name('view_rooms');
    Route::get('add-room', [RoomController::class, 'addRoom'])->name('add_room');
    Route::post('save-new-room', [RoomController::class, 'saveNewRoom'])->name('save_new_room');
    Route::get('edit/room/{id}', [RoomController::class, 'editRoom'])->name('edit_room');
    Route::post('save-edited-room/{id}', [RoomController::class, 'saveEditedRoom'])->name('save_edited_room');
    Route::post('delete-room/{id}', [RoomController::class, 'deleteRoom'])->name('delete_room');
    Route::get('/get-departments/{college_id}', [DepartmentController::class, 'getDepartments'])->name('get_departments');
    
    // FOR Item Category
    Route::get('item-categories', [ItemCategoryController::class, 'index'])->name('view_item_categories');
    Route::get('add-item-category', [ItemCategoryController::class, 'addItemCategory'])->name('add_item_category');
    Route::get('edit/item-category/{id}', [ItemCategoryController::class, 'editItemCategory'])->name('edit_item_category');
    Route::post('saving-new-category', [ItemCategoryController::class, 'saveNewCategory'])->name('save_new_category');
    Route::post('save-edited-item-category/{id}', [ItemCategoryController::class, 'saveEditedItemCategory'])->name('save_edited_item_category');
    Route::post('delete-category/{id}', [ItemCategoryController::class, 'deleteCategory'])->name('delete_category');

    //FOR BRAND
    Route::get('brands', [BrandController::class, 'index'])->name('view_brands');
    Route::get('add-brand', [BrandController::class, 'addBrand'])->name('add_brand');
    Route::post('save-new-brand', [BrandController::class, 'saveNewBrand'])->name('save_new_brand');
    Route::get('edit/brand/{id}', [BrandController::class, 'editBrand'])->name('edit_brand');
    Route::post('save-edited-brand/{id}', [BrandController::class, 'saveEditedBrand'])->name('save_edited_brand');
    Route::post('delete-brand/{id}', [BrandController::class, 'deleteBrand'])->name('delete_brand');

    //FOR MODELS
    Route::get('models', [ModelsController::class, 'index'])->name('view_models');
    Route::get('add-model', [ModelsController::class, 'addModel'])->name('add_model');
    Route::post('save-new-model', [ModelsController::class, 'saveNewModel'])->name('save_new_model');
    Route::get('edit/model/{id}', [ModelsController::class, 'editModel'])->name('edit_model');
    Route::post('save-edited-model/{id}', [ModelsController::class, 'saveEditedModel'])->name('save_edited_model');
    Route::post('delete-model/{id}', [ModelsController::class, 'deleteModel'])->name('delete_model');

    //TERM
    Route::get('terms', [TermController::class, 'index'])->name('view_terms');
    Route::get('add-term', [TermController::class, 'addTerm'])->name('add_term');
    Route::post('save-new-term', [TermController::class, 'saveNewTerm'])->name('save_new_term');
    Route::post('delete-term/{id}', [TermController::class, 'deleteTerm'])->name('delete_term');
    Route::post('current-term/{id}', [TermController::class, 'currentTerm'])->name('current_term');

    //FOR Manage Borrowings
    Route::get('borrowed', [BorrowController::class, 'borrowed'])->name('borrowed');
    Route::get('pending', [BorrowController::class, 'pending'])->name('pending');
    Route::get('returned', [BorrowController::class, 'returned'])->name('returned');

    // Route::get('pending-item/{id}/{serial_number}', [BorrowController::class, 'pendingItem'])->name('pending_item');
    // Route::get('borrow-item/{id}/{serial_number}', [BorrowController::class, 'borrowItem'])->name('borrow_item');
    Route::get('remove-borrow/{id}', [BorrowController::class, 'removeBorrow'])->name('remove-borrow');
    Route::get('/searchUser', [BorrowController::class, 'searchUser'])->name('searchUser');
    Route::get('/searchItem', [BorrowController::class, 'searchItem'])->name('searchItem');
    Route::get('/searchItemAdmin', [BorrowController::class, 'searchItemAdmin'])->name('searchItemAdmin');
    Route::get('/searchForSerial', [BorrowController::class, 'searchForSerial'])->name('searchForSerial');
    Route::get('/searchItemForAdmin', [BorrowController::class, 'searchItemForAdmin'])->name('searchItemForAdmin');
    Route::get('/searchItemForUser', [BorrowController::class, 'searchItemForUser'])->name('searchItemForUser');
    Route::get('/borrow-item', [BorrowController::class, 'borrowItem'])->name('borrowItem');
    Route::get('/borrow-item/{id}', [BorrowController::class, 'borrowItemAdmin'])->name('borrowItemAdmin');
    Route::get('/add-item/{id}', [BorrowController::class, 'addItem'])->name('addItem');
    Route::get('/check-userID/{id}', [BorrowController::class, 'checkUserId'])->name('checkUserId');
    Route::post('/pending-borrow', [BorrowController::class, 'pendingBorrow'])->name('pendingBorrow');
    Route::post('/userPendingBorrow', [BorrowController::class, 'userPendingBorrow'])->name('userPendingBorrow');
    Route::post('/submitAdminBorrow', [BorrowController::class, 'submitAdminBorrow'])->name('submitAdminBorrow');
    Route::post('/submitUserBorrow', [BorrowController::class, 'submitUserBorrow'])->name('submitUserBorrow');
    Route::post('/submit-admin-order', [BorrowController::class, 'submitAdminOrder'])->name('submitAdminOrder');
    Route::post('/updateQuantity', [BorrowController::class, 'updateQuantity'])->name('updateQuantity');



    // Route::post('/addOrder', [BorrowController::class, 'addOrder'])->name('addOrder');
    Route::post('/addRemark', [BorrowController::class, 'addRemark'])->name('addRemark');
    Route::get('view-order-admin/{id}', [BorrowController::class, 'viewOrderAdmin'])->name('view-order-admin');
    Route::get('view-order-user/{id}', [BorrowController::class, 'viewOrderUser'])->name('view-order-user');
    Route::get('view-borrow-item/{id}', [BorrowController::class, 'viewBorrowItem'])->name('view-borrow-item');
    Route::post('/admin-added-order', [BorrowController::class, 'adminAddedOrder'])->name('adminAddedOrder');
    Route::post('/admin-new-order', [BorrowController::class, 'adminNewOrder'])->name('adminNewOrder');
    Route::post('/user-new-order', [BorrowController::class, 'userNewOrder'])->name('userNewOrder');
    Route::get('/removeBorrow/{order_item_id}/{serial_number}/{description}', [BorrowController::class, 'removeBorrow'])->name('removeBorrow');



    //storing references
    Route::post('store-references', [ReferenceController::class, 'storeReferences'])->name('store_references');
    Route::get('get-references', [ReferenceController::class, 'getReferences'])->name('get_references');

    //reports
    Route::get('generate-report', [ItemsController::class, 'generateReportPage'])->name('generate_report');
    Route::post('download-report', [ItemsController::class, 'downloadReport'])->name('download_pdf');
    Route::post('/download-returned-items-report', [ItemsController::class, 'downloadReturnedReport'])->name('download_returned_pdf');
    Route::post('/download-borrowed-items-report', [ItemsController::class, 'downloadBorrowedReport'])->name('download_borrowed_pdf');
    Route::get('/report-test', [ItemsController::class, 'reportTest']);
});

//student
Route::middleware(['auth', 'user-role:student'])->group(function () {
    //student
    Route::middleware(['user-role:student'])->group(function () {

        Route::middleware(['account_status:pending'])->group(function () {
            Route::get('/approve', [PagesController::class, 'approve'])->name('approval');
        });

        Route::middleware(['account_status:approved'])->group(function () {

            Route::controller(StudentController::class)->group(function () {
                Route::get('/student-dashboard', 'index')->name('student.dashboard');
                Route::get('/student-items', 'items')->name('student.items');
                Route::get('/view-item-{serial_number}', 'viewItemDetails')->name('student.view.item');
            });

            //cart
            Route::post('/student-add-cart/{id}', [CartController::class, 'add_cart'])->name('add.cart');
            Route::get('/student-cart-list', [CartController::class, 'cart_list'])->name('cart.list');
            Route::get('/remove-cart/{id}', [CartController::class, 'remove_cart'])->name('remove.cart');
            Route::get('/order-cart', [CartController::class, 'order_cart'])->name('order.cart');
            Route::get('/history', [CartController::class, 'history'])->name('history');
            Route::get('/pending-order', [CartController::class, 'pending'])->name('pending-order');
            Route::post('/update-cart/{id}', [CartController::class, 'update_cart'])->name('cart.update');


            //agreement
            Route::get('/agreement', [StudentController::class, 'agreement'])->name('agreement');
            Route::get('agreement-approve/{id}', [StudentController::class, 'agreement_approve'])->name('agreement.approve');
            // Route::get('/test',[PagesController::class,'test'])->name('test');

            Route::post('/store-selected-category', 'App\Http\Controllers\CategoryController@storeSelectedCategory')->name('storeSelectedCategory');

            // Route::get('/student-cart-list',[BorrowController::class,'cartList'])->name('student.cart.list');
            // Route::delete('/remove-from-cart',[BorrowController::class,'remove'])->name('remove.from.cart');
            // Route::delete('/deleting-item-{serial_number}', [BorrowController::class,'remove'])->name('remove_item');

        });
    });
});
