<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use App\Notifications\VerifyEmail;
// use Carbon\Carbon;

// Эти два из Media Library
use Spatie\MediaLibrary\Models\Media;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\Image\Manipulations;


class User extends Authenticatable implements MustVerifyEmail, HasMedia
{
	use Notifiable;
	use HasMediaTrait;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'first_name', 'last_name', 'email', 'password', 'referrer_id', 'referral_code', 'telegram', 'whatsapp', 'viber', 'vk', 'fb', 'instagram', 'phone', 'phone_check', 'phone_code', 'purse', 'phone_code_error', 'phone_code_at', 'tl_key'
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array 
	 */
	protected $hidden = [
		'password', 'remember_token',
	];


	/**
	 * The attributes that should be cast to native types.
	 *
	 * @var array
	 */
	protected $casts = [
		'email_verified_at' => 'datetime',
		// 'phone_verified' => 'boolean',
		// 'phone_verify_token_expire' => 'datetime',
		// 'phone_auth' => 'boolean',
	];

	public function curator()
	{
		return $this->belongsTo('App\Models\User', 'referrer_id');
	}

	/**
	 * Send the email verification notification.
	 *
	 * @return void
	 */
	public function sendEmailVerificationNotification()
	{
		$this->notify(new VerifyEmail); // my notification
	}

	public function ref($val)
	{
		if(isset($val)){
			if($val == 'first_ref'){ 
			   return 'https://magnumsk.com/?partner='. $this->referral_code .'&lang='. app()->getLocale() .'';
			}
			if($val == 'second_ref'){
				return 'https://archie-pro.com/?partner='. $this->referral_code .'&lang='. app()->getLocale() .'';
			}
			if($val == 'thr_ref'){
				return 'https://tlgg.ru/magnumsk_f1_bot/?start='. $this->referral_code .'';
			}
			else{
				return route('referral', ['code' => $this->referral_code, 'locale' => app()->getLocale()]);
			}
		}
	
	}

	public function tg_bot()
	{
		return 'https://tlgg.ru/magnumsk_bot?start=auth-' . $this->tl_key;
	}

	// public function page()
	// {
	// 	return route('promo', ['code' => $this->referral_code]);
	// }

	public function phoneNumber()
	{
		return "+" . substr($this->phone, 0, 1) . " (" . substr($this->phone, 1, 3) . ") " . substr($this->phone, 4, 3) . " " . substr($this->phone, 7, 2) . " " . substr($this->phone, 9);
	}

	public function referrals()
	{
		return $this->hasMany('App\Models\User', 'referrer_id');
	}


	public function accounts()
	{
		return $this->hasMany('App\Models\Account', 'user_id');
	}

	public function balance()
	{
		$balance = 0;
		if (!empty($this->payments)) {
			foreach ($this->payments as $payment) {
				if ($payment->status == 1) {
					$balance += $payment->amount;
				}
			}
		}

		return $balance;
	}

	public function payments()
	{
		return $this->hasMany('App\Models\Payment', 'user_id')->orderBy('created_at', 'DESC');
	}

	public function investor_payments()
	{
		return $this->hasMany('App\Models\InvestorPayment', 'user_id')->orderBy('created_at', 'DESC');
	}

	public function investor_balance()
	{
		$balance = 0;
		if (!empty($this->investor_payments)) {
			foreach ($this->investor_payments as $payment) {
				if ($payment->status == 1) {
					$balance += $payment->amount;
				}
			}
		}

		return $balance;
	}


	public function status()
	{
		return $this->binar ? ($this->binar->activated ? '<span class="badge badge-success">' . __('Active') . '</span>' : '<span class="badge badge-warning">' . __('Not qualified') . '</span>') : '<span class="badge badge-danger">' . __('Not active') . '</span>';
	}

	public function count_partners()
	{
		$count = 0;
		$partners = $this->referrals;
		if (!empty($partners))
			foreach ($partners as $partner) {
				$count = $partner->binar ? $count + 1 : $count;
			}

		return $count;
	}

	public function binar()
	{
		return $this->hasOne('App\Models\Binar');
	}

	public function registerMediaConversions(Media $media = null): void
	{
		$this->addMediaConversion('thumb')
			->crop(Manipulations::CROP_CENTER, 60, 60)
			->width(60)
			->height(60);

		$this->addMediaConversion('thumb_middle')
			->crop(Manipulations::CROP_CENTER, 100, 100)
			->width(100)
			->height(100);

		$this->addMediaConversion('thumb_big')
			->crop(Manipulations::CROP_CENTER, 120, 120)
			->width(100)
			->height(100);
	}


	public function generate_code()
	{
		if ($this->phone_code_at and time() < $this->phone_code_at + 1 * 60) {
			return false;
		}

		$code = (string)random_int(10000, 99999);
		$message = __('Confirmation code') . ": " . $code;
		$send_sms = file_get_contents("https://smsc.ru/sys/send.php?login=dj_ermoloff&psw=120731&phones=" . urlencode($this->phone) . "&mes=" . urlencode($message) . "&sender=MagnumSK");

		$this->phone_code = $code;
		$this->phone_code_at = time();
		$this->phone_code_error = 0;
		$this->saveOrFail();

		return $code;
	}

	public function check_code($code)
	{
		if (time() > $this->phone_code_at + 10 * 60) {
			// $this->generate_code();
			return [
				'success' => false,
				'error' => 'expired_code'
			];
		}

		if ($code != $this->phone_code) {
			$this->phone_code_error = $this->phone_code_error + 1;
			$this->saveOrFail();

			return [
				'success' => false,
				'error' => 'incorrect_code'
			];
		}

		$this->phone_code = NULL;
		$this->phone_code_at = NULL;
		$this->phone_code_error = NULL;
		$this->saveOrFail();

		return [
			'success' => true
		];
	}
}
