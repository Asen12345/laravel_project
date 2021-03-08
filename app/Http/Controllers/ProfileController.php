<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Promo;
use Illuminate\Support\Facades\Hash;

use Spatie\MediaLibrary\Models\Media;

class ProfileController extends Controller
{
	

	public function get_code()
	{
		$generate_code = auth()->user()->generate_code();
		if ($generate_code) {
			return response()->json(['success' => true]);
		} else {
			return response()->json(['errors' => [
				'code' => [
					__("You can request a code in a minute")
				]
			]]);
		}
	}

	public function promo()
	{
		$user = auth()->user();
		$promo = Promo::where('public', 1)->where('lang', app()->getLocale())->orderBy('id', 'DESC')->get();
		return view('promo', compact(['promo'], ['user']));
	}

	public function mask($str, $first, $last) {
		$len = strlen($str);
		$toShow = $first + $last;
		return substr($str, 0, $len <= $toShow ? 0 : $first).str_repeat("*", $len - ($len <= $toShow ? 0 : $toShow)).substr($str, $len - $last, $len <= $toShow ? 0 : $last);
	}
	
	public function mask_email($email) {
		$mail_parts = explode("@", $email);
		$domain_parts = explode('.', $mail_parts[1]);
	
		$mail_parts[0] = $this->mask($mail_parts[0], 2, 1); // show first 2 letters and last 1 letter
		$mail_parts[1] = implode('.', $domain_parts);
	
		return implode("@", $mail_parts);
	}

	public function partners()
	{
		$partners = auth()->user()->referrals;
		return view('partners', ['partners' => $partners]);
	}


	public function curator()
	{
		$curator = auth()->user()->curator;
		return view('curator', ['curator' => $curator]);
	}


	public function check_sms_code_new_phone(Request $request)
	{
		$user = auth()->user();

		$code = $user->phone_code;
		$validator = Validator::make($request->all(), [
			'phone_code' => ["required", "in:$code"],
		], [
			'phone_code.required' => 'Введите код из СМС',
			'phone_code.in' => 'Неверный код активации',
		]);

		if ($validator->fails()) {
			return response()->json(['error' => $validator->errors()->all()]);
		}

		$result = User::whereId($user->id)->update(['phone' => $user->phone_check, 'phone_code' => NULL, 'phone_check' => NULL]);

		if ($result) {
			return response()->json(['success' => true, 'phone' => $user->phone_check]);
		} else {
			return response()->json(['success' => false]);
		}
	}

	public function send_sms_code_new_phone(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'phone' => ['required', 'unique:users,phone'], //   'phone:AUTO',  'digits:11', 
		]);

		if ($validator->fails()) {
			return response()->json(['error' => $validator->errors()->all()]);
		}


		$phone = preg_replace("/[^0-9]/", '', $request->get('phone'));

		if (User::where('phone', $phone)->count() > 0) {
			return response()->json(['error' => [
				[
					__("The phone number is already in use by another user")
				]
			]]);
		}


		$code = (string)random_int(10000, 99999);
		$message = __('Confirmation code') . ": " . $code;
		$send_sms = file_get_contents("https://smsc.ru/sys/send.php?login=dj_ermoloff&psw=120731&phones=" . urlencode($phone) . "&mes=" . urlencode($message) . "&sender=MagnumSK");

		$userId = auth()->user()->id;
		$user  = User::whereId($userId)->update(['phone_check' => $phone, 'phone_code' => $code]);

		return response()->json(['success' => true]);
	}





	/**
	 * Show the application dashboard.
	 *
	 * @return \Illuminate\Contracts\Support\Renderable
	 */
	public function index()
	{
		return view('profile');
	}

	public function personal_data(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'first_name' => ['required', 'string', 'max:255'],
		]);

		if ($validator->fails()) {
			return redirect('profile')
				->withErrors($validator)
				->withInput();
		}

		User::whereId(auth()->user()->id)->update([
			'first_name' => $request->first_name,
			'last_name' => $request->last_name,
			'telegram' => $request->telegram,
			'whatsapp' => $request->whatsapp,
			'viber' => $request->viber,
			'vk' => $request->vk,
			'fb' => $request->fb,
			'instagram' => $request->instagram,
		]);

		return redirect('profile')->with('personal_data_success', __('Personal data has been successfully changed'));
	}




	public function change_password(Request $request)
	{
		$this->validate($request, [
			'current_password' => 'required|current_password',
			'new_password' => 'required|string|min:6|confirmed',
		]);

		request()->user()->fill([
			'password' => Hash::make(request()->input('new_password'))
		])->save();

		return redirect('profile')->with('change_password_success', __('Password changed!'));

		// request()->session()->flash('success', 'Password changed!');
		// return redirect()->route('password.change');
	}


	public function change_avatar(Request $request)
	{
		$user = auth()->user();

		if ($request->hasFile('avatar') && $request->file('avatar')->isValid()) {

			$old_avatar = $user->getMedia('avatars')->first(); // ->getUrl('thumb')
			// print_r($old_avatar->id);
			// exit();

			// if ($old_avatar) {
			// 	$media = Media::find($old_avatar->id)->delete();
			// 	$user->deleteMedia($old_avatar->id);
			// }

			$result = $user->addMediaFromRequest('avatar')->toMediaCollection('avatars');

			if ($result && $old_avatar) {
				$media = Media::find($old_avatar->id)->delete();
				$user->deleteMedia($old_avatar->id);
			}

			return redirect('profile')->with('change_avatar_success', __('Avatar has been successfully changed'));
		}

		return redirect('profile');
	}
}
