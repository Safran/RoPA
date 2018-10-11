<?php
/*
  * This file is part of the Record of processing activities project.
  * Its original location is https://github.com/Safran/RoPA
  * 
  * SPDX-License-Identifier: GPL-3.0-only
  */


namespace App\Http\Controllers\Backend;

use App\Exports\UsersExport;
use App\Models\Company;
use App\Models\Serializers\DatatableArraySerializer;
use App\Models\Statement;
use App\Models\Transformers\AdminUserTransformer;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

/**
 * Class UserController
 *
 * @package App\Http\Controllers\Backend
 */
class UserController extends Controller
{

	/**
	 * User list
	 *
	 * @param Request $request
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function index(Request $request)
	{
		$selectedRole = null;
		if (isset($request->role) && User::roles()->has($request->role))
		{
			$users        = User::where('role', $request->role)->get();
			$selectedRole = $request->role;
		}
		else
		{
			$users = User::all();
		}

		return view('backend.users.index', compact('users', 'selectedRole'));
	}


	public function datas(Request $request)
	{
		$search = $request->get('search');
		if (isset($request->role) && User::roles()->has($request->role))
		{
			$users = User::where('role', $request->role)->when(array_key_exists('value',
					$search) && ! empty($search['value']), function ($query) use ($search) {
				return $query->where([
					[ 'first_name', 'LIKE', $search['value'] . '%' ],
					[ 'last_name', 'LIKE', $search['value'] . '%', 'or' ],
					[ 'email', 'LIKE', $search['value'] . '%', 'or' ],
				]);
			});
		}
		else
		{
			$users = User::when(array_key_exists('value', $search) && ! empty($search['value']),
				function ($query) use ($search) {
					return $query->where([
						[ 'first_name', 'LIKE', $search['value'] . '%' ],
						[ 'last_name', 'LIKE', $search['value'] . '%', 'or' ],
						[ 'email', 'LIKE', $search['value'] . '%', 'or' ],
					]);
				});
		}
		$recordsTotal    = User::count();
		$recordsFiltered = $users->count();
		$draw            = $request->get('draw', 0);
		$start           = $request->get('start', 0);
		$length          = $request->get('length', 50);

		// get order
		$order = $request->get('order', null);
		if (is_array($order) && count($order) > 0)
		{
			$columns = $request->get('columns');
			$name    = $columns[(int) $order[0]['column']]['name'];
			if ($name == 'name')
			{
				$users->orderBy('last_name', $order[0]['dir'])->orderBy('first_name', $order[0]['dir']);
			}
			else
			{
				$users->orderBy($name, $order[0]['dir']);
			}

		}

		$users = $users->offset($start)->take($length)->get();

		// draw $request->get('draw', 0);
		// recordsTotal Users::count()
		// recordsFiltered
		$pagination = [
			'draw'            => $request->get('draw', 0),
			'recordsTotal'    => $recordsTotal,
			'recordsFiltered' => $recordsFiltered,
		];

		return fractal($users, new AdminUserTransformer, new DatatableArraySerializer($pagination));
	}


	/**
	 * Confirmation modal for deleting user
	 *
	 * @param User $user
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 * @throws AuthorizationException
	 */
	public function getModalDelete(User $user)
	{
		$this->authorize('destroy', $user);

		$model         = 'users';
		$confirm_route = $error = null;
		try
		{
			$confirm_route = route('admin.users.delete', [ $user ]);

			return view('layouts.common._modal_confirmation', compact('error', 'model', 'confirm_route'));
		}
		catch (\Exception $e)
		{

			$error = trans('admin/users.error.destroy', compact('id'));

			return view('backend.layouts.modal_confirmation', compact('error', 'model', 'confirm_route'));
		}
	}


