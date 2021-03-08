<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Blade;

use App\Models\User;

use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
	/**
	 * Register any application services.
	 *
	 * @return void
	 */
	public function register()
	{
		//
	}

	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		// Schema::defaultStringLength(191);

		// current password validation rule
		Validator::extend('current_password', function ($attribute, $value, $parameters, $validator) {
			return Hash::check($value, auth()->user()->password);
		});

		Validator::extend('code_count', function ($attribute, $value, $parameters, $validator) {
			if (auth()->user()->phone_code_error == 3) {
				User::whereId(auth()->user()->id)->update(['phone_code' => NULL]);
				return false;
			}
			return true;
		});

		Validator::extend('code_correct', function ($attribute, $value, $parameters, $validator) {
			if ($value != auth()->user()->phone_code or auth()->user()->phone_code == NULL) {
				User::whereId(auth()->user()->id)->update(['phone_code_error' => auth()->user()->phone_code_error + 1]);
				return false;
			}
			return true;
		});

		Validator::extend('code_live', function ($attribute, $value, $parameters, $validator) {
			if (time() > auth()->user()->phone_code_at + 10 * 60) {
				User::whereId(auth()->user()->id)->update(['phone_code' => NULL]);
				return false;
			}

			return true;
		});





		Blade::if('investor', function () {
			return auth()->user()->role == 'investor';
		});

		Blade::if('admin', function () {
			return auth()->user()->role == 'admin';
		});

		Blade::if('admininvestor', function () {
			return in_array(auth()->user()->role, ['admin', 'investor']);
		});

		Blade::if('manager', function () {
			return auth()->user()->role == 'manager';
		});

		Blade::if('user', function () {
			return auth()->user()->role == 'user';
		});
	}
}
