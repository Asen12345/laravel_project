<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Setting;
use App\Models\Payment;
use App\Models\User;

class FinancesController extends Controller
{

	public function deposit_modal()
	{
		return view('modals.deposit');
	}

	public function deposit(Request $request)
	{
		$user = auth()->user();
		$userId = $user->id;

		$validator = Validator::make($request->all(), [
			'amount' => ["required"],
		]);

		if ($validator->fails()) {
			return response()->json(['errors' => $validator->errors()]);
		}

		$in_process = Payment::where('user_id', $userId)->where('type', 1)->where('status', 0)->first();
		if ($in_process) {
			$paymentId = $in_process->id;
			$payment = $in_process->update([
				'amount' => $request->get('amount')
			]);
		} else {
			$payment = Payment::create([
				'user_id' => $userId,
				'created_at' => date('Y-m-d H:i:s'),
				'type' => 1,
				'status' => 0,
				'amount' => $request->get('amount'),
				'fee' => 0,
				'payment_system' => 1,
				'payer' => '',
				'payee' => '',
				'batcn' => '',
				'confirm_date' => NULL
			]);
			$paymentId = $payment->id;
		}

		if ($payment) {
			return response()->json(['success' => true, 'url' => 'https://api.magnumsk.com/go-to-pay/' . $paymentId]);
		} else {
			return response()->json(['errors' => [
				'other' => [
					__("Sorry, an unknown error has occurred. Repeat the operation")
				]
			]]);
		}
	}










	public function remittance_modal()
	{
		return view('modals.remittance');
	}

	public function withdraw_modal()
	{
		$finance_fee = Setting::where('key', 'finance_fee')->pluck('value')->first();
		$card_finance_fee = Setting::where('key', 'card_free')->pluck('value')->first();
		return view('modals.withdraw', ['finance_fee'=>$finance_fee, 'card_finance_fee'=>$card_finance_fee]);
	}


	public function index()
	{
		$payments = auth()->user()->payments;
		return view('finances', compact(['payments']));
	}

