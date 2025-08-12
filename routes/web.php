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

		Route::resource('roles', 'RolesController');
		Route::resource('users', 'UsersController');
		Route::resource('members', 'MembersController')->except(['show']);

		Route::post('users/createtoken', 'UsersController@createBranchApiToken')->name('users.createtoken');
	});
});

// Route::resource('members', MembersController::class)->except(['show']);

Route::get('members/search', [MembersController::class, 'search'])->name('members.search');

Route::prefix('staff')
	->as('staff.')
	->group(function() {
		Route::group(['namespace' => 'Staff'], function () {
			Route::get('login', 'LoginController@index')->name('login');
		});
	});