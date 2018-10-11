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
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Spatie\Translatable\HasTranslations;

/**
 * App\Models\Form
 *
 * @property-read \App\Models\User                                                 $author
 * @property-read \App\Models\User                                                 $editor
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\FormPage[]  $pages
 * @property-read \App\Models\User                                                 $publisher
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Statement[] $statements
 * @mixin \Eloquent
 * @property int                                                            $id
 * @property array                                                          $title
 * @property array                                                          $disclaimer
 * @property \Carbon\Carbon|null                                            $published_at
 * @property int                                                            $created_by
 * @property int|null                                                       $modified_by
 * @property int|null                                                       $published_by
 * @property \Carbon\Carbon|null                                            $created_at
 * @property \Carbon\Carbon|null                                            $updated_at
 * @property \Carbon\Carbon|null                                            $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Form whereCreatedAt( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Form whereCreatedBy( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Form whereDeletedAt( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Form whereDisclaimer( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Form whereId( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Form whereModifiedBy( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Form wherePublishedAt( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Form wherePublishedBy( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Form whereTitle( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Form whereUpdatedAt( $value )
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\FormElement[] $elements
 * @property-read \App\Models\User|null $modificator
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Form onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Form withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Form withoutTrashed()
 * @property-read bool $is_published
 */
class Form extends Model
{
	use HasTranslations, SoftDeletes, HasCreatorAndModificator;

	protected $dates = [
		'created_at',
		'updated_at',
		'deleted_at',
		'published_at'
	];

	public $translatable = [ 'title', 'disclaimer' ];

	protected $with = ['author'];

	public $fillable = [
		'title',
		'disclaimer',
		'modified_by'
	];

	public function pages()
	{
		return $this->hasMany(FormPage::class)->orderBy('ordering');
	}

	public function publisher()
	{
		return $this->belongsTo(User::class, 'published_by');
	}

	public function statements()
	{
		return $this->hasMany(Statement::class);
	}

	public function elements()
	{
		return $this->hasManyThrough(FormElement::class, FormPage::class, 'form_id', 'page_id');
	}

	public static function current()
	{
		return Cache::remember('current_form', 5, function()
		{
			return Form::whereNotNull('published_at')
				->orderBy('published_at', 'desc')
				->with([
					'pages',
					'pages.elements',
					'pages.elements.answers',
				])->first();
		});
	}

	/**
	 *
	 * @return bool
	 */
	public function getIsPublishedAttribute()
	{
		return isset($this->published_at);
	}


	/**
	 * @param Collection $answers
	 *
	 * @return Collection
	 * @throws \App\Form\Exceptions\FieldTypeDoesNotExists
	 */
	public function getValidationsRules(Collection $answers):Collection
	{
		$rules = collect();
		foreach ($this->elements as $element)
		{
			$rule = $element->getRule();
			if ( ! empty($rule) && $element->isShownByVisibilityRules($answers))
			{
				$rules[$element->name] = $rule;
			}
		}
		return $rules;
	}
}
