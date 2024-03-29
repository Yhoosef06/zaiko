<?php

use Illuminate\Http\Request;
use App\Models\SecurityQuestion;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QRController;
use App\Http\Controllers\CsvController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\TermController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\ItemsController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\BorrowController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\ModelsController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\CollegeController;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Http\Controllers\BorrowerController;
use App\Http\Controllers\AgreementController;
use App\Http\Controllers\ReferenceController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\PermissionController;
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

Route::get('/download-qr-code/{itemId}', function ($itemId) {
    $qrCode = QrCode::size(200)->generate($itemId);
    $file = public_path('qr_codes/item_' . $itemId . '.png');
    file_put_contents($file, base64_decode($qrCode));

    return response()->download($file)->deleteFileAfterSend(true);
})->name('download_qr_code');

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
Route::get('/agreement/form', [AgreementController::class, 'show'])->name('agreement_show');
Route::put('/agreement/agreed', [AgreementController::class, 'agreed'])->name('agreed');

//common
Route::get('change-user-{id_number}-password', [UserController::class, 'changeUserPassword'])->name('change_user_password');
Route::post('updating-user-{id_number}-password', [UserController::class, 'saveUserNewPassword'])->name('save_user_new_password');
Route::get('profile-{id_number}', [UserController::class, 'viewProfile'])->name('view_profile');
Route::get('edit-profile-{id_number}', [UserController::class, 'editProfile'])->name('edit_profile');
Route::post('save-edited-profile-{id_number}', [UserController::class, 'saveEditedProfileInfo'])->name('save_edited_profile_info');
Route::get('modify-security-question-{id_number}', [UserController::class, 'modifySecurityQuestion'])->name('modify_security_question');
Route::post('save-modified-security-question-{id_number}', [UserController::class, 'saveModifiedSecurityQuestion'])->name('save_modified_security_question');

