<?php
/*
  * This file is part of the Record of processing activities project.
  * Its original location is https://github.com/Safran/RoPA
  * 
  * SPDX-License-Identifier: GPL-3.0-only
  */






namespace App\Models\Transformers;

use App\Models\StatementTemplate;
use League\Fractal\TransformerAbstract;

/**
 * Class StatementTemplateTransformer
 *
 * @package App\Models\Transformers
 */
class StatementTemplateTransformer extends TransformerAbstract
{

	/**
	 * @var array
	 */
	protected $availableIncludes = [
		'answers',
	];


	/**
	 * @param StatementTemplate $statement
	 *
	 * @return array
	 */
	public function transform(StatementTemplate $statement)
	{
		return [
			'id'            => $statement->id,
			'title'         => $statement->title,
		];
	}


	/**
	 * @param StatementTemplate $statement
	 *
	 * @return \League\Fractal\Resource\Collection
	 */
	protected function includeAnswers(StatementTemplate $statement)
	{
		$answers = $statement->answers;

		return $this->collection($answers, new StatementTemplateAnswerTransformer);
	}
}