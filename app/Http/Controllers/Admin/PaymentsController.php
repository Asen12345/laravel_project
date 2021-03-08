<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Setting;
use App\Models\Payment;
use App\Models\InvestorPayment;
use App\Models\User;

class PaymentsController extends Controller
{

	// public function remittance_modal()
	// {
	// 	return view('modals.remittance');
	// }

	// public function withdraw_modal()
	// {
	// 	$finance_fee = Setting::where('key', 'finance_fee')->pluck('value')->first();
	// 	return view('modals.withdraw', compact(['finance_fee']));
	// }


	public function index()
	{
		$user_payments = Payment::orderby('created_at', 'desc')->get();
		$investor_payments = InvestorPayment::orderby('created_at', 'desc')->get();

		$payments = [];
		if (!empty($user_payments))
			foreach ($user_payments as $payment) {
				$payment->table = 'payments';
				$payments[] = $payment;
			}

		if (!empty($investor_payments))
			foreach ($investor_payments as $payment) {
				$payment->table = 'investor_payments';
				$payments[] = $payment;
			}

		return view('admin.payments.index', compact(['payments']));
	}

	public function execute(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'payment_id' => ['required'],
			// 'batcn' => ['required']
		]);

		if ($validator->fails()) {
			return response()->json(['error' => $validator->errors()]);
		}
        if($request->get('investor')){
		$payment = InvestorPayment::findOrFail($request->get('payment_id'));
		}
		else{
		$payment = Payment::findOrFail($request->get('payment_id'));
		}		
		$old_value = $payment->batcn;
		if ($payment->status == 1) {
			$value = 0;
			$status = 0;
			// разблокируем
		} else {
			// блокируем

			$validator = Validator::make($request->all(), [
				'batcn' => ['required']
			]);

			if ($validator->fails()) {
				return response()->json(['error' => $validator->errors()]);
			}

			$status = 1;
			$value = $request->get('batcn');
		}

		$payment->batcn = $value;
		$payment->status = $status;
		$result = $payment->save();

		if ($result) {
			return response()->json(['success' => true, 'value' => $value]);
		} else {
			return response()->json(['success' => false, 'value' => $old_value]);
		}
	}

	// public function withdraw(Request $request)
	// {
	// 	$validator = Validator::make($request->all(), [
	// 		'amount' => ['required', 'integer'],
	// 		'wallet' => ['required'],
	// 	]);

	// 	if ($validator->fails()) {
	// 		return response()->json(['errors' => $validator->errors()]);
	// 	}

	// 	$userId = auth()->user()->id;
	// 	$req = Payment::where('user_id', $userId)
	// 		->where('type', 2)
	// 		->where('status', 0)
	// 		->count();

	// 	if ($req) {
	// 		return response()->json(['errors' => [
	// 			'other' => [
	// 				__("Wait, please! You already have pending withdrawal requests")
	// 			]
	// 		]]);
	// 	}

	// 	if (auth()->user()->balance() < $request->get('amount')) {
	// 		return response()->json(['errors' => [
	// 			'other' => [
	// 				__("Insufficient funds on the user's balance")
	// 			]
	// 		]]);
	// 	}

	// 	if (empty(auth()->user()->phone)) {
	// 		return response()->json(['errors' => [
	// 			'other' => [
	// 				__("Confirm your phone number please")
	// 			]
	// 		]]);
	// 	}

	// 	$code = auth()->user()->generate_code();

	// 	if ($code) {
	// 		$request->session()->put('code', $code);
	// 		$request->session()->put('amount', $request->get('amount'));
	// 		$request->session()->put('wallet', $request->get('wallet'));

	// 		return response()->json(['success' => true]);
	// 	} else {
	// 		return response()->json(['errors' => [
	// 			'other' => [
	// 				__("You can request a second code in a minute")
	// 			]
	// 		]]);
	// 	}
	// }


	// public function withdraw_go(Request $request)
	// {

	// 	$user = auth()->user();
	// 	$userId = $user->id;

	// 	$code = $user->phone_code;
	// 	$validator = Validator::make($request->all(), [
	// 		'code' => ["required", "code_correct", "code_live", "code_count"], //  new PhoneCodeCount , new PhoneCodeCorrect, new PhoneCodeLive  
	// 	]);

	// 	if ($validator->fails()) {
	// 		return response()->json(['errors' => $validator->errors()]);
	// 	}

	// 	User::whereId($userId)->update([
	// 		'phone_code_error' => NULL,
	// 		'phone_code' => NULL,
	// 		'phone_code_at' => NULL,
	// 	]);

	// 	$finance_fee = Setting::where('key', 'finance_fee')->pluck('value')->first();
	// 	$fee = $request->session()->get('amount') * $finance_fee / 100;

	// 	$payment = Payment::create([
	// 		'user_id' => $userId,
	// 		'created_at' => date('Y-m-d H:i:s'),
	// 		'type' => 2,
	// 		'status' => 0,
	// 		'amount' => $request->session()->get('amount'),
	// 		'fee' => $fee,
	// 		'payment_system' => 0,
	// 		'payer' => '',
	// 		'payee' => '',
	// 		'batcn' => '',
	// 		'confirm_date' => NULL
	// 	]);

	// 	User::whereId($userId)->update(['purse' => $request->session()->get('wallet')]);

	// 	if ($payment) {
	// 		return response()->json(['success' => true]);
	// 	} else {
	// 		return response()->json(['errors' => [
	// 			'other' => [
	// 				__("Sorry, an unknown error has occurred. Repeat the operation")
	// 			]
	// 		]]);
	// 	}
	// }




	// public function remittance(Request $request)
	// {
	// 	$validator = Validator::make($request->all(), [
	// 		'amount' => ['required', 'integer'],
	// 		'email' => ['required', 'email'],
	// 	]);

	// 	if ($validator->fails()) {
	// 		return response()->json(['errors' => $validator->errors()]);
	// 	}

	// 	$userId = auth()->user()->id;

	// 	$user_recipient = User::where('email', $request->get('email'))
	// 		->where('id', '!=', $userId)
	// 		->where('email_verified_at', '!=', NULL)
	// 		->first();

	// 	if (!$user_recipient) {
	// 		return response()->json(['errors' => [
	// 			'other' => [
	// 				__("The recipient was not found. Check recipient email")
	// 			]
	// 		]]);
	// 	}

	// 	if (auth()->user()->balance() < $request->get('amount')) {
	// 		return response()->json(['errors' => [
	// 			'other' => [
	// 				__("Insufficient funds on the user's balance")
	// 			]
	// 		]]);
	// 	}

	// 	if (empty(auth()->user()->phone)) {
	// 		return response()->json(['errors' => [
	// 			'other' => [
	// 				__("Confirm your phone number please")
	// 			]
	// 		]]);
	// 	}

	// 	$code = auth()->user()->generate_code();

	// 	if ($code) {
	// 		$request->session()->put('code', $code);
	// 		$request->session()->put('amount', $request->get('amount'));
	// 		$request->session()->put('email', $request->get('email'));

	// 		return response()->json(['success' => true]);
	// 	} else {
	// 		return response()->json(['errors' => [
	// 			'other' => [
	// 				__("You can request a second code in a minute")
	// 			]
	// 		]]);
	// 	}
	// }


	// public function remittance_go(Request $request)
	// {

	// 	$user = auth()->user();
	// 	$userId = $user->id;

	// 	$code = $user->phone_code;
	// 	$validator = Validator::make($request->all(), [
	// 		'code' => ["required", "code_correct", "code_live", "code_count"],
	// 	]);

	// 	if ($validator->fails()) {
	// 		return response()->json(['errors' => $validator->errors()]);
	// 	}

	// 	User::whereId($userId)->update([
	// 		'phone_code_error' => NULL,
	// 		'phone_code' => NULL,
	// 		'phone_code_at' => NULL,
	// 	]);

	// 	$user_recipient = User::where('email', $request->session()->get('email'))
	// 		->where('id', '!=', $userId)
	// 		->where('email_verified_at', '!=', NULL)
	// 		->first();

	// 	if (!$user_recipient) {
	// 		return response()->json(['errors' => [
	// 			'other' => [
	// 				__("The recipient was not found. Check recipient email")
	// 			]
	// 		]]);
	// 	}

	// 	// для отправителя
	// 	$payment_withdrawal = Payment::create([
	// 		'user_id' => $userId,
	// 		'created_at' => date('Y-m-d H:i:s'),
	// 		'confirm_date' => date('Y-m-d H:i:s'),
	// 		'type' => 3,
	// 		'status' => 1,
	// 		'amount' => (-1) * $request->session()->get('amount'),
	// 		'fee' => 0,
	// 		'payment_system' => 0,
	// 		'payer' => $user->email,
	// 		'payee' => $user_recipient->email,
	// 		'batcn' => '',
	// 	]);

	// 	if ($payment_withdrawal) {
	// 		// для получателя
	// 		$payment = Payment::create([
	// 			'user_id' => $user_recipient->id,
	// 			'created_at' => date('Y-m-d H:i:s'),
	// 			'confirm_date' => date('Y-m-d H:i:s'),
	// 			'type' => 3,
	// 			'status' => 1,
	// 			'amount' => $request->session()->get('amount'),
	// 			'fee' => 0,
	// 			'payment_system' => 0,
	// 			'payer' => $user->email,
	// 			'payee' => $user_recipient->email,
	// 			'batcn' => '',
	// 		]);

	// 		if ($payment) {
	// 			return response()->json(['success' => true]);
	// 		}
	// 	}

	// 	return response()->json(['errors' => [
	// 		'other' => [
	// 			__("Sorry, an unknown error has occurred. Repeat the operation")
	// 		]
	// 	]]);
	// }
}