//admin
Route::middleware(['auth', 'role:admin,manager'])->group(function () {

    Route::controller(PagesController::class)->group(function () {
        Route::get('/admin-dashboard', 'index')->name('admin.dashboard');
    });
    Route::get('/dashboard', [PagesController::class, 'index'])->name('admin.dashboard');


    // Route::get('adding-new-item', [PagesController::class, 'addItem'])->name('add_item');
    Route::get('pdf-view', [PagesController::class, 'printPDF'])->name('pdf_view');
    Route::post('selectDepartment', [PagesController::class, 'selectDepartment'])->name('selectDepartment');


    // FOR ITEMS
    Route::middleware(['permission:manage-inventory'])->group(function () {
        Route::middleware(['permission:view-items'])->group(function () {
            Route::get('list-of-items', [ItemsController::class, 'index'])->name('view_items');
            Route::get('view-item-details-{id}', [ItemsController::class, 'viewItemDetails'])->name('view_item_details');
            Route::get('list-of-items-filtered', [ItemsController::class, 'searchItem'])->name('filtered_view');
            Route::get('get-item-{id}-details', [ItemsController::class, 'getItemDetails'])->name('get_item_details');
            Route::get('/get-brand', [ItemsController::class, 'getBrand']);
            Route::get('/get-model', [ItemsController::class, 'getModel']);
            Route::get('/get-part-number', [ItemsController::class, 'getPartNumber']);
            Route::get('/check-serial-number/{serial_number}', [ItemsController::class, 'checkSerialNumber'])->name('check_serial_number');
            Route::get('/items/search', [ItemsController::class, 'searchItem'])->name('items.search');
            Route::get('/items/sort/{order}', [ItemsController::class, 'sortItems'])->name('sort_items');
            Route::get('/get-filtered-items', [ItemsController::class, 'getFilteredItems'])->name('get_filtered_items');
            Route::get('/get-part-numbers', [ItemsController::class, 'getPartNumber']);
            Route::get('/get-models-by-brand/{brandId}', [ItemsController::class, 'getModelsByBrand']);
        });
        Route::middleware(['permission:generate-report'])->group(function () {
            Route::get('generate-report', [ReportController::class, 'generateReportPage'])->name('generate_report');
            Route::post('download-report', [ReportController::class, 'downloadReport'])->name('download_pdf');
            Route::post('/download-returned-items-report', [ItemsController::class, 'downloadReturnedReport'])->name('download_returned_pdf');
            Route::post('/download-borrowed-items-report', [ItemsController::class, 'downloadBorrowedReport'])->name('download_borrowed_pdf');
        });
    });

    Route::middleware(['permission:manage-inventory'])->group(function () {
        Route::middleware(['permission:add-items'])->group(function () {
            Route::get('adding-new-item', [ItemsController::class, 'addItem'])->name('add_item');
            Route::post('saving-new-item', [ItemsController::class, 'saveNewItem'])->name('save_new_item');
        });
        Route::middleware(['permission:update-items'])->group(function () {
            Route::get('edit-item-{id}', [ItemsController::class, 'editItemPage'])->name('edit_item_details');
            Route::put('updating-item-{id}-details', [ItemsController::class, 'saveEditedItemDetails'])->name('update_item_details');
        });
        Route::middleware(['permission:delete-items'])->group(function () {
            Route::post('deleting-item-{id}', [ItemsController::class, 'deleteItem'])->name('delete_item');
        });
        Route::middleware(['permission:transfer-items'])->group(function () {
            Route::get('/transfer-item-{id}', [ItemsController::class, 'transferItem'])->name('transfer_item');
            Route::post('/save-transfer-item-{id}', [ItemsController::class, 'saveTransferItem'])->name('save_transfer_item');
        });
        Route::middleware(['permission:add-sub-items'])->group(function () {
            Route::get('/add-sub-item-{id}', [ItemsController::class, 'addSubItem'])->name('add_sub_item');
            Route::post('/save-sub-item-{id}', [ItemsController::class, 'saveSubItem'])->name('save_sub_item');
        });

        Route::middleware(['permission:replace-items'])->group(function () {
            Route::get('/replace-item-{id}', [ItemsController::class, 'replaceItem'])->name('replace_item');
            Route::post('/save-replaced-item-{id}', [ItemsController::class, 'saveReplacedItem'])->name('save_replaced_item');
        });
    });

    // FOR USERS
    Route::middleware(['permission:manage-users'])->group(function () {
        Route::middleware(['permission:view-users'])->group(function () {
            Route::get('list-of-users', [UserController::class, 'index'])->name('view_users');
            Route::get('list-of-users-filtered', [UserController::class, 'searchUser'])->name('filtered_view_users');
            Route::get('view-user-{id_number}', [UserController::class, 'viewUserInfo'])->name('view_user_info');
            Route::get('/users/search', [UserController::class, 'searchUser'])->name('users.search');
        });
        Route::middleware(['permission:add-users'])->group(function () {
            Route::get('add-new-user', [UserController::class, 'addUser'])->name('add_user');
            Route::post('saving-new-user', [UserController::class, 'saveNewUser'])->name('save_new_user');
        });
        Route::middleware(['permission:update-users'])->group(function () {
            Route::get('edit-user-{id_number}', [UserController::class, 'editUserInfo'])->name('edit_user_info');
            Route::put('updating-user-{id_number}', [UserController::class, 'saveEditedUserInfo'])->name('update_user_info');
        });
        Route::middleware(['permission:delete-users'])->group(function () {
            Route::post('deleting-user-{id_number}', [UserController::class, 'deleteUser'])->name('delete_user');
        });
    });

    Route::post('save-new-brand', [BrandController::class, 'saveNewBrand'])->name('save_new_brand');
    Route::post('save-new-model', [ModelsController::class, 'saveNewModel'])->name('save_new_model');
    Route::post('save-new-room', [RoomController::class, 'saveNewRoom'])->name('save_new_room');
    Route::post('saving-new-category', [ItemCategoryController::class, 'saveNewCategory'])->name('save_new_category');

    Route::get('upload-csvfile', [UserController::class, 'uploadCSVFile'])->name('upload_csv_file');
    Route::post('/upload-csv', [CsvController::class, 'store'])->name('store_csv_file');
    Route::get('/get-filtered-users', [UserController::class, 'getFilteredUsers'])->name('get_filtered_users');

    //storing references
    Route::post('store-references', [ReferenceController::class, 'storeReferences'])->name('store_references');
    Route::get('get-references', [ReferenceController::class, 'getReferences'])->name('get_references');

    Route::get('add-room', [RoomController::class, 'addRoom'])->name('add_room');
    Route::get('/get-departments/{college_id}', [DepartmentController::class, 'getDepartments'])->name('get_departments');
    Route::get('add-item-category', [ItemCategoryController::class, 'addItemCategory'])->name('add_item_category');
    Route::get('add-brand', [BrandController::class, 'addBrand'])->name('add_brand');
    Route::get('/get-models/{brandId}', [ModelsController::class, 'getModels'])->name('get_models');
    Route::get('add-model', [ModelsController::class, 'addModel'])->name('add_model');
    Route::get('/download-qr-code/{itemId}', [ItemsController::class, 'downloadQRCode'])->name('download_qr_code');
});

