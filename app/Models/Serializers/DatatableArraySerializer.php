<?php
/*
  * This file is part of the Record of processing activities project.
  * Its original location is https://github.com/Safran/RoPA
  * 
  * SPDX-License-Identifier: GPL-3.0-only
  */


namespace App\Models\Serializers;

use League\Fractal\Serializer\ArraySerializer;

class DatatableArraySerializer extends ArraySerializer
{
	protected $pagination = null;

	public function __construct($pagination)
	{
		$this->pagination = $pagination;

	}


	/**
	 * Serialize a collection.
	 *
	 * @param string $resourceKey
	 * @param array  $data
	 *
	 * @return array
	 */
	public function collection($resourceKey, array $data)
	{
		return array_merge(['data' => $data], $this->pagination);
	}

	/**
	 * Serialize an item.
	 *
	 * @param string $resourceKey
	 * @param array  $data
	 *
	 * @return array
	 */
	public function item($resourceKey, array $data)
	{
		return ['data' => $data];
	}

	/**
	 * Serialize null resource.
	 *
	 * @return array
	 */
	public function null()
	{
		return ['data' => []];
	}
}