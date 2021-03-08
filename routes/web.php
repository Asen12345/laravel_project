<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Http\Request;

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

// use Illuminate\Support\Facades\Mail;
// use App\Mail\Password;
// Route::get('mail/send', function () {
// 	$user = auth()->user();
// 	$password = 'YOUR_PASSWORD';
// 	Mail::to($user->email)->send(new Password($user, $password));
// });


Route::get('locale/{locale}', function ($locale) {
	// Session::put('locale', $locale);
	Cookie::queue('locale', $locale, 10000000000);
	return redirect()->back();
})->name('locale');

Route::get('/', function () {
	return redirect()->route('login');
});

Route::get('/register/{code}/{locale}', function (Request $request, $code, $locale) {
	$minutes = 60 * 24 * 60;

//  Cookie::queue(Cookie::forget('partner'));
//	Cookie::queue('partner', $code, $minutes);
	Cookie::queue('locale', $locale, 10000000000);
	cookie('partner', $code, $minutes);
	return redirect()->route('register')
	->withCookie(Cookie::forget('partner'))
	->withCookie(cookie('partner', $code, $minutes));
})->name('referral');

Route::get('/image_user/{id}', 'ImageController@getImage');

Auth::routes(['verify' => true]);
Route::middleware(['auth', 'verified'])->group(function () {
	Route::get('/profile', 'ProfileController@index')->name('profile');
	Route::post('/profile', 'ProfileController@personal_data')->name('personal_data');

	Route::post('/profile/phone/code', 'ProfileController@send_sms_code_new_phone')->name('send_sms_code_new_phone');
	Route::post('/profile/phone', 'ProfileController@check_sms_code_new_phone')->name('check_sms_code_new_phone');

	Route::post('/profile/password', 'ProfileController@change_password')->name('change_password');
	Route::post('/profile/avatar', 'ProfileController@change_avatar')->name('change_avatar');

	Route::middleware(['checkPhone'])->group(function () {
		Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
		Route::get('/curator', 'ProfileController@curator')->name('curator');
		Route::get('/partners', 'ProfileController@partners')->name('partners');

		Route::get('/licenses', 'LicensesController@index')->name('licenses');
		Route::post('/licenses/to_appoint', 'LicensesController@to_appoint')->name('to_appoint');
		Route::post('/licenses/to_activate', 'LicensesController@to_activate')->name('to_activate_license');
		Route::post('/licenses/buy', 'LicensesController@buy')->name('license_buy');

		Route::get('/investor/dashboard', 'InvestorController@dashboard')->name('investor_dashboard');
		Route::get('/profile/promo', 'ProfileController@promo')->name('promo');

		Route::get('/finances', 'FinancesController@index')->name('finances');
		Route::get('/team', 'TeamController@scheme')->name('team');
		Route::put('/team/update_status', 'TeamController@update_status')->name('update_status_second');
		Route::post('/team/update_status', 'TeamController@update_status')->name('update_status');
		


		Route::middleware('auth.admininvestor')->group(function () {
			Route::get('/investor', 'InvestorController@index')->name('investor');
			Route::get('/investor/withdraw_modal', 'InvestorController@withdraw_modal')->name('investor_withdraw_modal');
			Route::post('/investor/withdraw', 'InvestorController@withdraw')->name('investor_to_withdraw');
			Route::post('/investor/withdraw_go', 'InvestorController@withdraw_go')->name('investor_withdraw_go');
		});

		Route::namespace('Admin')->middleware('auth.admin')->prefix('admin')->name('admin.')->group(function () {
			Route::resource('/promo', 'PromoController');

			Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
			Route::post('/dashboard/summary', 'DashboardController@summary_ajax')->name('dashboard.summary');

			Route::get('/licenses', 'LicensesController@index')->name('licenses');

			Route::resource('/news', 'NewsController');
			Route::resource('/settings', 'SettingsController');
			Route::resource('/robots', 'RobotsController');
			Route::resource('/robot-settings', 'RobotSettingsController', [
				'except' => ['index', 'show', 'create', 'store']
			]);
			Route::get('/robot/{robot}/settings', 'RobotSettingsController@index')->name('robot-settings.index');
			Route::get('/robot/{robot}/settings/create', 'RobotSettingsController@create')->name('robot-settings.create');
			Route::post('/robot/{robot}/settings/store', 'RobotSettingsController@store')->name('robot-settings.store');

			Route::resource('/robot-setting-parametrs', 'RobotSettingParametrsController', [
				'except' => ['index', 'show', 'create', 'store']
			]);
			Route::get('/robot-setting/{setting}/parametrs', 'RobotSettingParametrsController@index')->name('robot-setting-parametrs.index');
			Route::get('/robot-setting/{setting}/parametrs/create', 'RobotSettingParametrsController@create')->name('robot-setting-parametrs.create');
			Route::post('/robot-setting/{setting}/parametrs/store', 'RobotSettingParametrsController@store')->name('robot-setting-parametrs.store');



			Route::get('/users', 'UsersController@index')->name('users');
			Route::get('/users/{user}', 'UsersController@info')->name('users.info');

			Route::post('/users/licenses/block', 'UsersController@licenses_block')->name('users.licenses.block');
			Route::post('/users/licenses/detach', 'UsersController@licenses_detach')->name('users.licenses.detach');
			Route::post('/users/licenses/renew', 'UsersController@licenses_renew')->name('users.licenses.renew');

			Route::post('/users/login_as', 'UsersController@login_as')->name('users.login_as');

			Route::post('/users/{user}/personal_data', 'UsersController@personal_data')->name('users.personal_data');
			Route::post('/users/{user}/change_password', 'UsersController@change_password')->name('users.change_password');

			Route::get('/payments', 'PaymentsController@index')->name('payments');
			Route::post('/payments/execute', 'PaymentsController@execute')->name('payments.execute');
		});


		Route::get('/news', 'NewsController@index')->name('news');
		Route::get('/news/{article}', 'NewsController@show')->name('new');
		Route::get('/robots', 'RobotsController@index')->name('robots');

		Route::post('/get_code', 'ProfileController@get_code')->name('get_code');



		// Route::get('/finances/withdraw', 'FinancesController@withdraw')->name('to_withdraw');

		Route::get('/team/set_redirect', 'TeamController@set_redirect')->name('set_redirect');
		Route::get('/team/remove_redirect', 'TeamController@remove_redirect')->name('remove_redirect');


		Route::get('/finances/deposit_modal', 'FinancesController@deposit_modal')->name('deposit_modal');
		Route::post('/finances/deposit', 'FinancesController@deposit')->name('to_deposit');

		Route::get('/finances/withdraw_modal', 'FinancesController@withdraw_modal')->name('withdraw_modal');
		Route::post('/finances/withdraw', 'FinancesController@withdraw')->name('to_withdraw');
		Route::post('/finances/withdraw_go', 'FinancesController@withdraw_go')->name('withdraw_go');

		Route::get('/finances/remittance_modal', 'FinancesController@remittance_modal')->name('remittance_modal');
		Route::post('/finances/remittance', 'FinancesController@remittance')->name('to_remittance');
		Route::post('/finances/remittance_go', 'FinancesController@remittance_go')->name('remittance_go');

		
		Route::get('/team/activate/{type}', 'TeamController@activate')->name('activate');
	});
});
