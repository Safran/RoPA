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
use Spatie\Translatable\HasTranslations;

/**
 * App\Models\Staticpage
 *
 * @property-read \App\Models\User $author
 * @property-read \App\Models\User $editor
 * @mixin \Eloquent
 * @property int $id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string $slug
 * @property array $title
 * @property array $body
 * @property int $created_by
 * @property int|null $modified_by
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Staticpage whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Staticpage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Staticpage whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Staticpage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Staticpage whereModifiedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Staticpage whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Staticpage whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Staticpage whereUpdatedAt($value)
 * @property string|null $deleted_at
 * @property-read \App\Models\User|null $modificator
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Staticpage onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Staticpage whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Staticpage withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Staticpage withoutTrashed()
 */
class Staticpage extends Model
{
	use HasTranslations, SoftDeletes, HasCreatorAndModificator;

	public $translatable = [ 'title', 'body' ];

	public $fillable = ['title', 'body', 'slug', 'created_by'];
}
