<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Эти два из Media Library
use Spatie\MediaLibrary\Models\Media;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\Image\Manipulations;

class Article extends Model implements HasMedia
{
	use HasMediaTrait;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'title', 'description', 'text', 'public', 'lang'
	];

	protected $table = 'news';

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
			->crop(Manipulations::CROP_CENTER, 200, 200)
			->width(200)
			->height(200);
	}
}