//ADMIN
Route::middleware(['auth', 'role:admin'])->group(function () {
    // FOR Colleges
    Route::get('colleges', [CollegeController::class, 'index'])->name('view_colleges');
    Route::get('add-college', [CollegeController::class, 'addCollege'])->name('add_college');
    Route::get('edit/college/{id}', [CollegeController::class, 'editCollege'])->name('edit_college');
    Route::post('save-new-college', [CollegeController::class, 'saveNewCollege'])->name('save_new_college');
    Route::post('save-edited-college/{id}', [CollegeController::class, 'saveEditedCollege'])->name('save_edited_college');
    Route::post('delete-college-{id}', [CollegeController::class, 'deleteCollege'])->name('delete_college');

    //FOR Departments - ADMIN
    Route::get('departments', [DepartmentController::class, 'index'])->name('view_departments');
    Route::get('add-department', [DepartmentController::class, 'addDepartment'])->name('add_department');
    Route::post('save-new-department', [DepartmentController::class, 'saveNewDepartment'])->name('save_new_department');
    Route::get('edit/department/{id}', [DepartmentController::class, 'editDepartment'])->name('edit_department');
    Route::post('save-edited-department/{id}', [DepartmentController::class, 'saveEditedDepartment'])->name('save_edited_department');
    Route::post('delete-department/{id}', [DepartmentController::class, 'deleteDepartment'])->name('delete_department');
    Route::get('/get-filtered-departments', [DepartmentController::class, 'getFilteredDepartments'])->name('get_filtered_departments');
    Route::get('/departments/search', [DepartmentController::class, 'searchDepartment'])->name('departments.search');


    // FOR ROOM - ADMIN
    Route::get('rooms', [RoomController::class, 'index'])->name('view_rooms');

    Route::get('edit/room/{id}', [RoomController::class, 'editRoom'])->name('edit_room');
    Route::post('save-edited-room/{id}', [RoomController::class, 'saveEditedRoom'])->name('save_edited_room');
    Route::post('delete-room/{id}', [RoomController::class, 'deleteRoom'])->name('delete_room');
    Route::get('/get-filtered-rooms', [RoomController::class, 'getFilteredRooms'])->name('get_filtered_rooms');
    Route::get('/rooms/search', [RoomController::class, 'searchRoom'])->name('rooms.search');

    // FOR Item Category -ADMIN
    Route::get('item-categories', [ItemCategoryController::class, 'index'])->name('view_item_categories');
    Route::get('edit/item-category/{id}', [ItemCategoryController::class, 'editItemCategory'])->name('edit_item_category');

    Route::post('save-edited-item-category/{id}', [ItemCategoryController::class, 'saveEditedItemCategory'])->name('save_edited_item_category');
    Route::post('delete-category/{id}', [ItemCategoryController::class, 'deleteCategory'])->name('delete_category');

    //FOR BRAND - ADMIN
    Route::get('brands', [BrandController::class, 'index'])->name('view_brands');
    Route::get('edit/brand/{id}', [BrandController::class, 'editBrand'])->name('edit_brand');
    Route::post('save-edited-brand/{id}', [BrandController::class, 'saveEditedBrand'])->name('save_edited_brand');
    Route::post('delete-brand/{id}', [BrandController::class, 'deleteBrand'])->name('delete_brand');
    Route::get('/brands/search', [BrandController::class, 'searchBrand'])->name('brands.search');

    //FOR MODELS - ADMIN
    Route::get('models', [ModelsController::class, 'index'])->name('view_models');
    Route::get('edit/model/{id}', [ModelsController::class, 'editModel'])->name('edit_model');
    Route::post('save-edited-model/{id}', [ModelsController::class, 'saveEditedModel'])->name('save_edited_model');
    Route::post('delete-model/{id}', [ModelsController::class, 'deleteModel'])->name('delete_model');
    Route::get('/get-filtered-models', [ModelsController::class, 'getFilteredModels'])->name('get_filtered_models');
    Route::get('/models/search', [ModelsController::class, 'searchModel'])->name('models.search');

    //TERM - ADMIN
    Route::get('terms', [TermController::class, 'index'])->name('view_terms');
    Route::get('add-term', [TermController::class, 'addTerm'])->name('add_term');
    Route::post('save-new-term', [TermController::class, 'saveNewTerm'])->name('save_new_term');
    Route::delete('delete-term/{id}', [TermController::class, 'deleteTerm'])->name('delete_term');
    Route::post('current-term/{id}', [TermController::class, 'currentTerm'])->name('current_term');

    //Roles
    Route::get('roles', [RoleController::class, 'index'])->name('view_roles');
    Route::post('adding-permission', [RoleController::class, 'store'])->name('store_permission');
    Route::delete('removing-permission-{id}', [RoleController::class, 'delete'])->name('delete_permission');

    Route::get('/agreement/index', [AgreementController::class, 'index'])->name('agreement_index');
    Route::post('/agreement/save', [AgreementController::class, 'store'])->name('agreement_store');

});

