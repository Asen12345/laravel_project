<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Account;
use App\Models\Payment;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Mail;
use App\Mail\Password;

use Spatie\MediaLibrary\Models\Media;

class LicensesController extends Controller
{
	public function index()
	{

		// $accounts = auth()->user()->accounts;
		$userId = auth()->user()->id;
		$accounts_one = Account::where('user_id', 0)->where('manager_id', $userId)->where('activated', 0)->get();

		$accounts_two = Account::where('user_id', $userId)->get();
		$accounts_three = Account::where('manager_id', $userId)->whereNotIn('user_id', [$userId, 0])->get();


		$accounts = $accounts_two->merge($accounts_three);
		$accounts->all();

		$license_price_setting = Setting::where('key', 'license_price')->pluck('value')->first();
		$license_price = $license_price_setting ? $license_price_setting : 0;

		if (auth()->user()->binar) {
			switch (auth()->user()->binar->type) {
				case 1:
					$partner_proc = 30;
					break;
				case 2:
					$partner_proc = 40;
					break;
				case 3:
					$partner_proc = 50;
					break;
			}
		} else {
			$partner_proc = 10;
		}

		$for_partner = $license_price * $partner_proc / 100;
		$for_pay = $license_price - $for_partner;

		return view('licenses', compact(['accounts_one', 'accounts_two', 'accounts_three', 'license_price', 'for_partner', 'for_pay', 'accounts']));
	}



	public function to_activate(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'id' => ["required", "exists:accounts,id"],
			'person' => ["required"],
		]);

		if ($validator->fails()) {
			return response()->json(['error' => $validator->errors()]);
		}

		if ($request->get('person') == 'email') {
			$validator = Validator::make($request->all(), [
				'email' => ["required", "email"],
			]);

			if ($validator->fails()) {
				return response()->json(['error' => $validator->errors()]);
			}
		}

		$account = Account::find($request->get('id'));
		$account_user_id = 0;

		if ($request->get('person') == 'my') {
			$account_user_id = $account->manager_id;
		}

		if ($request->get('person') == 'email') {
			$person = User::where('email', $request->get('email'))->first();
			if ($person) {
				$account_user_id = $person->id;
			} else {
				$referrer = auth()->user();
				$referrer_id = $referrer->id;
				$referral_code = substr(md5(uniqid(mt_rand(), true)), 0, 8); // 8 знаков
				$tl_key = md5($referrer_id . $request->get('email'));
				$password = (string)random_int(10010010, 99999999);

				$user = User::create([
					'first_name' => '',
					'referrer_id' => $referrer_id,
					'referral_code' => $referral_code,
					'email' => $request->get('email'),
					'password' => Hash::make($password),
					'tl_key' => $tl_key
				]);

				if ($user) {
					$account_user_id = $user->id;

					event(new Registered($user));
					$user = User::find($user->id);

					Mail::to($user->email)->send(new Password($user, $password));
				}
			}
		}

		$update = $account->update(['user_id' => $account_user_id]);
		if (!$update) {
			return response()->json(['error' => [
				'other' => [
					__("The license has not been activated")
				]
			]]);
		}

		return response()->json(['success' => true]);
	}


	public function to_appoint(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'id' => ["required", "exists:accounts,id"],
			'number' => ["required", "numeric"],
		]);

		if ($validator->fails()) {
			return response()->json(['error' => $validator->errors()->all()]);
		}

		$id = $request->id;
		$update = Account::whereId($id)->update(['number' => $request->number]);
		if (!$update) {
			return response()->json(['error' => __('The account number has not been saved. try again')]);
		}

		return response()->json(['success' => true]);
	}

	public function buy(Request $request)
	{
		$userId = auth()->user()->id;
		$accounts_one = Account::whereIn('user_id', [0, NULL])->get();
		$accounts_two = Account::where('user_id', $userId)->where('manager_id', $userId)->get();
		$accounts_three = Account::where('user_id', $userId)->get();

		$license_price_setting = Setting::where('key', 'license_price')->pluck('value')->first();
		$license_price = $license_price_setting ? $license_price_setting : 0;

		if (auth()->user()->binar) {
			switch (auth()->user()->binar->type) {
				case 1:
					$partner_proc = 30;
					break;
				case 2:
					$partner_proc = 40;
					break;
				case 3:
					$partner_proc = 50;
					break;
			}
		} else {
			$partner_proc = 10;
		}

		$for_partner = $license_price * $partner_proc / 100;
		$for_pay = $license_price - $for_partner;


		if (auth()->user()->balance() < $for_pay) {
			return response()->json(['errors' => [
				'other' => [
					__("Insufficient funds on the user's balance")
				]
			]]);
		}

		$amount = $license_price * (-1);
		$payment = Payment::create([
			'user_id' => $userId,
			'created_at' => date('Y-m-d H:i:s'),
			'type' => 4,
			'status' => 1,
			'amount' => $amount,
			'fee' => 0,
			'payment_system' => 0,
			'payer' => '',
			'payee' => '',
			'batcn' => '',
			'confirm_date' => date('Y-m-d H:i:s')
		]);

		if ($payment) {
			$payment2 = Payment::create([
				'user_id' => $userId,
				'created_at' => date('Y-m-d H:i:s'),
				'type' => 7,
				'status' => 1,
				'amount' => $for_partner,
				'fee' => 0,
				'payment_system' => 0,
				'payer' => '',
				'payee' => '',
				'batcn' => '',
				'confirm_date' => date('Y-m-d H:i:s')
			]);

			if (auth()->user()->curator) {
				if (auth()->user()->curator->binar) {
					$proc_top_partner = Setting::where('key', 'finance_buy_top_partner')->pluck('value')->first();
					$for_top_partner = $license_price * $proc_top_partner / 100;
					$curatorId = auth()->user()->curator->id;
					$payment3 = Payment::create([
						'user_id' => $curatorId,
						'created_at' => date('Y-m-d H:i:s'),
						'type' => 7,
						'status' => 1,
						'amount' => $for_top_partner,
						'fee' => 0,
						'payment_system' => 0,
						'payer' => '',
						'payee' => '',
						'batcn' => '',
						'confirm_date' => date('Y-m-d H:i:s')
					]);
				}
			}

			$active_kod = substr((substr(time(), -6) * $userId * 245013545), -10);
			$active_kod = (int) $active_kod;
			$account = Account::create([
				'user_id' => 0,
				'project_id' => 0,
				'manager_id' => $userId,
				'active_kod' => $active_kod,
				'date' => date('Y-m-d H:i:s'),
				'date_expiration' => date('Y-m-d H:i:s', strtotime("+1 year")),
				'date_activation' => NULL,
				'date_online' => NULL,
				'number' => NULL,
				'start_balance' => NULL,
				'balance' => NULL,
				'equity' => NULL,
				'currency' => NULL,
				'max_drawdown' => NULL,
				'leverage' => NULL,
				'real' => NULL,
				'company' => NULL,
				'name' => NULL,
				'server' => NULL,
				'trade_expert' => NULL,
				'ver' => NULL,
				'blocked' => NULL,
				'activated' => 0,
			]);

			if ($account) {
				return response()->json(['success' => true]);
			}
		}

		return response()->json(['errors' => [
			'other' => [
				__("Sorry, an unknown error has occurred. Repeat the operation")
			]
		]]);
	}
}
