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
use League\Fractal\TransformerAbstract;

/**
 * Class AnswerTransformer
 *
 * @package App\Models\Transformers
 */
class AnswerTransformer extends TransformerAbstract
{

	/**
	 * @var array
	 */
	protected $defaultIncludes = [
		'comments',
	];


	/**
	 * @param Answer $answer
	 *
	 * @return array
	 * @throws FieldTypeDoesNotExists
	 */
	public function transform(Answer $answer)
	{
		return [
			'id'           => $answer->id,
			'element'      => $answer->element->id,
			'value'        => $answer->element->getValueToJson($answer->answer),
			'validated_at' => isset($answer->validated_at) ? $answer->validated_at : null,
			'progress'     => isset($answer->statement) ? $answer->statement->progress : null,
			'original'     => $answer->element->getValueToJson($answer->answer),
		];
	}


	/**
	 * @param Answer $answer
	 *
	 * @return \League\Fractal\Resource\Collection
	 */
	protected function includeComments(Answer $answer)
	{
		$comments = $answer->comments;

		return $this->collection($comments, new CommentTransformer);
	}
}