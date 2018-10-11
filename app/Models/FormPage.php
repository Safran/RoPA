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
 * App\Models\FormPage
 *
 * @property-read \App\Models\User $author
 * @property-read \App\Models\User $editor
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\FormElement[] $elements
 * @property-read \App\Models\Form $form
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FormPage ordered($direction = 'asc')
 * @mixin \Eloquent
 * @property int $id
 * @property int $form_id
 * @property array $title
 * @property array $disclaimer
 * @property int $ordering
 * @property int $created_by
 * @property int|null $modified_by
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FormPage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FormPage whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FormPage whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FormPage whereDisclaimer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FormPage whereFormId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FormPage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FormPage whereModifiedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FormPage whereOrdering($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FormPage whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FormPage whereUpdatedAt($value)
 * @property-read \App\Models\User|null $modificator
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\FormPage onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\FormPage withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\FormPage withoutTrashed()
 */
class FormPage extends Model implements Sortable
{
	use HasTranslations, SortableTrait, SoftDeletes, HasCreatorAndModificator;

	public $translatable = [ 'title', 'disclaimer' ];

	public $sortable = [
		'order_column_name' => 'ordering',
		'sort_when_creating' => true,
	];

	protected $fillable = [
		'title', 'disclaimer',
		'modified_by',
	];


	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function elements()
	{
		return $this->hasMany(FormElement::class, 'page_id')->orderBy('ordering');
	}


	/**
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function form()
	{
		return $this->belongsTo(Form::class);
	}
}
