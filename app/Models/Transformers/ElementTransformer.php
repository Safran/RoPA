<?php
/*
  * This file is part of the Record of processing activities project.
  * Its original location is https://github.com/Safran/RoPA
  * 
  * SPDX-License-Identifier: GPL-3.0-only
  */






namespace App\Models\Transformers;

use App\Form\Exceptions\FieldTypeDoesNotExists;
use App\Models\Answer;
use App\Models\CommentTemplate;
use App\Models\FormElement;
use App\Models\Statement;
use League\Fractal\TransformerAbstract;

/**
 * Class ElementTransformer
 *
 * @package App\Models\Transformers
 */
class ElementTransformer extends TransformerAbstract
{

	/**
	 * @var Statement
	 */
	protected $statement;


	/**
	 * ElementTransformer constructor.
	 *
	 * @param Statement|null $statement
	 */
	public function __construct(Statement $statement = null)
	{
		$this->statement = $statement;
	}


	/**
	 *
	 * @var array
	 */
	protected $defaultIncludes = [
		'rules',
	];

	/**
	 *
	 * @var array
	 */
	protected $availableIncludes = [
		'answer',
		'commenttemplates',
	];

	/**
	 * Special convertion for Vuejs component types
	 * @var array
	 */
	protected $_vueElementType = [
		'text'          => 'text',
		'static'        => 'static',
		'model'         => 'model',
		'file'          => 'file',
		'type'          => 'type',
		'username'      => 'username',
		'company'       => 'company',
		'country'       => 'country',
		'textarea'      => 'textarea',
		'radiogroup'    => 'radio',
		'checkboxgroup' => 'checkbox',
		'datepicker'    => 'datepicker',
		'list'          => 'list',
		'range'         => 'range',
	];


	/**
	 * @param $type
	 *
	 * @return mixed
	 */
	protected function vueElementType($type)
	{
		if (array_key_exists($type, $this->_vueElementType))
		{
			return $this->_vueElementType[$type];
		}

		return $type;
	}


	/**
	 * @param FormElement $element
	 *
	 * @return array
	 * @throws FieldTypeDoesNotExists
	 */
	public function transform(FormElement $element)
	{
		return [
			'id'             => $element->id,
			'name'           => $element->name,
			'type'           => $element->type, //$this->vueElementType($element->type),
			'label'          => $element->label,
			'tips'           => clean($element->tips),
			'placeholder'    => $element->placeholder,
			'field_required' => $element->field_required,
			'cnil_required'  => $element->cnil_required,
			'special'        => $element->getSpecialAsObject(),
		];
	}


	/**
	 * @param FormElement $element
	 *
	 * @return \League\Fractal\Resource\Collection
	 */
	protected function includeRules(FormElement $element)
	{
		$rules = $element->element_show_if;

		return $this->collection($rules, new RuleTransformer);
	}


	/**
	 * @param FormElement $element
	 *
	 * @return Answer
	 * @throws FieldTypeDoesNotExists
	 */
	protected function getDefaultAnswer(FormElement $element)
	{
		$answer                  = new Answer();
		$answer->form_element_id = $element->id;
		$default                 = $element->getDefaultValue();
		$answer->answer          = isset($default) ? serialize($default) : null;
		$answer->validated_at    = null;

		return $answer;
	}


	/**
	 * @param FormElement $element
	 *
	 * @return \League\Fractal\Resource\Item
	 * @throws FieldTypeDoesNotExists
	 */
	protected function includeAnswer(FormElement $element)
	{
		if ($this->statement)
		{
			$answer = $element->answer($this->statement)->first();
			if ( ! isset($answer))
			{
				$answer = $this->getDefaultAnswer($element);
			}
		}
		else
		{
			$answer = $this->getDefaultAnswer($element);
		}

		return $this->item($answer, new AnswerTransformer);
	}


	protected function includeCommenttemplates(FormElement $element)
	{
		$commenttemplates = CommentTemplate::where([
			[ 'form_element_id', '=', $element->id ],
			[ 'locale', '=', locale() ]
		])->get();
		return $this->collection($commenttemplates, new CommentTemplateTransformer);
	}
}