<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Эти два из Media Library
use Spatie\MediaLibrary\Models\Media;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\Image\Manipulations;

class Promo extends Model implements HasMedia
{
	use HasMediaTrait;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'title', 'lang', 'public'
	];

	public $timestamps = false;

	protected $table = 'promo';
}
