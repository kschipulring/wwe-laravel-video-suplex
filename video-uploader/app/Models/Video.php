<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 05 Apr 2018 15:17:05 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Video
 * 
 * @property int $id
 * @property string $title
 * @property string $file_name
 * @property int $size
 * @property string $format
 * @property int $bitrate
 * @property string $keywords
 * @property int $uploaded_by_uid
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @package App\Models
 */
class Video extends Eloquent
{
	protected $casts = [
		'size' => 'int',
		'bitrate' => 'int',
		'uploaded_by_uid' => 'int'
	];

	protected $fillable = [
		'title',
		'file_name',
		'size',
		'format',
		'bitrate',
		'keywords',
		'uploaded_by_uid'
	];
}
