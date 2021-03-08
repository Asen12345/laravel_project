<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
	/*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

	use RegistersUsers;

	/**
	 * Where to redirect users after registration.
	 *
	 * @var string
	 */
	protected $redirectTo = RouteServiceProvider::HOME;

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('guest');
	}

	/**
	 * Get a validator for an incoming registration request.
	 *
	 * @param  array  $data
	 * @return \Illuminate\Contracts\Validation\Validator
	 */
	protected function validator(array $data)
	{
		return Validator::make($data, [
			'first_name' => ['required', 'string', 'max:255'],
			'referral_code' => ['required', 'exists:users,referral_code'],
			'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
			'password' => ['required', 'string', 'min:8', 'confirmed'],
			'policy' => ['required']
		]);
	}

	/**
	 * Create a new user instance after a valid registration.
	 *
	 * @param  array  $data
	 * @return \App\User
	 */
	protected function create(array $data)
	{
		$referrer = User::where('referral_code', $data['referral_code'])->first();

		if ($referrer) {
			$referrer_id = $referrer->id;
			$referral_code = substr(md5(uniqid(mt_rand(), true)), 0, 8); // 8 знаков
			$tl_key = md5($referrer_id . $data['email']);
			$user = User::create([
				'first_name' => $data['first_name'],
				'referrer_id' => $referrer_id,
				'referral_code' => $referral_code,
				'email' => $data['email'],
				'password' => Hash::make($data['password']),
				'tl_key' => $tl_key
			]);

			return $user;
		}

		return false;
	}
}
