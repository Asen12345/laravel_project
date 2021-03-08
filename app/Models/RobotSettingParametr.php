<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RobotSettingParametr extends Model
{
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'id_set', 'index', 'value'
	];

	public $timestamps = false;

	protected $table = 'ea_parametrs';

	public function setting()
	{
		return $this->belongsTo('App\Models\RobotSetting', 'id_set', 'id');
	}
}