	public function withdraw(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'amount' => ['required', 'integer'],
			'wallet' => ['required'],
		]);

		if ($validator->fails()) {
			return response()->json(['errors' => $validator->errors()]);
		}

		$userId = auth()->user()->id;
		$req = Payment::where('user_id', $userId)
			->where('type', 2)
			->where('status', 0)
			->count();

		if ($req) {
			return response()->json(['errors' => [
				'other' => [
					__("Wait, please! You already have pending withdrawal requests")
				]
			]]);
		}

		if (auth()->user()->balance() < $request->get('amount')) {
			return response()->json(['errors' => [
				'other' => [
					__("Insufficient funds on the user's balance")
				]
			]]);
		}

		if (empty(auth()->user()->phone)) {
			return response()->json(['errors' => [
				'other' => [
					__("Confirm your phone number please")
				]
			]]);
		}

		$code = auth()->user()->generate_code();

		if ($code) {
			$request->session()->put('code', $code);
			$request->session()->put('amount', $request->get('amount'));
			$request->session()->put('payment_system', $request->get('payment_system'));
			$request->session()->put('wallet', $request->get('wallet'));

			return response()->json(['success' => true]);
		} else {
			return response()->json(['errors' => [
				'other' => [
					__("You can request a second code in a minute")
				]
			]]);
		}
	}


	public function withdraw_go(Request $request)
	{

		$user = auth()->user();
		$userId = $user->id;

		$code = $user->phone_code;
		$validator = Validator::make($request->all(), [
			'code' => ["required", "code_correct", "code_live", "code_count"], //  new PhoneCodeCount , new PhoneCodeCorrect, new PhoneCodeLive  
		]);

		if ($validator->fails()) {
			return response()->json(['errors' => $validator->errors()]);
		}

		User::whereId($userId)->update([
			'phone_code_error' => NULL,
			'phone_code' => NULL,
			'phone_code_at' => NULL,
		]);
        if($request->session()->get('payment_system') == 1){
			$finance_fee = Setting::where('key', 'card_finance_fee')->pluck('value')->first();
			$fee = $request->session()->get('amount') * $finance_fee / 100;
		}
		else{
			$finance_fee = Setting::where('key', 'finance_fee')->pluck('value')->first();
			$fee = $request->session()->get('amount') * $finance_fee / 100;
		}		

		$payment = Payment::create([
			'user_id' => $userId,
			'created_at' => date('Y-m-d H:i:s'),
			'type' => 2,
			'status' => 0,
			'amount' => $request->session()->get('amount'),
			'fee' => $fee,
			'payment_system' => $request->session()->get('payment_system'),
			'payer' => $request->session()->get('wallet'),
			'payee' => '',
			'batcn' => '',
			'confirm_date' => NULL
		]);

		User::whereId($userId)->update(['purse' => $request->session()->get('wallet')]);

		if ($payment) {
			return response()->json(['success' => true]);
		} else {
			return response()->json(['errors' => [
				'other' => [
					__("Sorry, an unknown error has occurred. Repeat the operation")
				]
			]]);
		}
	}




	public function remittance(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'amount' => ['required', 'integer'],
			'email' => ['required', 'email'],
		]);

		if ($validator->fails()) {
			return response()->json(['errors' => $validator->errors()]);
		}

		$userId = auth()->user()->id;

		$user_recipient = User::where('email', $request->get('email'))
			->where('id', '!=', $userId)
			->where('email_verified_at', '!=', NULL)
			->first();

		if (!$user_recipient) {
			return response()->json(['errors' => [
				'other' => [
					__("The recipient was not found. Check recipient email")
				]
			]]);
		}

		if (auth()->user()->balance() < $request->get('amount')) {
			return response()->json(['errors' => [
				'other' => [
					__("Insufficient funds on the user's balance")
				]
			]]);
		}

		if (empty(auth()->user()->phone)) {
			return response()->json(['errors' => [
				'other' => [
					__("Confirm your phone number please")
				]
			]]);
		}

		$code = auth()->user()->generate_code();

		if ($code) {
			$request->session()->put('code', $code);
			$request->session()->put('amount', $request->get('amount'));
			$request->session()->put('email', $request->get('email'));

			return response()->json(['success' => true]);
		} else {
			return response()->json(['errors' => [
				'other' => [
					__("You can request a second code in a minute")
				]
			]]);
		}
	}


	public function remittance_go(Request $request)
	{

		$user = auth()->user();
		$userId = $user->id;

		$code = $user->phone_code;
		$validator = Validator::make($request->all(), [
			'code' => ["required", "code_correct", "code_live", "code_count"],
		]);

		if ($validator->fails()) {
			return response()->json(['errors' => $validator->errors()]);
		}

		User::whereId($userId)->update([
			'phone_code_error' => NULL,
			'phone_code' => NULL,
			'phone_code_at' => NULL,
		]);

		$user_recipient = User::where('email', $request->session()->get('email'))
			->where('id', '!=', $userId)
			->where('email_verified_at', '!=', NULL)
			->first();

		if (!$user_recipient) {
			return response()->json(['errors' => [
				'other' => [
					__("The recipient was not found. Check recipient email")
				]
			]]);
		}

		// для отправителя
		$payment_withdrawal = Payment::create([
			'user_id' => $userId,
			'created_at' => date('Y-m-d H:i:s'),
			'confirm_date' => date('Y-m-d H:i:s'),
			'type' => 3,
			'status' => 1,
			'amount' => (-1) * $request->session()->get('amount'),
			'fee' => 0,
			'payment_system' => 0,
			'payer' => $user->email,
			'payee' => $user_recipient->email,
			'batcn' => '',
		]);

		if ($payment_withdrawal) {
			// для получателя
			$payment = Payment::create([
				'user_id' => $user_recipient->id,
				'created_at' => date('Y-m-d H:i:s'),
				'confirm_date' => date('Y-m-d H:i:s'),
				'type' => 3,
				'status' => 1,
				'amount' => $request->session()->get('amount'),
				'fee' => 0,
				'payment_system' => 0,
				'payer' => $user->email,
				'payee' => $user_recipient->email,
				'batcn' => '',
			]);

			if ($payment) {
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
