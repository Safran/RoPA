<?php
/*
  * This file is part of the Record of processing activities project.
  * Its original location is https://github.com/Safran/RoPA
  * 
  * SPDX-License-Identifier: GPL-3.0-only
  */




namespace App\Models\Transformers;

use App\Models\User;
use Illuminate\Support\Str;
use League\Fractal\TransformerAbstract;

/**
 * Class AdminUserTransformer
 *
 * @package App\Models\Transformers
 */
class AdminUserTransformer extends TransformerAbstract
{

	/**
	 * @param User $user
	 *
	 * @return array
	 */
	public function transform(User $user)
	{
		$role_manager = __('admin/users.roles.' . Str::lower($user->role));
		switch ($user->role)
		{
			case 'admin':
				$role_manager .= '<a href="#" data-remote="' . route('admin.users.confirm-updaterole', [
						$user,
						'lawyer'
					]) . '" data-toggle="modal" data-target="#delete_confirm"><i class="zmdi zmdi-minus-square text-danger pull-right"></i></a>';
				break;
			case 'lawyer':
                if($user->supervisedStatements->isEmpty())
                {
                    $role_manager .= '<a href="#" data-remote="' . route('admin.users.confirm-updaterole', [
                            $user,
                            'admin'
                        ]) . '" data-toggle="modal" data-target="#delete_confirm"><i class="zmdi zmdi-plus-box text-sucess pull-right"></i></a>' . '<a href="#" data-remote="' . route('admin.users.confirm-updaterole',
                            [
                                $user,
                                'employee'
                            ]) . '" data-toggle="modal" data-target="#delete_confirm"><i class="zmdi zmdi-minus-square text-danger pull-right"></i></a>';
                } else {
                    $role_manager .= '<a href="#" data-remote="' . route('admin.users.confirm-updaterole', [
                            $user,
                            'admin'
                        ]) . '" data-toggle="modal" data-target="#delete_confirm"><i class="zmdi zmdi-plus-box text-sucess pull-right"></i></a>' . '<i class="zmdi zmdi-minus-square text-grey pull-right"></i>';

                }
				break;
			case 'employee':
			default:
				$role_manager .= '<a href="#" data-remote="' . route('admin.users.confirm-updaterole', [
						$user,
						'lawyer'
					]) . '" data-toggle="modal" data-target="#delete_confirm"><i class="zmdi zmdi-plus-box text-sucess pull-right"></i></a>';
				break;
		}

		$statistics = '<span class="zmdi zmdi-archive pull-left"> ' . (int) $user->statements->where('archived',
				true)->count() . '</span>
                                            <span class="zmdi zmdi-assignment-check pull-left"> ' . (int) $user->statements->where('validated',
				true)->count() . '</span>
                                            <span class="zmdi zmdi-assignment-o pull-left"> ' . (int) $user->statements->where('archived',
				false)->where('validated', false)->count() . '</span>';

		if ($user->hasMinimumRights('lawyer'))
		{
			$statistics .= '<span class="zmdi zmdi-assignment-account pull-left"> ' . (int) $user->supervisedStatements->count() . '</span>';

		}

		if(\Auth::user()->can('destroy', $user))
		{
			$actions = '<a href="#" data-remote="' . route('admin.users.confirm-delete', [$user]).'" data-toggle="modal" data-target="#delete_confirm"><i class="zmdi zmdi-delete"></i></a>';
		} else {
			$actions = '<span class="zmdi-hc-stack"><i class="zmdi zmdi-delete zmdi-hc-stack-1x"></i><i class="zmdi zmdi-block zmdi-hc-stack-2x text-danger"></i> </span>';
		}

		if(\Auth::user()->can('massassign', $user) && $user->role === 'employee' && ! \Auth::user()->can('destroy', $user))
		{
			$actions .= '&nbsp;<a href="#" data-remote="' . route('admin.users.confirm-mass-assign', [$user]).'" data-toggle="modal" data-target="#assign_confirm"><i class="zmdi zmdi-assignment-alert"></i></a>';
		}


		return [
			'id'             => $user->id,
			'name'           => $user->full_name,
			'email'          => $user->email,
			'role'           => $user->role,
			'username'       => $user->username,
			'role_manager'   => $role_manager,
			'company'        => $user->company->name,
			'last_connexion' => ( ! $user->last_connexion ) ? __('admin/users.never-connected') : $user->last_connexion,
			'statistics'     => $statistics,
			'actions'        => $actions,
		];
	}
}