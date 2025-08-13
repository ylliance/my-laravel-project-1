
<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\MembersController;

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

Route::get('/', function () {
	return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => ['auth']], function () {
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'ProfileController@update']);
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'ProfileController@password']);
});

Route::group(['middleware' => ['auth']], function () {

	Route::group(['namespace' => 'Admin'], function () {

		Route::resources([
			'coupon' => 'CouponController',
		]);
		Route::resource('roles', 'RolesController');
		Route::resource('users', 'UsersController');
		Route::resource('members', 'MembersController')->except(['show']);

		Route::get('redeem/treasure', 'RedeemTreasureController@index')->name('redeem.treasure');		
		Route::post('treasure/getMemberStamps', 'RedeemTreasureController@getUserStamp')->name('treasure.getMemberStamps');
		Route::post('treasure/setStampUsed', 'RedeemTreasureController@setStampUsed')->name('treasure.setStampUsed');

		
		Route::get('redeem/coupon', 'RedeemCouponController@index')->name('redeem.coupon');		
		Route::post('coupon/getCoupon', 'RedeemCouponController@getCoupon')->name('coupon.getCoupon');		
		Route::post('coupon/setCouponUsed', 'RedeemCouponController@setCouponUsed')->name('coupon.setCouponUsed');		

		Route::post('users/createtoken', 'UsersController@createBranchApiToken')->name('users.createtoken');
	});
});

Route::get('members/search', [MembersController::class, 'search'])->name('members.search');
Route::get('members/export', [App\Http\Controllers\Admin\MembersController::class, 'export'])->name('members.export');


Route::prefix('member')
	->as('member.')
	->group(function() {
		Route::group(['namespace' => 'Member'], function () {
			Route::get('login', 'LoginController@index')->name('login');
		});
	});