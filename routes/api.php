<?php
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Route;
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
    Route::middleware('auth:api')->get('/user', function (Request $request) {
        return $request->user();
    });
    //-------------------------------------------------------------------------
    Route::group(['prefix' => 'user'], function () {
        // Required user login
        Route::group(['middleware' => ['auth:appUser']], function () {
            Route::post('review', 'Admin\ReviewController@store');
            Route::get('branch/{id}/branchService/{readall}', 'Admin\BranchController@branchService');
            Route::post('getTimeSlot', 'Admin\BranchController@getTimeSlot');
            // BookingMasterController 
            Route::post('booking', 'BookingMasterController@store');
            Route::get('booking', 'BookingMasterController@userBooking');
            Route::get('booking/{id}', 'BookingMasterController@singleBooking');
            Route::delete('booking', 'BookingMasterController@deleteBooking');
            // AppUsersController
            Route::post('newpassword', 'AppUsersController@newPassword');
            Route::post('profile/update', 'AppUsersController@profileUpdate');
            Route::post('profile/password/update', 'AppUsersController@password');
            Route::post('profile/picture/update', 'AppUsersController@profilePictureUpdate');
            Route::get('notification', 'AppUsersController@notiList');
            Route::get('favorite/salon/{id}', 'AppUsersController@userFevSalon');
            Route::get('favorite/salon', 'AppUsersController@userFevSalonList');
            Route::post('selectsite', 'AppUsersController@selectsite');
            // Other
            Route::get('profile', function (Request $request) {
                return $request->user();
            });
        });
        // Admin
        Route::group(['namespace' => 'Admin'], function () {
            Route::get('home', 'BranchController@apiHome');
            Route::get('category/{id}/branch', 'BranchController@branchByCategory');
            Route::get('branch/{id}', 'BranchController@singleBranch');
            Route::get('branch', 'BranchController@allBranch');
            Route::get('filleter/branch/{type}', 'BranchController@FilterBranch');
            
            Route::get('subcategory', 'SubCategoryController@getById');
            
            Route::get('offer', 'OfferController@apiIndex');
            Route::post('applyCode', 'OfferController@applyCode');
            Route::get('payment/setting', 'AdminSettingController@apiPaymentData');
            Route::post('available/employee', 'BranchController@getEmployee');
            Route::get('noti/setting', 'AdminSettingController@apiNotiKey');
            Route::get('version', 'AdminSettingController@versionCheck');
        });
        // Direct access by api
        // User Login Related
        Route::post('register', 'AppUsersController@store');
        Route::post('register/requestOTP', 'AppUsersController@requestOTP');
        Route::post('verifyMe', 'AppUsersController@verifyMe');
        Route::post('login', 'AppUsersController@login');
        Route::post('logout', 'AppUsersController@logout');
        Route::post('forgot', 'AppUsersController@forgot');
        Route::post('forgot/validate', 'AppUsersController@forgotValidate');
        // Info Pages
        Route::get('privacy', 'AppUsersController@privacy');
        Route::get('bookprivacy', 'AppUsersController@bookprivacy');
    });
    //-------------------------------------------------------------------------
    // Site Panel
    Route:: group(['prefix' => 'admin'], function() {
        Route::group(['middleware' => ['auth:sanctum']], function () {
            Route::get('booking/{id}/{status}', 'BookingMasterController@statusChange')->name('booking.status');
            Route::get('sync/polling', 'SyncController@polling');
            Route::get('sync/services', 'SyncController@getSubCategories');
            Route::post('sync/client', 'SyncController@getAppUserDataTableData');
            Route::post('sync/get-app-user-by-cloudid', 'SyncController@getAppUserByCloudId');
            Route::post('sync/update', 'SyncController@updateBooking');
            Route::post('sync/update_user_status', 'SyncController@updateUserStatus');
            Route::post('sync/update-user-branch-status', 'SyncController@updateUserBranchStatus');
            Route::post('sync/reject_booking', 'SyncController@rejectBooking');
            Route::get('/sync/get-new-user-count', 'SyncController@getNewUserCounts');
            Route::post('sync/push_batch_notification', 'SyncController@pushBatchNoti');
        });
        
    });

    // API for eRun
    Route:: group(['prefix' => 'admin'], function() {
        Route::post('bill/create', 'Admin\BillController@api_createBill');
        Route::post('bill/settle', 'Admin\BillController@api_settleBill');
        Route::post('bill/completeCheck', 'Admin\BillController@api_completeBill');
        Route::post('bill/cancel', 'Admin\BillController@api_cancelBill');
        Route::post('bill/void', 'Admin\BillController@api_refundBill');
        Route::post('bill/voidCheck', 'Admin\BillController@api_checkRefund');
        Route::get('member/search', 'Admin\MembersController@api_searchMember');
        Route::post('member/create', 'Admin\MembersController@api_insertNewMember');
        Route::post('member/update', 'Admin\MembersController@api_updateMember');
        Route::post('member/delete', 'Admin\MembersController@api_deleteMember');
        Route::get('checkcoupon', 'Admin\NoShowCouponController@api_checkCoupon');
        Route::post('checkcoupons', 'Admin\NoShowCouponController@api_checkCoupons');
    });

        // API for eRun
        Route:: group(['prefix' => 'kiosk'], function() {
            Route::get('member/kiosk', 'Admin\MembersController@api_kioskSearch');
        });
    
    //-------------------------------------------------------------------------