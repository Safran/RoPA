<?php
/*
  * This file is part of the Record of processing activities project.
  * Its original location is https://github.com/Safran/RoPA
  * 
  * SPDX-License-Identifier: GPL-3.0-only
  */






namespace App\Models\Transformers;

use App\Models\FormPage;
use App\Models\Statement;
use League\Fractal\TransformerAbstract;

/**
 * Class PageTransformer
 *
 * @package App\Models\Transformers
 */
class PageTransformer extends TransformerAbstract
{

	/**
	 * @var Statement
	 */
	protected $statement;


	/**
	 * PageTransformer constructor.
	 *
	 * @param Statement|null $statement
	 */
	public function __construct(Statement $statement = null)
	{
		$this->statement = $statement;
	}


	/**
	 * @var array
	 */
	protected $defaultIncludes = [
		'elements',
	];


	/**
	 * @param FormPage $page
	 *
	 * @return array
	 */
	public function transform(FormPage $page)
	{
		return [
			'id'         => $page->id,
			'title'      => $page->title,
			'disclaimer' => $page->disclaimer,
		];
	}


	/**
	 * @param FormPage $page
	 *
	 * @return \League\Fractal\Resource\Collection
	 */
	protected function includeElements(FormPage $page)
	{
		$elements = $page->elements;

		return $this->collection($elements, new ElementTransformer($this->statement));
	}
}