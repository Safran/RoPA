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
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Spatie\Translatable\HasTranslations;

/**
 * App\Models\MenuItem
 *
 * @property-read \App\Models\User $author
 * @property-read \App\Models\User $editor
 * @property-read \App\Models\Menu $menu
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MenuItem ordered($direction = 'asc')
 * @mixin \Eloquent
 * @property int $id
 * @property int $menu_id
 * @property array $title
 * @property int $active
 * @property int $ordering
 * @property string $path
 * @property string|null $role
 * @property int $created_by
 * @property int|null $modified_by
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MenuItem whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MenuItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MenuItem whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MenuItem whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MenuItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MenuItem whereMenuId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MenuItem whereModifiedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MenuItem whereOrdering($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MenuItem wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MenuItem whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MenuItem whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MenuItem whereUpdatedAt($value)
 * @property-read \App\Models\User|null $modificator
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MenuItem onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MenuItem withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MenuItem withoutTrashed()
 */
class MenuItem extends Model implements Sortable
{
	use HasTranslations, SortableTrait, SoftDeletes, HasCreatorAndModificator;

	public $translatable = [ 'title' ];

	public $sortable = [
		'order_column_name'  => 'ordering',
		'sort_when_creating' => true,
	];

	protected $fillable = [
		'menu_id',
		'title',
		'active',
		'path',
		'role',
		'created_by',
		'modified_by',
	];
	protected $casts = [
		'active' => 'boolean',
	];

	public function menu()
	{
		return $this->belongsTo(Menu::class);
	}
}
