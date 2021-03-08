<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */

	protected $fillable = [
		'user_id', 'project_id', 'manager_id', 'active_kod', 'date', 'date_expiration', 'date_activation', 'date_online',
		'trade_expert', 'number', 'start_balance', 'balance', 'equity', 'currency', 'max_drawdown', 'leverage', 'real', 'company', 'name', 'server',
		'ver', 'blocked', 'activated'
	];

	public $timestamps = false;

	public function project()
	{
		return $this->hasOne('App\Models\Project', 'id', 'project_id');
	}

	public function user()
	{
		return $this->belongsTo('App\Models\User');
	}
}
