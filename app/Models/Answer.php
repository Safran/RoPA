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
 * App\Models\Answer
 *
 * @property-read \App\Models\FormElement $element
 * @property-read \App\Models\Statement $statement
 * @mixin \Eloquent
 * @property int $id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property int $statement_id
 * @property int $form_element_id
 * @property string $answer
 * @property string|null $validated_at
 * @property int $created_by
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Answer whereAnswer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Answer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Answer whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Answer whereFormElementId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Answer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Answer whereStatementId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Answer whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Answer whereValidatedAt($value)
 * @property-read \App\Models\User $author
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Comment[] $comments
 */
class Answer extends Model
{
	use HasCreator;

	protected $fillable = [
		'form_element_id',
		'statement_id',
		'answer',
		'created_by',
	];

	protected $dates = [
		'created_at',
		'updated_at',
		'validated_at',
	];

	public function statement()
	{
		return $this->belongsTo(Statement::class);
	}

	public function element()
	{
		return $this->belongsTo(FormElement::class, 'form_element_id');
	}

	public function comments()
	{
		return $this->hasMany(Comment::class)->orderBy('created_at');
	}

	public function attachments()
	{
		return $this->morphedByMany(Attachment::class,' attachmentable');
	}


	/**
	 * Should never been called !
	 *
	 * @return bool|null|void
	 * @throws \Exception
	 */
	function delete()
	{
		foreach($this->attachments() as $attachment)
		{
			$attachment->delete();
		}

		parent::delete();
	}
}
