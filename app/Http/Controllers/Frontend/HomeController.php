<?php
/*
  * This file is part of the Record of processing activities project.
  * Its original location is https://github.com/Safran/RoPA
  * 
  * SPDX-License-Identifier: GPL-3.0-only
  */






namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Repositories\StatementRepository;
use App\Models\Company;

/**
 * Class HomeController
 *
 * @package App\Http\Controllers\Frontend
 */
class HomeController extends Controller
{

	/**
	 *
	 * @var StatementRepository
	 */
	protected $repository;


	/**
	 * HomeController constructor.
	 *
	 * @param StatementRepository $repository
	 */
	public function __construct(StatementRepository $repository)
	{
		$this->repository = $repository;
	}


	/**
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function show()
	{
		$pendings = $this->repository->getPendingQuery(4)->get();
		$pendingsshowmorelink = ($this->repository->getPendingQuery()->count() > 4);

		$inprogress = $this->repository->getInprogressQuery(true, 4)->get();
		$inprogressshowmorelink = ($this->repository->getInprogressQuery(true)->count() > 4);

		$finished  = $this->repository->getFinishedFilteredQuery(4);
		$companies = Company::has('users.statements')->pluck('name', 'id');

		$countries = $this->prepareStatements($finished);
		$countries = $countries->pluck('name', 'id');
		
		return view('frontend.welcome', compact('pendings', 'inprogress', 'finished', 'companies', 'countries', 'inprogressshowmorelink', 'pendingsshowmorelink'));
	}
}
