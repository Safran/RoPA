<?php
/*
  * This file is part of the Record of processing activities project.
  * Its original location is https://github.com/Safran/RoPA
  * 
  * SPDX-License-Identifier: GPL-3.0-only
  */


namespace App\Http\Controllers;

use App\Models\Country;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Collection;

/**
 * Class Controller
 *
 * @package App\Http\Controllers
 */
class Controller extends BaseController
{

	use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


	/**
	 *
	 * @param $statements
	 *
	 * @return Collection
	 */
	protected function prepareStatements(&$statements): Collection
	{
		$countries = collect();
		foreach ($statements as &$statement)
		{
			$statement->name         = $statement->get('name') ?? 'N/A';
			$statement->main_country = $statement->get('main_country');
			if ($statement->main_country)
			{
				$countries[$statement->main_country->id] = $statement->get('main_country');
			}
			else
			{
				$statement->main_country = Country::where('name', 'France');
			}
			$statement->date = $statement->get('date') ? $statement->get('date')->formatLocalized('%x') : Carbon::now()->formatLocalized('%x');
			$statement->link = route('frontend.statements.edit', [ $statement ]);

			if (auth()->user()->can('duplicate', $statement))
			{
				$statement->duplicatelink = route('frontend.statements.duplicate', [ $statement ]);
			}
			$statement->progress = $statement->getProgressAttribute();
		}

		return $countries;
	}
}