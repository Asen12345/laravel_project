<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Account;
use App\Models\Payment;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$users = User::all();
		return view('admin.users.index', compact(['users']));
	}

	public function info(User $user)
	{
		return view('admin.users.info', compact(['user']));
	}

	public function licenses_block(Request $request)
	{
		Validator::make($request->all(), [
			'account_id' => ['required'],
		]);

		$account = Account::findOrFail($request->get('account_id'));
		$old_value = $account->blocked;
		if ($account->blocked) {
			$value = 0;
			// разблокируем
		} else {
			// блокируем
			$value = 1;
		}

		$account->blocked = $value;
		$result = $account->save();

		if ($result) {
			return response()->json(['success' => true, 'value' => $value]);
		} else {
			return response()->json(['success' => false, 'value' => $old_value]);
		}
	}

	public function licenses_detach(Request $request)
	{
		Validator::make($request->all(), [
			'account_id' => ['required'],
		]);

		$account = Account::findOrFail($request->get('account_id'));
		if ($account->number) {
			$account->number = 0;
			$account->activated = 0;
			$result = $account->save();

			if ($result) {
				return response()->json(['success' => true]);
			}
		}

		return response()->json(['success' => false]);
	}

	public function licenses_renew(Request $request)
	{
		Validator::make($request->all(), [
			'account_id' => ['required'],
		]);

		$account = Account::findOrFail($request->get('account_id'));
		// if ($account->user) {
		// $userId = $account->user->id;

		// $payment = Payment::create([
		// 	'user_id' => $userId,
		// 	'created_at' => date('Y-m-d H:i:s'),
		// 	'type' => 6,
		// 	'status' => 1,
		// 	'amount' => -50,
		// 	'fee' => 0,
		// 	'payment_system' => 0,
		// 	'payer' => '',
		// 	'payee' => '',
		// 	'batcn' => '',
		// 	'confirm_date' => date('Y-m-d H:i:s')
		// ]);

		// if ($payment) {
		// if ($account->user->curator) {
		// 	$userId = $account->user->curator->id;

		// 	// 10 процентов куратору
		// 	$payments_curator = Payment::create([
		// 		'user_id' => $userId,
		// 		'created_at' => date('Y-m-d H:i:s'),
		// 		'type' => 10,
		// 		'status' => 1,
		// 		'amount' => 5,
		// 		'fee' => 0,
		// 		'payment_system' => 0,
		// 		'payer' => '',
		// 		'payee' => '',
		// 		'batcn' => '',
		// 		'confirm_date' => date('Y-m-d H:i:s')
		// 	]);
		// }

		$account->date_expiration = date('Y-m-d H:i:s', strtotime('+1 YEAR', strtotime($account->date_expiration)));
		$result = $account->save();

		return response()->json(['success' => true]);
		// }
		// }

		// 2022-04-17 17:03:43

		// return response()->json(['success' => false]);
	}

	public function login_as(Request $request)
	{
		Validator::make($request->all(), [
			'user_id' => ['required'],
		]);

		$user = User::findOrFail($request->get('user_id'));
		$userId = $user->id;
		Auth::loginUsingId($userId, true);
		return redirect()->route('profile');
	}


	public function personal_data(Request $request, User $user)
	{
		$validator = Validator::make($request->all(), [
			'first_name' => ['required', 'string', 'max:255'],
		]);

		if ($validator->fails()) {
			return redirect()->route('admin.users.info', $user)
				->withErrors($validator)
				->withInput();
		}

		$user->update([
			'first_name' => $request->first_name,
			'last_name' => $request->last_name,
			'email' => $request->email,
			'phone' => $request->phone,
		]);

		return redirect()->route('admin.users.info', $user)->with('personal_data_success', __('Personal data has been successfully changed'));
	}

	public function change_password(Request $request, User $user)
	{
		$this->validate($request, [
			'new_password' => 'required|string|min:6|confirmed',
		]);

		$user->fill([
			'password' => Hash::make(request()->input('new_password'))
		])->save();

		return redirect()->route('admin.users.info', $user)->with('change_password_success', __('Password changed!'));
	}
}
