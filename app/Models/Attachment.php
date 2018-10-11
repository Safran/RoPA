<?php
/*
  * This file is part of the Record of processing activities project.
  * Its original location is https://github.com/Safran/RoPA
  * 
  * SPDX-License-Identifier: GPL-3.0-only
  */






namespace App\Models;

use App\Models\Traits\HasCreator;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Attachment
 *
 * @mixin \Eloquent
 * @property int $id
 * @property string $uuid
 * @property string $path
 * @property string $name
 * @property string $type
 * @property int $size
 * @property int|null $model_id
 * @property string|null $model_type
 * @property int $created_by
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Attachment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Attachment whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Attachment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Attachment whereModelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Attachment whereModelType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Attachment whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Attachment wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Attachment whereSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Attachment whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Attachment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Attachment whereUuid($value)
 * @property-read \App\Models\User $author
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $attachmentable
 * @property string|null $md5
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Attachment whereMd5($value)
 */
class Attachment extends Model
{
    use HasCreator;

	protected $fillable = [
		'uuid',
		'md5',
		'path',
		'name',
		'type',
		'size',
		'created_by',
	];


	/**
	 * @return \Illuminate\Database\Eloquent\Relations\MorphTo
	 */
	public function attachmentable()
	{
		return $this->morphTo('model');
	}
}
