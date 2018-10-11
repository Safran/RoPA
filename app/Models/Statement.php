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

/**
 * App\Models\Statement
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Answer[] $answers
 * @property-read \App\Models\Form                                              $form
 * @property-read mixed                                                         $completed_answers
 * @property-read mixed                                                         $questions_number
 * @property-read mixed                                                         $validated_answers
 * @property-read \App\Models\User                                              $owner
 * @property-read \App\Models\User                                              $supervisor
 * @mixin \Eloquent
 * @property int                                                                $id
 * @property int                                                                $form_id
 * @property int|null                                                           $supervisor_id
 * @property int                                                                $owner_id
 * @property int                                                                $validated
 * @property int                                                                $archived
 * @property \Carbon\Carbon|null                                                $created_at
 * @property \Carbon\Carbon|null                                                $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Statement whereArchived( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Statement whereCreatedAt( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Statement whereFormId( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Statement whereId( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Statement whereOwnerId( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Statement whereSupervisorId( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Statement whereUpdatedAt( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Statement whereValidated( $value )
 * @property string|null                                                        $deleted_at
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Statement onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Statement whereDeletedAt( $value )
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Statement withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Statement withoutTrashed()
 * @property int                                                                $created_by
 * @property int|null                                                           $modified_by
 * @property-read \App\Models\User                                              $author
 * @property-read \App\Models\User                                              $editor
 * @property-read mixed                                                         $cnil_elements
 * @property-read mixed                                                         $progress
 * @property-read \App\Models\User|null                                         $modificator
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Statement whereCreatedBy( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Statement whereModifiedBy( $value )
 */
class Statement extends Model
{

	use SoftDeletes, HasCreatorAndModificator;

	protected $fillable = [
		'form_id',
		'owner_id',
		'created_by',
		'modified_by',
		'supervisor_id',
	];

	protected $casts = [
		'validated' => 'boolean',
		'archived'  => 'boolean',
	];

	static $colors = [
		'pending'    => [
			'#B23562',
			'#9F3A67',
			'#8A3F6C',
			'#794371',
		],
		'inprogress' => [
			'#4C87C6',
			'#3D73AE',
			'#1D4D81',
			'#295C93'
		]
	];

	protected $answers = null;

	protected $hidden = [
		'disclaimer',
		'deleted_at',
		'form_id',
		'supervisor_id',
		'owner_id',
		'created_by',
	];


	public function form()
	{
		return $this->belongsTo(Form::class);
	}


	public function owner()
	{
		return $this->belongsTo(User::class, 'owner_id');
	}


	public function supervisor()
	{
		return $this->belongsTo(User::class, 'supervisor_id');
	}


	public function answers()
	{
		return $this->hasMany(Answer::class);
	}


