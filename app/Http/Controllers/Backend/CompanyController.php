<?php
/*
  * This file is part of the Record of processing activities project.
  * Its original location is https://github.com/Safran/RoPA
  * 
  * SPDX-License-Identifier: GPL-3.0-only
  */


namespace App\Http\Controllers\Backend;

use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

/**
 * Class CompanyController
 *
 * @package App\Http\Controllers\Backend
 */
class CompanyController extends Controller
{

	/**
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function index()
	{

		return view('backend.companies.index');
	}


	/**
	 * @return mixed
	 * @throws \Exception
	 */
	public function data()
	{
		return Datatables::of(Company::query())->addColumn('users', function ($company) {
			return $company->users->count();
		})->addColumn('lawyers', function ($company) {
			return $company->lawyers->count();
		})->addColumn('statements', function ($company) {
			return $company->users->sum(function ($user) {
				return $user->statements->count();
			});
		})->editColumn('lawyer', function (Company $company) {
			/**
			if ($company->lawyers->count() > 0)
			{
				return bs()->select('lawyer',
						$company->lawyers->pluck('fullname', 'id')->prepend(__('admin/companies.select-lawyer'), ''),
						isset($company->lawyer_id) ? $company->lawyer_id : '')->addClass([
						'changelawyer',
						'custom-select-sm',
						'p2'
					])->attributes([ 'data-key' => $company->id ]);
			}
			else
			{
			 * */
				return bs()->select('lawyer', User::where('role', 'lawyer')
					     ->get()->pluck('fullname', 'id')
					      ->prepend(__('admin/companies.select-lawyer'), ''),
						isset($company->lawyer_id) ? $company->lawyer_id : '')->addClass([
						'changelawyer',
						'custom-select-sm',
						'p2'
					])->attributes([ 'data-key' => $company->id ]);
				/**
			}
				 *
				 */
		})->make(true);
	}


	/**
	 * @return Company
	 * @deprecated
	 */
	public function getCompanyQuery()
	{
		return Company::select([
			'companies.id',
			'name',
			\DB::raw('count(users.id) as lawyers'),
		])->join('users', 'users.company_id', '=', 'companies.id', 'left')->whereIn('role',
			[ 'admin', 'lawyer' ])->groupBy('users.id');
	}


	/**
	 *
	 * @param Request $request
	 * @param Company $company
	 *
	 * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
	 */
	public function assignLawyer(Request $request, Company $company)
	{
		try
		{
			$user = User::FindOrFail($request->get('user'));

			if ($user->role != 'lawyer') //  || ($user->company->id != $company->id)
			{
				abort(403);
			}

			$company->lawyer_id = $user->id;
		}
		catch (\Exception $e)
		{

			$company->lawyer_id = null;
		}
		$company->save();

		return response(json_encode([]), 204);
	}
}