//MANAGER
Route::middleware(['auth', 'role:manager'])->group(function () {
    //FOR Manage Borrowingss
    Route::middleware(['permission:manage-borrowings'])->group(function () {
      
        Route::get('borrowed', [BorrowController::class, 'borrowed'])->name('borrowed');
        Route::get('overdue', [BorrowController::class, 'overdue'])->name('overdue');
        Route::get('pending', [BorrowController::class, 'pending'])->name('pending');
        Route::get('returned', [BorrowController::class, 'returned'])->name('returned');
        Route::post('selectDateRange', [BorrowController::class, 'selectDateRange'])->name('selectDateRange');

        // Route::get('pending-item/{id}/{serial_number}', [BorrowController::class, 'pendingItem'])->name('pending_item');
        // Route::get('borrow-item/{id}/{serial_number}', [BorrowController::class, 'borrowItem'])->name('borrow_item');
        Route::get('remove-borrow/{id}', [BorrowController::class, 'removeBorrow'])->name('remove-borrow');
        Route::get('/order-user-remove/{id}', [BorrowController::class, 'orderUserRemove'])->name('order-user-remove');
        Route::get('complete-transaction/{id}', [BorrowController::class, 'completeTransaction'])->name('complete-transaction');
        Route::get('order-admin-remove/{id}', [BorrowController::class, 'orderAdminRemove'])->name('order-admin-remove');
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

        Route::post('/addOrder', [BorrowController::class, 'addOrder'])->name('addOrder');
        Route::post('/addRemark', [BorrowController::class, 'addRemark'])->name('addRemark');
        Route::post('/lostItem', [BorrowController::class, 'lostItem'])->name('lostItem');
        Route::post('/lostOverdueItem', [BorrowController::class, 'lostOverdueItem'])->name('lostOverdueItem');
        Route::post('/returnOverdueItem', [BorrowController::class, 'returnOverdueItem'])->name('returnOverdueItem');
        Route::get('view-order-admin/{id}', [BorrowController::class, 'viewOrderAdmin'])->name('view-order-admin');
        Route::get('view-order-user/{id}', [BorrowController::class, 'viewOrderUser'])->name('view-order-user');
        Route::get('view-borrow-item/{id}', [BorrowController::class, 'viewBorrowItem'])->name('view-borrow-item');
        Route::post('/admin-added-order', [BorrowController::class, 'adminAddedOrder'])->name('adminAddedOrder');
        Route::post('/admin-new-order', [BorrowController::class, 'adminNewOrder'])->name('adminNewOrder');
        Route::post('/user-new-order', [BorrowController::class, 'userNewOrder'])->name('userNewOrder');
        Route::get('/removeBorrow/{order_item_id}/{serial_number}/{description}', [BorrowController::class, 'removeBorrow'])->name('removeBorrow');
    });

});

