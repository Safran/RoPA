<?php
/*
  * This file is part of the Record of processing activities project.
  * Its original location is https://github.com/Safran/RoPA
  * 
  * SPDX-License-Identifier: GPL-3.0-only
  */






namespace App\Models\Transformers;

use App\Models\Form;
use League\Fractal\TransformerAbstract;

/**
 * Class FormTransformer
 *
 * @package App\Models\Transformers
 */
class FormTransformer extends TransformerAbstract
{

	/**
	 * @var array
	 */
	protected $defaultIncludes = [
		'pages',
	];


	/**
	 * @param Form $form
	 *
	 * @return array
	 */
	public function transform(Form $form)
	{
		return [
			'id' => $form->id,
		];
	}


	/**
	 * @param Form $form
	 *
	 * @return \League\Fractal\Resource\Collection
	 */
	protected function includePages(Form $form)
	{
		$pages = $form->pages;

		return $this->collection($pages, new PageTransformer);
	}
}