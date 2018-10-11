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
 * App\Models\StatementTemplate
 *
 * @mixin \Eloquent
 * @property int $id
 * @property string $title
 * @property int $created_by
 * @property int|null $modified_by
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\StatementTemplateAnswer[] $answers
 * @property-read \App\Models\User $author
 * @property-read \App\Models\User $editor
 * @property-read \App\Models\User|null $modificator
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\StatementTemplate onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\StatementTemplate whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\StatementTemplate whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\StatementTemplate whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\StatementTemplate whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\StatementTemplate whereModifiedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\StatementTemplate whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\StatementTemplate whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\StatementTemplate withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\StatementTemplate withoutTrashed()
 */
class StatementTemplate extends Model
{
	use SoftDeletes, HasCreatorAndModificator;

	protected $fillable = [
		'title',
		'created_by',
		'modified_by',
	];

	public function answers()
	{
		return $this->hasMany(StatementTemplateAnswer::class);
	}
}