//student
Route::middleware(['auth', 'role:manager,borrower', 'agreement'])->group(function () {
    //student
    Route::middleware(['permission:borrow-items'])->group(function () {

        Route::controller(BorrowerController::class)->group(function () {
            Route::get('/borrower-dashboard', 'index')->name('borrower.dashboard');
            //     Route::get('/borrower-items', 'items')->name('student.items');
            Route::get('/view-item-{serial_number}', 'viewItemDetails')->name('student.view.item');
        });

        //BROWSING
        Route::get('/browse-items', [BorrowerController::class, 'browse'])->name('browse.items');
        Route::get('/search-items', [BorrowerController::class, 'search'])->name('browse.search');
        Route::get('/browse-items/department', [BorrowerController::class, 'browseDepartment'])->name('browse.department');
        Route::get('/browse-items/department/category', [BorrowerController::class, 'browseCategory'])->name('browse.category');

        //BROWSE TEST
        Route::get('/browse-items-test', [BorrowerController::class, 'browse_test'])->name('browse.items.test');

        //cart
        Route::get('/browse-cart', [CartController::class, 'browse'])->name('browse.cart');
        Route::get('/browse-cart/{id}', [CartController::class, 'browse_cart'])->name('browse.cart-id');
        Route::post('/student-add-cart/{id}', [CartController::class, 'add_cart'])->name('add.cart');
        Route::get('/student-cart-list', [CartController::class, 'cart_list'])->name('cart.list');
        Route::get('/remove-cart/{id}', [CartController::class, 'remove_cart'])->name('remove.cart');
        Route::get('/order-cart', [CartController::class, 'order_cart'])->name('order.cart');
        Route::get('/history', [CartController::class, 'history'])->name('history');
        Route::get('/pending-order', [CartController::class, 'pending'])->name('pending-order');
        Route::get('/remove-transaction/{id}', [CartController::class, 'remove_transaction'])->name('remove.transaction');
        Route::get('/borrowed-items', [CartController::class, 'borrowed'])->name('borrowed-items');
        Route::post('/update-cart/{id}', [CartController::class, 'update_cart'])->name('cart.update');



        //agreement
        Route::get('/agreement', [BorrowerController::class, 'agreement'])->name('agreement');
        Route::get('agreement-approve/{id}', [BorrowerController::class, 'agreement_approve'])->name('agreement.approve');
        // Route::get('/test',[PagesController::class,'test'])->name('test');

        Route::post('/store-selected-category', 'App\Http\Controllers\CategoryController@storeSelectedCategory')->name('storeSelectedCategory');
        Route::post('/store-selected-department', 'App\Http\Controllers\CategoryController@storeSelectedDepartment')->name('storeSelectedDepartment');

        // Route::get('/student-cart-list',[BorrowController::class,'cartList'])->name('student.cart.list');
        // Route::delete('/remove-from-cart',[BorrowController::class,'remove'])->name('remove.from.cart');
        // Route::delete('/deleting-item-{serial_number}', [BorrowController::class,'remove'])->name('remove_item');

    });
});
