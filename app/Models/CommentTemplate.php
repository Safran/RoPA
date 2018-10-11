<?php
/*
  * This file is part of the Record of processing activities project.
  * Its original location is https://github.com/Safran/RoPA
  * 
  * SPDX-License-Identifier: GPL-3.0-only
  */






namespace App\Models;

use App\Models\Traits\HasCreatorAndModificator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\CommentTemplate
 *
 * @mixin \Eloquent
 * @property int $id
 * @property string $title
 * @property int $form_element_id
 * @property string $body
 * @property int $created_by
 * @property int|null $modified_by
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \App\Models\User $author
 * @property-read \App\Models\User $editor
 * @property-read \App\Models\FormElement $element
 * @property-read \App\Models\User|null $modificator
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CommentTemplate onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CommentTemplate whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CommentTemplate whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CommentTemplate whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CommentTemplate whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CommentTemplate whereFormElementId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CommentTemplate whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CommentTemplate whereModifiedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CommentTemplate whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CommentTemplate whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CommentTemplate withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CommentTemplate withoutTrashed()
 * @property string $locale
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CommentTemplate whereLocale($value)
 */
class CommentTemplate extends Model
{
	use SoftDeletes, HasCreatorAndModificator;

	protected $fillable = [
		'body',
		'title',
		'form_element_id',
		'created_by',
	];

	public function element()
	{
		return $this->belongsTo(FormElement::class, 'form_element_id');
	}
}
