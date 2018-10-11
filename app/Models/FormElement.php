<?php
/*
  * This file is part of the Record of processing activities project.
  * Its original location is https://github.com/Safran/RoPA
  * 
  * SPDX-License-Identifier: GPL-3.0-only
  */






namespace App\Models;

use App\Form\Exceptions\FieldTypeDoesNotExists;
use App\Models\Traits\HasCreatorAndModificator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Spatie\Translatable\HasTranslations;

/**
 * App\Models\FormElement
 *
 * @property-read \App\Models\Answer                                                 $answer
 * @property-read \App\Models\User                                                   $author
 * @property-read \App\Models\User                                                   $editor
 * @property-read \App\Models\FormPage                                               $page
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FormElement ordered( $direction = 'asc' )
 * @mixin \Eloquent
 * @property int                                                                     $id
 * @property int                                                                     $page_id
 * @property string                                                                  $name
 * @property string                                                                  $type
 * @property array                                                                   $label
 * @property array                                                                   $tips
 * @property array                                                                   $placeholder
 * @property array                                                                   $special
 * @property int                                                                     $required
 * @property int                                                                     $cnil_required
 * @property int                                                                     $ordering
 * @property int                                                                     $created_by
 * @property int|null                                                                $modified_by
 * @property \Carbon\Carbon|null                                                     $created_at
 * @property \Carbon\Carbon|null                                                     $updated_at
 * @property string|null                                                             $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FormElement whereCnilRequired( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FormElement whereCreatedAt( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FormElement whereCreatedBy( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FormElement whereDeletedAt( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FormElement whereId( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FormElement whereLabel( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FormElement whereModifiedBy( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FormElement whereName( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FormElement whereOrdering( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FormElement wherePageId( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FormElement wherePlaceholder( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FormElement whereRequired( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FormElement whereShowIfElementId( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FormElement whereShowIfElementValue( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FormElement whereSpecial( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FormElement whereTips( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FormElement whereType( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FormElement whereUpdatedAt( $value )
 * @property int                                                                     $field_required
 * @property-read \App\Models\User|null                                              $modificator
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\FormElement onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FormElement whereFieldRequired( $value )
 * @method static \Illuminate\Database\Query\Builder|\App\Models\FormElement withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\FormElement withoutTrashed()
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Answer[]      $answers
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\FormElement[] $element_show_if
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\FormElement[] $element_shown_if
 * @property-read mixed                                                              $rules
 */
class FormElement extends Model implements Sortable
{

	use HasTranslations, SortableTrait, SoftDeletes, HasCreatorAndModificator;

	public $translatable = [ 'label', 'tips', 'placeholder' ];

	public $sortable = [
		'order_column_name'  => 'ordering',
		'sort_when_creating' => true,
	];

	protected $fillable = [
		'name',
		'page_id',
		'type',
		'field_required',
		'label',
		'tips',
		'placeholder',
		'special',
		'cnil_required',
		'created_by',
	];

	protected $casts = [
		'field_required' => 'boolean',
		'cnil_required'  => 'boolean',
	];

	protected static $types = [
		'text',
		'static',
		'model',
		'file',
		'type',
		'username',
		'company',
		'country',
		'textarea',
		'radiogroup',
		'checkboxgroup',
		'datepicker',
		'list',
	//	'range',
	];

	protected $locked = [
		'date',
		'name',
		'model',
		'type',
		'company',
		'user',
		'responsable',
		'main_country',
	];

	protected $appends = [
		'rules',
	];


	/**
	 * Says if element is lock for edition on name and can't be deleted
	 *
	 * @return bool
	 */
	public function isLocked()
	{
		return in_array($this->name, $this->locked);
	}


	/**
	 * Get Classname for special field type $type
	 *
	 * @param $type
	 *
	 * @return string
	 *
	 * @throws \Exception
	 */
	public static function type($type): string
	{
		$className = '\\App\\Form\\Fields\\' . Str::ucfirst($type) . 'Field';

		if (class_exists($className) && is_subclass_of($className, '\\App\\Form\\Fields\\Field'))
		{
			return $className;
		}
		throw new FieldTypeDoesNotExists('field ... [' . $type . '] not found');
	}


	/**
	 * Availables types of field as a collection
	 * with value translated and key as internal type string
	 *
	 * @return Collection
	 */
	public static function types(): Collection
	{
		$result = collect();

		foreach (static::$types as $type)
		{
			try
			{
				$className     = static::type($type);
				$result[$type] = __('admin/forms.types.' . $type);
			}
			catch (\Exception $e)
			{
			}
		}

		return $result;
	}


