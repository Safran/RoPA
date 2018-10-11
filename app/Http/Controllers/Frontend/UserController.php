<?php
/*
  * This file is part of the Record of processing activities project.
  * Its original location is https://github.com/Safran/RoPA
  * 
  * SPDX-License-Identifier: GPL-3.0-only
  */


namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Transformers\UserTransformer;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Fractalistic\ArraySerializer;

/**
 *  Class UserController
 *
 * @package App\Http\Controllers\Frontend
 */
class UserController extends Controller
{

	/**
	 * @param Request $request
	 *
	 * @return \Spatie\Fractal\Fractal
	 * @throws \Illuminate\Auth\Access\AuthorizationException
	 */
	public function Search(Request $request)
	{
		// $this->authorize('data', User::class);

		$role = request()->get('role', null);
		$me   = auth()->user();
		if ( ! in_array($role, [ 'employee', 'lawyer', 'admin', 'minlawyer' ]) || ! $me->hasRole($role))
		{
			$role = null;
		}

		$request->validate([
			'q' => 'required_without:i',
			'i' => 'required_without:q',
		]);
		$users = collect();

		$search = $request->get('q');
		if($search)
		{
			$full_name  = explode(' ', $search, 2);
			$first_name = count($full_name) >= 1 ? $full_name[0] : '';
			$last_name  = count($full_name) >= 2 ? $full_name[1] : '';

			$users = User::where([['first_name', 'like', $first_name . '%'],
				                  ['last_name', 'like', $first_name . '%', 'or']])
				->when(! empty($last_name), function ($query) use ($last_name) {
					return $query->where('last_name', 'like', $last_name . '%' , 'or');
				})->when(( isset($role) && $role === 'minlawyer' ), function ($query) use ($role, $me) {
					if ($me->role == 'lawyer')
					{
						return $query->whereIn('role', [ 'lawyer' ]);
					}
					elseif ($me->role == 'admin')
					{
						return $query->whereIn('role', [ 'lawyer', 'admin' ]);
					}
				})->when(isset($role) && $role !== 'minlawyer', function ($query) use ($role) {
					return $query->whereRole($role);
				})->when(! isset($role), function ($query) use ($me) {
					if ($me->role == 'lawyer')
					{
						return $query->whereIn('role', [ 'lawyer', 'employee' ]);
					}
					else
					{
						if ($me->role == 'employee')
						{
							return $query->whereIn('role', [ 'employee' ]);
						}
						else
						{
							return $query;
						}
					}
				})->when($me->role == 'employee', function ($query) use ($me) {
					// Employee can only have employee of their company
					$query->where('company_id', $me->company_id);
				})->orderBy('last_name')->orderBy('first_name')->get();

		} else {
			$id = (int)$request->get('i');
			if($id)
			{
				$users[] = User::orderBy('last_name')->orderBy('first_name')->find($id);
			}
		}

		return fractal($users, new UserTransformer, new ArraySerializer);
	}


	public function data()
	{
		//$this->authorize('data', User::class); // Only admin / lawyer

		$role = request()->get('role', null);
		$me   = auth()->user();
		if ( ! in_array($role, [ 'employee', 'lawyer', 'admin', 'minlawyer' ]) || ! $me->hasRole($role))
		{
			$role = null;
		}

		$users = User::when(( isset($role) && $role === 'minlawyer' ), function ($query) use ($role, $me) {
			if ($me->role == 'lawyer')
			{
				return $query->whereIn('role', [ 'lawyer' ]);
			}
			elseif ($me->role == 'admin')
			{
				return $query->whereIn('role', [ 'lawyer', 'admin' ]);
			}
		})->when(isset($role) && $role !== 'minlawyer', function ($query) use ($role) {
			return $query->whereRole($role);
		})->when(! isset($role), function ($query) use ($me) {
			if ($me->role == 'lawyer')
			{
				return $query->whereIn('role', [ 'lawyer', 'employee' ]);
			}
			else
			{
				if ($me->role == 'employee')
				{
					return $query->whereIn('role', [ 'employee' ]);
				}
				else
				{
					return $query;
				}
			}
		})->when($me->role == 'employee', function ($query) use ($me) {
			// Employee can only have employee of their company
			$query->where('company_id', $me->company_id);
		})->orderBy('last_name')->orderBy('first_name')->get();

		return fractal($users, new UserTransformer, new ArraySerializer);
	}
}
