<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Binar extends Model
{
	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'binar';

	public function left()
	{
		return $this->belongsTo('App\Models\Binar', 'left_id');
	}

	public function right()
	{
		return $this->belongsTo('App\Models\Binar', 'right_id');
	}

	public function user()
	{
		return $this->belongsTo('App\Models\User', 'user_id');
	}

	public function redirects()
	{
		return $this->hasMany('App\Models\BinarDirection', 'ceil');
	}

	public function redirect()
	{
		// binar_directions где executed = 0
		$rd = null;
		if (!empty($this->redirects)) {
			foreach ($this->redirects as $redirect) {
				if ($redirect->user_id == auth()->user()->id and $redirect->executed == 0) {
					$rd = $redirect;
					break;
				}
			}
		}

		return $rd;
	}

	public function left_user()
	{
		$user = null;
		if ($this->left) {
			if ($this->left->user) {
				$user = $this->left->user;
			}
		}
		return $user;
	}

	public function right_user()
	{
		$user = null;
		if ($this->right) {
			if ($this->right->user) {
				$user = $this->right->user;
			}
		}
		return $user;
	}
}
