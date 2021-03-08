<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Account;
use App\Models\Payment;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Mail;
use App\Mail\Password;

class UserController extends Controller
{


	public function check_code(Request $request)
	{
		$lang = $request->get('lang') ? $request->get('lang') : 'en';
		app()->setLocale($lang);

		$validator = Validator::make($request->all(), [
			'user_id' => ["required"],
			'code' => ["required"], // , "code_correct", "code_live", "code_count"
		]);

		if ($validator->fails()) {
			return response()->json(['errors' => $validator->errors()]);
		}

		$user = User::find($request->get('user_id'));
		if ($user) {

			if ($user->phone_code_error == 3) {
				$user->update(['phone_code' => NULL]);
				return response()->json(['errors' => [
					'other' => [
						__("Too many mistakes")
					]
				]]);
			}

			if ($request->get('code') != $user->phone_code or $user->phone_code == NULL) {
				$user->update(['phone_code_error' => $user->phone_code_error + 1]);
				return response()->json(['errors' => [
					'other' => [
						__("Incorrect code")
					]
				]]);
			}

			if (time() > $user->phone_code_at + 10 * 60) {
				$user->update(['phone_code' => NULL]);
				return response()->json(['errors' => [
					'other' => [
						__("Code expired")
					]
				]]);
			}

			$update = $user->update([
				'phone_code_error' => NULL,
				'phone_code' => NULL,
				'phone_code_at' => NULL,
			]);

			if ($update) {
				return response()->json(['success' => true]);
			}
		} else {
			return response()->json(['error' => ['User not found']]);
		}

		return response()->json(['errors' => [
			'other' => [
				__("Unknown error")
			]
		]]);
	}

	public function send_sms(Request $request)
	{
		$lang = $request->get('lang') ? $request->get('lang') : 'en';
		app()->setLocale($lang);

		$validator = Validator::make($request->all(), [
			'user_id' => ["required"],
		]);

		if ($validator->fails()) {
			return response()->json(['error' => $validator->errors()->all()]);
		}

		$user = User::find($request->get('user_id'));
		if ($user) {
			$code = $user->generate_code();

			if ($code) {
				return response()->json(['success' => true]);
			} else {
				return response()->json(['errors' => [
					'other' => [
						__("You can request a second code in a minute")
					]
				]]);
			}
		} else {
			return response()->json(['error' => ['User not found']]);
		}

		return response()->json(['errors' => [
			'other' => [
				__("Unknown error")
			]
		]]);
	}

	public function register(Request $request)
	{
		$lang = $request->get('lang') ? $request->get('lang') : 'en';
		app()->setLocale($lang);

		$validator = Validator::make($request->all(), [
			'referral_code' => ["required"],
			'email' => ["required"],
		]);

		if ($validator->fails()) {
			return response()->json(['error' => $validator->errors()->all()]);
		}

		$referrer = User::where('referral_code', $request->get('referral_code'))->first();

		if (!$referrer) {
			return response()->json(['error' => ['Referrer not found']]);
		}

		$user_other = User::where('email', $request->get('email'))->count();
		if ($user_other) {
			return response()->json(['error' => ['There is already a user with this email']]);
		}

		$password = (string)random_int(10010010, 99999999);
		$first_name = $request->get('first_name') ? $request->get('first_name') : '';


		if ($referrer) {
			$referrer_id = $referrer->id;
			$referral_code = substr(md5(uniqid(mt_rand(), true)), 0, 8); // 8 знаков
			$tl_key = md5($referrer_id . $request->get('email'));

			$user = User::create([
				'first_name' => $first_name,
				'referrer_id' => $referrer_id,
				'referral_code' => $referral_code,
				'email' => $request->get('email'),
				'password' => Hash::make($password),
				'tl_key' => $tl_key
			]);

			if ($user) {
				event(new Registered($user));
				$user = User::find($user->id);

				Mail::to($user->email)->send(new Password($user, $password));
				return response()->json(['success' => true, 'user' => $user]);
			}
		}

		// if ($user) {
		// 	$user = User::find($user->id);
		// 	return response()->json(['success' => true, 'user' => $user]);
		// }

		return response()->json(['errors' => [
			'other' => [
				__("Unknown error")
			]
		]]);
	}
}