	/**
	 * Get and cache a collection of element => answer
	 * correctly formated for this statement
	 *
	 * @return mixed
	 */
	public function answersForQuestions(): Collection
	{
		$id     = $this->id;
		$result = \Cache::remember('statements-answers-' . $this->id, 10, function () use ($id) {
			$query = static::query();
			$query->select([
				'form_elements.id AS element_id',
				'form_elements.page_id',
				'form_elements.special',
				'form_elements.name',
				'form_elements.type',
				'answers.answer',
				'answers.validated_at',
				'statements.*',
				'form_elements_rules.if_element_value',
				'element_rules.id as element_rule_id',
				'element_rules.type as rule_type',
				'element_rules.name as element_rule_name',
				'rule_answer.answer as rule_answer',
				'element_rules.special AS rule_special',
			]);
			$query->join('forms', 'statements.form_id', '=', 'forms.id');
			$query->join('form_pages', 'forms.id', '=', 'form_pages.form_id');
			$query->join('form_elements', 'form_pages.id', '=', 'form_elements.page_id');
			$query->leftJoin('answers', function ($query) {
				$query->on([
					[ 'answers.form_element_id', '=', 'form_elements.id' ],
					[ 'answers.statement_id', '=', 'statements.id' ],
				]);
			});
			$query->leftJoin('form_elements_rules', 'form_elements.id', '=', 'form_elements_rules.element_id');
			$query->leftJoin('form_elements as element_rules', 'form_elements_rules.if_element_id', '=',
				'element_rules.id');
			$query->leftJoin('answers as rule_answer', function ($query) {
				$query->on([
					[ 'rule_answer.form_element_id', '=', 'element_rules.id' ],
					[ 'rule_answer.statement_id', '=', 'statements.id' ],
				]);
			});

			$query->where([
				[ 'statements.id', '=', $id ],
				[ 'form_elements.type', '<>', 'model' ],
				[ 'form_elements.type', '<>', 'static' ]
			]);
			$query->whereNull('form_pages.deleted_at');
			$query->whereNull('form_elements.deleted_at');
			$query->whereNull('element_rules.deleted_at');

			$result   = collect();
			$elements = $query->get();

			foreach ($elements as $element)
			{
				try
				{
					$className = FormElement::type($element->type);
					$input     = new $className(FormElement::make([
						'id'      => $element->element_id,
						'name'    => $element->name,
						'page_id' => $element->page_id,
						'special' => $element->special
					]), request());

					if ( ! $result->has($element->name))
					{
						$result[$element->name]        = new \stdClass();
						$result[$element->name]->shown = true;
					}
					$result[$element->name]->name      = $element->name;
					$result[$element->name]->value     = isset($element->answer) ? $input->getValue($element->answer) : null;
					$result[$element->name]->string    = ( isset($element->answer) && $result[$element->name]->value ) ? $input->getValueAsString($element->answer) : null;
					$result[$element->name]->validated = isset($element->validated_at);
					$result[$element->name]->page_id   = $element->page_id;

					//if($result[$element->name]->name === 'name')
					//echo "<h3> " . $this->id . " {". json_encode($element) . "} [" . json_encode($result[$element->name]->value) . "]</h3>";
					// Rules
					//$values = collect(json_decode($element->rule_special, true));

					if (isset($element->element_rule_id))
					{

						$className = FormElement::type($element->rule_type);
						$ruleinput = new $className(FormElement::make([
							'name'    => $element->rule_name,
							'id'      => $element->element_rule_id,
							'special' => $element->rule_special,
						]), request());

						$rule_value = isset($element->rule_answer) ? $ruleinput->getValue($element->rule_answer) : null;
						if (isset($rule_value))
						{
							/**
							 * if($element->name === 'mesures_correc_prec')
							 * {
							 * Log::debug("element [$element->name] rule  " . json_encode($element->if_element_value) . " // " . json_encode($rule_value));
							 * Log::debug(json_encode($element));
							 * }
							 */
							if (is_array($rule_value))
							{
								$vs = collect();
								foreach ($rule_value as $v)
								{
									if (is_object($v))
									{
										$vs[] = $v->value;
									} else {
										$vs[] = $v;
									}
								}
								$result[$element->name]->shown = $vs->contains($element->if_element_value);
							}
							else
							{
								if (is_object($rule_value))
								{
									$result[$element->name]->shown = ( $element->if_element_value === $rule_value->value );
								}
								else
								{
									$result[$element->name]->shown = ( $element->if_element_value === $rule_value );
								}
							}
						}
						else
						{
							$result[$element->name]->shown = false; // Considering no answer can not show hidden element
						}
					}
				}
				catch (\Exception $e)
				{
					dd($e);
				}
			}

			$result = $result->filter(function ($value) {
				return $value->shown;
			});
			return $result;
		});

		//dd($result->groupBy('page_id'));

		return $result;
	}


	/**
	 *
	 * @return mixed
	 */
	public function questionsCount(): int
	{
		return $this->form->pages->sum(function ($page) {
			return $page->elements->count();
		});
	}


