<?php
/*
  * This file is part of the Record of processing activities project.
  * Its original location is https://github.com/Safran/RoPA
  * 
  * SPDX-License-Identifier: GPL-3.0-only
  */






namespace App\Models\Transformers;

use App\Models\Statement;
use League\Fractal\TransformerAbstract;

/**
 * Class StatementTransformer
 * @package App\Models\Transformers
 */
class StatementTransformer extends TransformerAbstract
{

	/**
	 *
	 * @var array
	 */
	protected $defaultIncludes = [
	//	'pages',
	];

	protected $availableIncludes = [
		'pages',
	];

	/**
	 * @param Statement $statement
	 *
	 * @return array
	 */
	public function transform(Statement $statement)
	{
		return [
			'id'            => $statement->id,
			'date'          => $statement->has('date') ? $statement->get('date')->format('d/m/Y') : '',
			'company'       => $statement->has('company') ? $statement->get('company')->name : '',
			'main_country'  => $statement->has('main_country') ? $statement->get('main_country')->name : '',
			'author'        => $statement->author->full_name,
			'author_id'     => $statement->author->id,
			'owner'         => $statement->has('user') ? $statement->get('user')->full_name : '',
			'owner_id'      => $statement->has('user') ? $statement->get('user')->id : null,
			'project'       => $statement->has('name') ? $statement->get('name') : '',
			'supervisor'    => isset($statement->supervisor_id) ? $statement->supervisor->full_name : '',
			'supervisor_id' => isset($statement->supervisor_id) ? $statement->supervisor->id : '',
			'progress'      => $statement->progress,
			'validated'     => $statement->validated,
			'archived'      => $statement->archived,
		];
	}


	/**
	 * @param Statement $statement
	 *
	 *
	 * @return \League\Fractal\Resource\Collection
	 */
	protected function includePages(Statement $statement)
	{
		$pages = $statement->form->pages;

		return $this->collection($pages, new PageTransformer($statement));
	}
}