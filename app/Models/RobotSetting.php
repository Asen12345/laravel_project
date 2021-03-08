<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RobotSetting extends Model
{
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'symbol', 'name', 'active', 'robot_id'
	];

	public $timestamps = false;

	protected $table = 'ea_settings';

	public function robot()
	{
		return $this->belongsTo('App\Models\Robot');
	}

	public function parametrs()
	{
		return $this->hasMany('App\Models\RobotSettingParametr', 'id_set', 'id');
	}
}
