<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BinarDirection extends Model
{
	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'binar_directions';

	protected $fillable = [
		'user_id', 'ceil', 'created_at', 'executed'
	];

	public $timestamps = false;

	public function user()
	{
		return $this->belongsTo('App\Models\User', 'user_id');
	}

	public function binar()
	{
		return $this->belongsTo('App\Models\Binar', 'ceil');
	}
}
