<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{

	/**
	 * The primary key associated with the table.
	 *
	 * @var string
	 */
	protected $primaryKey = 'key';

	public $timestamps = false;
	public $incrementing = false;

	protected $fillable = [
		'key', 'value'
	];
}
