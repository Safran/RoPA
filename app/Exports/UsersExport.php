<?php
/*
  * This file is part of the Record of processing activities project.
  * Its original location is https://github.com/Safran/RoPA
  * 
  * SPDX-License-Identifier: GPL-3.0-only
  */






namespace App\Exports;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Responsable;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Shared\Date;

/**
 * Class UsersExport
 *
 * @package App\Exports
 */
class UsersExport implements FromQuery, WithMapping, WithHeadings, Responsable
{
	use Exportable;

	/**
	 * @var string
	 */
	private $fileName;


	/**
	 * UsersExport constructor.
	 *
	 */
	public function __construct()
	{
		$this->fileName = 'Users_' . Carbon::now()->format("YmdHis") . '.xlsx';
	}



	public function headings(): array
	{
		return [
			'#',
			'UUID LDAP',
			'Username',
			'Prénom',
			'Nom',
			'Dernière visite',
			'Rôle',
			'Société',
			'Administrateur ?',
			'Juriste ?',
		];
	}

	public function map($user): array
	{
		return  [
			$user->id,
			$user->sid,
			$user->username,
			$user->first_name,
			$user->last_name,
			(isset($user->last_visit) ? Date::dateTimeToExcel($user->last_visit) :  __('admin/users.never-connected')),
			__('admin/users.roles.'. $user->role),
			$user->company->name,
			$user->is_admin ? __('admin/commons.yes') : __('admin/commons.no'),
			$user->is_lawyer ? __('admin/commons.yes') : __('admin/commons.no'),
		];
	}



	/**
	 * 
	 * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder
	 */
	public function query()
	{
		return User::with(['company']);
	}
}