	/**
	 * Delete user
	 *
	 * @param User $user
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 * @throws AuthorizationException
	 * @throws \Exception
	 */
	public function destroy(User $user)
	{
		$this->authorize('destroy', $user);

		// Remove from Company
        Company::where('lawyer_id', $user->id)->each(function($company) use($user){
            Log::debug('Removing [' . $user->full_name . '] from [ ' . $company->name . ']');
            $company->lawyer_id = null;
            $company->save();
        });

		if ($user->forceDelete()) // We wan't hard delete for respecting RGPD
		{
			return redirect(route('admin.users'))->with('success',
				trans('admin/commons.messages.success.delete', [ 'element' => __('admin/users.title') ]));
		}
		else
		{
			return redirect(route('admin.users'))->with('success',
				trans('admin/commons.messages.error.delete', [ 'element' => __('admin/users.title') ]));
		}
	}


	/**
	 * @param User $user
	 * @param      $role
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 *
	 * @throws AuthorizationException
	 * @throws \Exception
	 */
	public function getModalUpdateRole(User $user, $role)
	{
		$this->authorize('updateRole', $user);

		$model         = 'users';
		$confirm_route = $error = null;

		if ( ! in_array($role, [ 'admin', 'lawyer', 'employee' ]))
		{
			throw new \Exception('wrong usage of update role');
		}

		try
		{
			$confirm_route = route('admin.users.updaterole', [ $user ]);

			return view('backend.users._modal_confirmation',
				compact('error', 'model', 'confirm_route', 'user', 'role'));
		}
		catch (\Exception $e)
		{
			$error = trans('admin/users.error.updaterole', compact('id'));

			return view('backend.layouts.modal_confirmation', compact('error', 'model', 'confirm_route'));
		}
	}


	/**
	 * Update Role for user
	 *
	 * @param User    $user
	 * @param Request $request
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 * @throws AuthorizationException
	 */
	public function updateRole(User $user, Request $request)
	{
		$this->authorize('updateRole', $user);

		$request->validate([
			'role' => 'required|in:employee,lawyer,admin',
		]);

		$user->role = $request->get('role');
		if($user->role === 'employee')
		{ // If user is downgrade to employee, remove company
			// He has in charge
			$user->manage()->each(function($company){
				$company->lawyer_id = null;
				$company->save();
			});
		}

		if ($user->save())
		{
			return redirect(route('admin.users'))->with('success',
				trans('admin/commons.messages.success.update', [ 'element' => __('admin/users.title') ]));
		}
		else
		{
			return redirect(route('admin.users'))->with('success',
				trans('admin/commons.messages.error.update', [ 'element' => __('admin/users.title') ]));
		}
	}


	/**
	 *
	 * @return \Illuminate\Http\Response|\Symfony\Component\HttpFoundation\BinaryFileResponse
	 */
	public function csv()
	{
		return ( new UsersExport )->download();
	}


	/**
	 * @param User $user
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 * @throws AuthorizationException
	 */
	public function getModalMassAssign(User $user)
	{
		$this->authorize('massassign', $user);

		$error = null;
		try
		{
			return view('backend.users._mass-assign-modal', compact('error', 'user'));
		}
		catch (\Exception $e)
		{
			dd($e);
		}
	}

	public function MassAssign(Request $request, User $user)
	{
		try
		{
			$to = User::findOrFail((int)$request->get('to'));

			// Update all created by
			Statement::withTrashed()->where('created_by', '=', $user->id)->each(function (Statement $statement) use ($to) {
				$statement->created_by = $to->id;
				$statement->save();
			});
			// Update all modified by
			Statement::withTrashed()->where('modified_by', '=', $user->id)->each(function (Statement $statement) use ($to) {
				$statement->modified_by = $to->id;
				$statement->save();
			});

			// Update all owners more tricky! we need to update answers too!
			Statement::withTrashed()->where('owner_id', '=', $user->id)->each(function (Statement $statement) use ($to) {
				$statement->owner_id = $to->id;
				$statement->save();
				$answer         = $statement->answers->where('element.name', 'user')->first();
				$answer->answer = serialize($to->id);
				$answer->save();
			});

			Cache::flush();
		}
		catch (\Exception $e)
		{
			dd($e);
			abort(500);
		}

		return response([], 204);
	}
}
