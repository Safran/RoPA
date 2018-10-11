<?php
/*
  * This file is part of the Record of processing activities project.
  * Its original location is https://github.com/Safran/RoPA
  * 
  * SPDX-License-Identifier: GPL-3.0-only
  */






namespace App\Models\Transformers;

use App\Models\FormElement;
use League\Fractal\TransformerAbstract;

/**
 * Class RuleTransformer
 *
 * @package App\Models\Transformers
 */
class RuleTransformer extends TransformerAbstract
{

	/**
	 * @param FormElement $element
	 *
	 * @return array
	 */
	public function transform(FormElement $element)
	{
		return [
			'element' => [ 'id' => $element->id, 'name' => $element->name],
			'value'   => $element->pivot->if_element_value,
		];
	}
}