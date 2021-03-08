<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Payment extends Model
{
	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */

	public $timestamps = false;

	protected $fillable = [
		'user_id', 'status', 'created_at', 'type', 'amount', 'fee', 'payment_system', 'payer', 'payee', 'batcn', 'confirm_date'
	];

	public function user()
	{
		return $this->belongsTo('App\Models\User', 'user_id');
	}

	public function status_title()
	{

		switch ($this->type) {
			case 1:
				$status = __('Balance replenishment');
				break;
			case 2:
				if (!empty($this->payee)) {
					$user = User::where('email', $this->payee)->first();
					$wallet = $user && $user->purse ?  __('to') . ' ' . $user->purse :  __('for') . ' ' . $this->payee;
					$status = __('Withdraw funds') . ' ' . $wallet;
				} else {
					$status = __('Withdraw funds');
				}
				break;
			case 3:
				if ($this->amount < 0 && !empty($this->payee)) {
					$status = __('Internal transfer') . ' ' . __('for') . ' ' . $this->payee;
				} elseif ($this->amount > 0 && !empty($this->payer)) {
					$status = __('Internal transfer') . ' ' . __('from') . ' ' . $this->payer;
				} else {
					$status = __('Internal transfer');
				}
				break;
			case 4:
				$status = __('Buying a package of robots');
				break;
			case 5:
				$status = __('Buying a copy of a robot');
				break;
			case 6:
				$status = __('Renewing a copy of a robot');
				break;
			case 7:
				$status = __('Robot sale commission');
				break;
			case 8:
				$status = __('Robot renewal commission');
				break;
				// case 9:
				// 	$status = '';
				// 	break;
			case 10:
				$status = __('Binary reward');
				break;
			case 11:
				$status = __('Personal invitation bonus');
				break;
			case 12:
				$status = __('Activation bonus');
				break;
			case 13:
				$status = __('Double bonus');
				break;
				// case 14:
				// 	$status = '';
				// 	break;
			default:
				$status = $this->type;
		}

		return $status;
	}
}