	/**
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function page()
	{
		return $this->belongsTo(FormPage::class);
	}


	/**
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function answers()
	{
		return $this->hasMany(Answer::class);
	}

	/**
	 * Get the answer for a certain statement
	 * If no statement is given, give default answer
	 *
	 * @param Statement $statement
	 *
	 * @return Answer|\Illuminate\Database\Eloquent\Builder|static
	 * @throws FieldTypeDoesNotExists
	 */
	public function answer(Statement $statement = null)
	{
		if ( ! isset($statement))
		{
			$answer                  = new Answer;
			$answer->form_element_id = $this->id;
			$default                 = $this->getDefaultValue();
			$answer->answer          = isset($default) ? serialize($default) : null;
			$answer->validated_at    = null;

			return $answer;
		}

		$key = $this->name;

		return $this->hasOne(Answer::class)->where('statement_id', $statement->id)->whereHas('element',
				function ($query) use ($key) {
					$query->where('name', $key);
				});
	}


	/**
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function element_show_if()
	{
		return $this->belongsToMany(FormElement::class, 'form_elements_rules', 'element_id', 'if_element_id', 'id',
			'id')->withPivot([ 'if_element_value' ]);
	}


	public function element_shown_if()
	{
		return $this->belongsToMany(FormElement::class, 'form_elements_rules', 'if_element_id', 'element_id', 'id',
			'id')->withPivot([ 'if_element_value' ]);
	}


	/**
	 * @return mixed
	 *
	 * @throws FieldTypeDoesNotExists
	 */
	public function makeField()
	{
		try
		{
			$className = static::type($this->type);
			$input     = new $className($this, request());
		}
		catch (\Exception $e)
		{
			throw new FieldTypeDoesNotExists($this->type . $e->getMessage());
		}

		return $input;
	}


	/**
	 * Get value usable for blade ...
	 *
	 * @param null $value
	 *
	 * @return mixed
	 * @throws FieldTypeDoesNotExists
	 */
	public function getValue($value = null)
	{
		return $this->makeField()->getValue($value);
	}


	public function getValueAsString($value = null)
	{
		return $this->makeField()->getValueAsString($value);
	}


	/**
	 * Get Default value
	 *
	 * @return mixed
	 * @throws FieldTypeDoesNotExists
	 */
	public function getDefaultValue()
	{
		return $this->makeField()->getDefaultValue();
	}


	/**
	 * Get Value as a JSON string
	 *
	 * @param null $value
	 *
	 * @return mixed
	 * @throws FieldTypeDoesNotExists
	 */
	public function getValueToJson($value = null)
	{
		return $this->makeField()->getValueToJson($value);
	}


	/**
	 * Get Special inputs fields for Element edition
	 * example : choices list for radio group and checkboxes
	 * group
	 * @return mixed
	 * @throws FieldTypeDoesNotExists
	 */
	public function getSpecial()
	{
		return $this->makeField()->getSpecial();
	}


	/**
	 * Get Special as an object
	 * Example: for radiogroup a collection representing choices
	 *
	 * @return mixed
	 * @throws FieldTypeDoesNotExists
	 */
	public function getSpecialAsObject()
	{
		return $this->makeField()->getSpecialAsObject();
	}


	/**
	 * Get values prepared to be saved for the special inputs
	 *
	 *
	 * @param Request $request
	 *
	 * @return mixed
	 * @throws FieldTypeDoesNotExists
	 */
	public function getSpecialToSave(Request $request)
	{
		return $this->makeField()->getSpecialToSave($request);
	}


	/**
	 * Get rules for this element type
	 *
	 * for example datepicker has "date" rule.
	 * All rules are laravel rules that can be used
	 * in laravel validation
	 *
	 * @return array|string
	 * @throws FieldTypeDoesNotExists
	 */
	public function getRule()
	{
		$rules = [];
		$input = $this->makeField();
		if ($this->field_required)
		{
			$rules[] = 'required';
		}
		$fieldrule = array_merge($rules, $input->getRule());
		if ( ! empty($fieldrule))
		{
			$fieldrule = implode("|", $fieldrule);
		}

		return $fieldrule;
	}


	/**
	 * Get show rules attribute
	 *
	 * @return array
	 */
	public function getRulesAttribute()
	{
		return \Cache::rememberForever('element.rules.' . $this->id, function () {
			$rules = [];
			//$this->loadMissing('element_show_if');
			foreach ($this->element_show_if as $element)
			{
				$rule          = new \stdClass;
				$rule->element = $element;

				$values = collect(json_decode($element->special, true));

				$rule->value        = new \stdClass;
				$rule->value->id    = $element->pivot->if_element_value;
				$rule->value->label = $values->filter(function ($value) use ($rule) {
					return $value['value'] == $rule->value->id;
				})->first()['label'][locale()];
				$rules[]            = $rule;
			}

			return $rules;
		});
	}


	/**
	 * Says if this element answer is shown for the given answers
	 * answer is name => value
	 *
	 * @param Collection $answers
	 *
	 * @return bool
	 */
	public function isShownByVisibilityRules(Collection $answers): bool
	{
		if (empty($this->rules))
		{
			return true;
		}

		foreach ($this->rules as $rule)
		{
			// This element is required only if rule pass validation
			if($answers->has($rule->element->name))
			{
				$answer = $answers[$rule->element->name];
				if(is_object($answer))
				{
					return $answers[$rule->element->name]->value == $rule->value->id;
				} else {
					return $answers[$rule->element->name] == $rule->value->id;
				}
			}
		}

		return false;
	}
}
