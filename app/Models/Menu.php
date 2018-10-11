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
 * App\Models\Menu
 *
 * @property-read \App\Models\User $author
 * @property-read \App\Models\User $editor
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\MenuItem[] $items
 * @mixin \Eloquent
 * @property int $id
 * @property string $slug
 * @property array $title
 * @property int $created_by
 * @property int|null $modified_by
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Menu whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Menu whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Menu whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Menu whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Menu whereModifiedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Menu whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Menu whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Menu whereUpdatedAt($value)
 * @property-read \App\Models\User|null $modificator
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Menu onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Menu withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Menu withoutTrashed()
 */
class Menu extends Model
{
	use HasTranslations, SoftDeletes, HasCreatorAndModificator;

	public $translatable = [ 'title' ];

	protected $fillable = [
		'created_by',
		'modified_by',
		'slug',
		'title',
	];

	public function items()
	{
		return $this->hasMany(MenuItem::class, 'menu_id');
	}
}
