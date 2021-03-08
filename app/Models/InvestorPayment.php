<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvestorPayment extends Model
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
				$status = __('Investor reward'); // Вознаграждение инвестора
				break;
			case 2:
				$status = __('Withdrawal of investor funds'); // Вывод средств
				break;

			default:
				$status = $this->type;
		}

		return $status;
	}
}
