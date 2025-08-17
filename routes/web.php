
<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\MembersController;
use App\Http\Controllers\Admin\CouponsController;

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

Route::get('/home', 'HomeController@welcome')->name('home');

Route::get('/home', 'HomeController@index')->name('welcome');

Route::group(['middleware' => ['auth']], function () {
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'ProfileController@update']);
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'ProfileController@password']);
});

Route::group(['middleware' => ['auth']], function () {

	Route::group(['namespace' => 'Admin'], function () {

		Route::resources([
			'coupon' => 'CouponsController',
		]);
		Route::resource('roles', 'RolesController');
		Route::resource('users', 'UsersController');
		Route::resource('members', 'MembersController')->except(['show']);
		Route::resource('coupons', 'CouponsController')->except(['show']);		

		Route::get('members/search', [MembersController::class, 'search'])->name('members.search');
		Route::get('members/export', [App\Http\Controllers\Admin\MembersController::class, 'export'])->name('members.export');
		Route::post('members/import', [App\Http\Controllers\Admin\MembersController::class, 'import'])->name('members.import');

		Route::get('coupons/search', [CouponsController::class, 'search'])->name('coupons.search');
		Route::get('coupons/export', [App\Http\Controllers\Admin\CouponsController::class, 'export'])->name('coupons.export');
		Route::post('coupons/import', [App\Http\Controllers\Admin\CouponsController::class, 'import'])->name('coupons.import');

		Route::get('redeem/treasure', 'RedeemStampController@index')->name('redeem.treasure');		
		Route::post('treasure/getMemberStamps', 'RedeemStampController@getUserStamp')->name('treasure.getMemberStamps');
		Route::post('treasure/setStampUsed', 'RedeemStampController@setStampUsed')->name('treasure.setStampUsed');
		
		Route::get('redeem/coupon', 'RedeemCouponController@index')->name('redeem.coupon');		
		Route::post('coupon/getCoupon', 'RedeemCouponController@getCoupon')->name('coupon.getCoupon');		
		Route::post('coupon/setCouponUsed', 'RedeemCouponController@setCouponUsed')->name('coupon.setCouponUsed');			
		
		Route::get('used_coupon/index', 'UsedCouponController@index')->name('used_coupon.index');		
		Route::get('used_coupon/search', 'UsedCouponController@search')->name('used_coupon.search');		

		Route::post('users/createtoken', 'UsersController@createBranchApiToken')->name('users.createtoken');
	});
});


Route::prefix('member')
	->as('member.')
	->group(function() {
		Route::group(['namespace' => 'Member'], function () {
			Route::get('login', 'LoginController@index')->name('login');

			Route::get('/pay', 'Payment\StripeController@showCheckout')->name('pay.stripe.show');
			Route::post('/payment-intent', 'Payment\StripeController@createIntent')->name('pay.stripe.intent');
			Route::get('/pay/success', 'Payment\StripeController@success')->name('pay.success');

			Route::post('/alipayhk/checkout', 'Payment\AlipayHkController@checkout');
			Route::get('/alipayhk/return', 'Payment\AlipayHkController@return')->name('alipayhk.return');
			Route::post('/webhooks/alipayplus/payment', 'Payment\AlipayHkController@webhook');

		});
	});