	/**
	 *
	 * @return mixed
	 */
	public function answeredCount(): int
	{
		return $this->form->pages->sum(function ($page) {
			return $page->elements()->has('answer')->count();
		});
	}


	/**
	 *
	 * @return mixed
	 */
	public function validatedAnswersCount(): int
	{
		return $this->form->pages->sum(function ($page) {
			return $page->elements()->whereHas('answer', function ($query) {
				$query->whereNotNull('validated_at');
			})->count();
		});
	}


	/**
	 * Statement has answer for this $key ?
	 *
	 * @param $key
	 *
	 * @return bool
	 */
	public function has($key)
	{
		if ( ! isset($this->answers))
		{
			$this->answers = $this->answersForQuestions();
		}

		return $this->answers->has($key) && ( $this->get($key) !== null );
	}


	/**
	 * Shortcode to get answer for a given key
	 *
	 * @param $key
	 *
	 * @return mixed
	 */
	public function get($key)
	{
		if ( ! isset($this->answers))
		{
			$this->answers = $this->answersForQuestions();
		}

		if ($this->answers->has($key))
		{
			return $this->answers[$key]->value;
		}

		return null;
	}


	/**
	 *
	 * @param $key
	 *
	 * @return null
	 */
	public function getAsString($key): string
	{
		if ( ! isset($this->answers))
		{
			$this->answers = $this->answersForQuestions();
		}

		if ($this->answers->has($key))
		{
			return $this->answers[$key]->string ?? '';
		}

		return '';
	}


	/**
	 *
	 *
	 * @return Collection
	 * @throws \App\Form\Exceptions\FieldTypeDoesNotExists
	 */
	public function getAnswers(): Collection
	{
		$result  = collect();
		$answers = $this->answersForQuestions();
		foreach ($answers as $answer)
		{
			if (isset($answer->value))
			{
				$result[$answer->name] = $answer->value;
			}
		}

		return $result;
	}


	/**
	 * Get progress has global and per page
	 *
	 * @return mixed
	 */
	public function getProgressAttribute(): array
	{
		if ( ! \Cache::has('statement-' . $this->id . '-progress'))
		{
			$result = [
				'globalquestions' => 0,
				'globalanswers'   => 0,
				'global'          => 0,
			];

			if ( ! isset($this->answers))
			{
				$this->answers = $this->answersForQuestions();
			}

			$shownquestions = $this->answers;
			$statement      = $this;
			$this->form->pages->each(function ($page) use (&$result, $statement, $shownquestions) {
				$result[$page->id] = 0;
				$questions         = $shownquestions->filter(function ($element) use ($page) {
					return ( $page->id === $element->page_id );
				});
				if ($questions->isEmpty())
				{
					$result[$page->id] = 100;
				}
				else
				{
					$answers                   = $questions->filter(function ($element) {
						return $element->validated;
					});
					$result[$page->id]         = 100 * $answers->count() / $questions->count();
					$result['globalquestions'] += $questions->count();
					$result['globalanswers']   += $answers->count();
				}
			});
			$result['global'] = ( array_key_exists('globalquestions',
					$result) && $result['globalquestions'] > 0 ) ? ( 100 * $result['globalanswers'] / $result['globalquestions'] ) : 100;

			\Cache::put('statement-' . $this->id . '-progress', $result, 5);
		}

		return \Cache::get('statement-' . $this->id . '-progress');
	}


	/**
	 *
	 * get all element that cnil wants
	 * Usefull to get first page of the statement
	 *
	 * @return mixed
	 */
	public function getCnilElementsAttribute()
	{
		return $this->elements->filter(function ($element) {
			return $element->cnil_required;
		});
	}


	/**
	 * Get color for type and key
	 *
	 *
	 * @param $type
	 * @param $key
	 *
	 * @return string
	 */
	public static function color($type, $key)
	{
		if (array_key_exists($type, self::$colors))
		{
			return self::$colors[$type][$key % 4];
		}

		return '#ffffff';
	}
}

