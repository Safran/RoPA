<?php
/*
  * This file is part of the Record of processing activities project.
  * Its original location is https://github.com/Safran/RoPA
  * 
  * SPDX-License-Identifier: GPL-3.0-only
  */






namespace App\Models\Transformers;

use App\Models\StatementTemplateAnswer;
use League\Fractal\TransformerAbstract;

/**
 * Class StatementTemplateAnswerTransformer
 *
 * @package App\Models\Transformers
 */
class StatementTemplateAnswerTransformer extends TransformerAbstract
{

	/**
	 * @param StatementTemplateAnswer $answer
	 *
	 * @return array
	 * @throws \App\Form\Exceptions\FieldTypeDoesNotExists
	 */
	public function transform(StatementTemplateAnswer $answer)
	{
		return [
			'id'      => $answer->id,
			'element' => [
				'id'   => $answer->element->id,
				'name' => $answer->element->name
			],
			'answer'  => $answer->element->getValueToJson($answer->answer),
		];
	}
}