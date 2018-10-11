<?php
/*
  * This file is part of the Record of processing activities project.
  * Its original location is https://github.com/Safran/RoPA
  * 
  * SPDX-License-Identifier: GPL-3.0-only
  */






namespace App\Models\Transformers;

use App\Models\CommentTemplate;
use League\Fractal\TransformerAbstract;

/**
 * Class CommentTemplateTransformer
 *
 * @package App\Models\Transformers
 */
class CommentTemplateTransformer extends TransformerAbstract
{

	/**
	 * @var array
	 */
	protected $availableIncludes = [
		'element',
		'body'
	];


	/**
	 * @param CommentTemplate $template
	 *
	 * @return array
	 */
	public function transform(CommentTemplate $template)
	{
		return [
			'id'    => $template->id,
			'title' => $template->title,
		];
	}


	/**
	 * @param CommentTemplate $template
	 *
	 * @return \League\Fractal\Resource\Item
	 */
	public function includeElement(CommentTemplate $template)
	{
		$element = $template->element;

		return $this->item($element, function ($element) {
			return [ 'id' => $element->id, 'name' => $element->name ];
		});
	}


	/**
	 * @param CommentTemplate $template
	 *
	 * @return \League\Fractal\Resource\Item
	 */
	public function includeBody(CommentTemplate $template)
	{
		return $this->item($template, function ($template) {
			return ['body' => $template->body];
		});
	}
}