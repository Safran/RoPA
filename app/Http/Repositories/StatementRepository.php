<?php
/*
  * This file is part of the Record of processing activities project.
  * Its original location is https://github.com/Safran/RoPA
  * 
  * SPDX-License-Identifier: GPL-3.0-only
  */


namespace App\Http\Repositories;

use App\Models\Statement;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;

/**
 * Class StatementRepository
 *
 * @package App\Http\Repositories
 */
class StatementRepository
{

	/**
	 * @param $datas
	 *
	 * @return Collection
	 */
	protected function filter($datas): Collection
	{
		return $datas->filter(function ($statement) {
			$condition  = true;
			$statements = request()->get('statements', 1);

			if (isset($statements) && $statements == '1')
			{
				$me        = auth()->user();
				$filter = ( $statement->owner->id == $me->id || $statement->author->id == $me->id );
				if($me->role === 'lawyer')
				{
					$filter |= ($statement->supervisor_id == $me->id);
				}
				$condition &= $filter;

			}
			$status = request()->get('status');
			if (isset($status) && in_array($status, [ '1', '2' ]))
			{
				if ($status == '1') // archived
				{
					$condition &= $statement->archived;

				}
				elseif ($status == '2') // validated
				{
					$condition &= $statement->validated;
				}
			}
			$company_id = request()->get('company_id');
			if (isset($company_id))
			{
				$condition &= ( $statement->get('company')->id == $company_id );
			}
			$country_id = request()->get('country_id');
			if (isset($country_id))
			{
				$condition &= ( $statement->get('main_country')->id == $country_id );
			}

			return $condition;
		});
	}


	/**
	 * Get pending statements ( optionally limited to $limit items ) order by
	 * created_at desc
	 *
	 * @param int $limit
	 *
	 * @return Collection
	 */
	public function getPending(int $limit = 0)
	{
		return $this->paginate($this->filter($this->getPendingQuery($limit)->get()), ( $limit > 0 ? $limit : 10 ));
	}


	/**
	 * @param int $limit
	 *
	 * @return Collection
	 */
	public function getPendingFilteredQuery(int $limit = 0)
	{
		return $this->filter($this->getPendingQuery($limit)->get());
	}


	/**
	 * @param int $limit
	 *
	 * @return mixed
	 */
	public function getPendingQuery(int $limit = 0)
	{
		return Statement::with([
			'form',
			'owner',
			'author',
			'form.pages',
			'form.pages.elements',
			'form.pages.elements.element_show_if'
		])->whereNull('supervisor_id')->where([
			[ 'archived', '=', false ],
			[ 'validated', '=', false ]
		])->when($limit > 0, function ($query) use ($limit) {
			$query->take($limit);
		})->latest();
	}


	/**
	 * @param bool $onlyMine
	 * @param int  $limit
	 *
	 * @return mixed
	 */
	public function getInprogressQuery($onlyMine = false, int $limit = 0)
	{
		$me = auth()->user();

		if (App::runningInConsole())
		{
			$me       = new \stdClass;
			$me->role = 'admin';
		}

		return Statement::with([
			'form',
			'owner',
			'author',
			'form.elements',
		])->when($me->role === 'employee', // If employee, can only show from creator and owner
			function ($query) use ($me) {
				$query->where([
					[ 'created_by', '=', $me->id ],
					[ 'owner_id', '=', $me->id, 'or' ]
				]);
		})->when($onlyMine && ($me->role === 'lawyer' || $me->role === 'admin'), // If lawyer and onlymine .. show only mine
			function ($query) use ($me) {
				$query->where([
					[ 'created_by', '=', $me->id ],
					[ 'owner_id', '=', $me->id, 'or' ], 
					[ 'supervisor_id', '=', $me->id, 'or' ]
				]);
			})// Don't get archived and validated
		->where([
			[ 'archived', '=', false ],
			[ 'validated', '=', false ]
		])->when($limit > 0, function ($query) use ($limit) {
			$query->take($limit);
		})->latest();
	}


	/**
	 * @param bool $onlyMine
	 * @param int  $limit
	 *
	 * @return Collection
	 */
	public function getInprogressFilteredQuery($onlyMine = false, int $limit = 0)
	{
		return $this->filter($this->getInprogressQuery($onlyMine, $limit)->get());
	}


	/**
	 * @param int $limit
	 *
	 * @return mixed
	 */
	public function getFinishedQuery($limit = 0)
	{
		$me = auth()->user();

		return Statement::with([
			'form',
			'form.pages',
			'owner',
			'author',
			'form.pages.elements',
			'form.pages.elements.element_show_if'
		])->when($me->role === 'employee', function ($query) use ($me) {
			$query->where([
				[ 'created_by', '=', $me->id ],
				[ 'owner_id', '=', $me->id, 'or' ]
			]);
		})->where([
			[ 'archived', '=', true ],
			[ 'validated', '=', true, 'or' ]
		])->when($limit > 0, function ($query) use ($limit) {
			$query->take($limit);
		})->latest();
	}


	/**
	 * @param int $limit
	 *
	 * @return Collection
	 */
	public function getFinishedFilteredQuery(int $limit = 0)
	{
		return $this->filter($this->getFinishedQuery($limit)->get());
	}


	/**
	 * Get in-progress statements optionally limited to $limit items ) order by
	 * created_at desc
	 *
	 * @param bool $onlyMine only my statement ( by default all ) if allowed
	 * @param int  $limit
	 *
	 * @return Collection
	 */
	public function getInprogress($onlyMine = false, int $limit = 0)
	{
		return $this->paginate($this->filter($this->getInprogressQuery($onlyMine, $limit)->get()),
			( $limit > 0 ? $limit : 10 ));
	}


	/**
	 * @param       $items
	 * @param int   $perPage
	 * @param null  $page
	 * @param array $options
	 *
	 * @return LengthAwarePaginator
	 */
	public function paginate($items, $perPage = 15, $page = null, $options = [])
	{
		$page  = $page ?: ( Paginator::resolveCurrentPage() ?: 1 );
		$items = $items instanceof Collection ? $items : Collection::make($items);

		return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
	}


	/**
	 * Get all finished statement optionally limited to $limit items ) order by
	 * created_at desc
	 *
	 * @param int $limit
	 *
	 * @return Collection
	 */
	public function getFinished(int $limit = 0)
	{

		return $this->paginate($this->filter($this->getFinishedQuery($limit)->get()), ( $limit > 0 ? $limit : 10 ));
	}
}