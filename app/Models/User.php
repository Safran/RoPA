<?php
/*
  * This file is part of the Record of processing activities project.
  * Its original location is https://github.com/Safran/RoPA
  * 
  * SPDX-License-Identifier: GPL-3.0-only
  */






namespace App\Models;

use Adldap\Laravel\Traits\HasLdapUser;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;

/**
 * App\Models\User
 *
 * @property-read \App\Models\Company $company
 * @property-read mixed $full_name
 * @property-read mixed $is_admin
 * @property-read mixed $is_lawyer
 * @property-read mixed $seen_disclaimer
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read \App\Models\Disclaimerstatus $seen
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Statement[] $statements
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Statement[] $supervisedStatements
 * @mixin \Eloquent
 * @property int $id
 * @property string $username
 * @property string $email
 * @property string $password
 * @property mixed $first_name
 * @property mixed $last_name
 * @property int $active
 * @property string|null $last_connexion
 * @property string $role
 * @property int $company_id
 * @property string|null $remember_token
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereLastConnexion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereUsername($value)
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User withoutTrashed()
 * @property string|null $sid id saml2
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereSid($value)
 */
class User extends Authenticatable
{
	use Notifiable, SoftDeletes, HasLdapUser;

	protected $fillable = [
		'first_name',
		'last_name',
		'active',
	];

	protected $appends = [
		'isAdmin',
		'isLawyer',
		'full_name',
		'isSaml',
	];

	protected $hidden = [
		'password',
		'remember_token',
		'email',
		'created_at',
		'updated_at',
		'active',
		'deleted_at',
		'isSaml',
	];

	protected $casts = [
		'active' => 'boolean',
	];

	public function statements()
	{
		return $this->hasMany(Statement::class, 'owner_id');
	}

	public function supervisedStatements()
	{
		return $this->hasMany(Statement::class, 'supervisor_id');
	}

	public function company()
	{
		return $this->belongsTo(Company::class);
	}

	public function manage()
	{
		return $this->hasMany(Company::class, 'lawyer_id');
	}

	public function seen()
	{
		return $this->hasOne(Disclaimerstatus::class);
	}

	public static function roles(): Collection
	{
		return collect(['employee' => __('admin/users.roles.employee'), 'lawyer'=> __('admin/users.roles.lawyer'), 'admin'=> __('admin/users.roles.admin')]);
	}

	public function getFirstNameAttribute($value)
	{
		return ucfirst(mb_strtolower($value));
	}


	public function getLastNameAttribute($value)
	{
		return mb_strtoupper($value);
	}


	public function getFullNameAttribute($value)
	{
		return $this->last_name
			? ucfirst(mb_strtolower($this->first_name)) . ' ' . mb_strtoupper($this->last_name)
			: ucfirst(mb_strtolower($this->first_name));
	}


	/**
	 * Determine if the user is an administrator
	 *
	 * @return bool
	 */
	public function isAdmin()
	{
		return ($this->role == 'admin');
	}


	/**
	 * Determine if the user is an administrator
	 *
	 * @return bool
	 */
	public function getIsAdminAttribute()
	{
		return $this->isAdmin();
	}


	/**
	 * Determine if the user is a lawyer
	 *
	 * @return bool
	 */
	public function isLawyer()
	{
		return ($this->role == 'lawyer');
	}


	/**
	 * Determine if the user is a lawyer
	 *
	 * @return bool
	 */
	public function getIsLawyerAttribute()
	{
		return $this->isLawyer();
	}


	public function getSeenDisclaimerAttribute()
	{
		return isset($this->seen);
	}

	public function hasRole($role = null)
	{
		return (!$role) ||

			($this->role == 'admin' ) ||

			($this->role == 'lawyer' && $role != 'admin') ||

			($this->role == 'employee' && $role != 'lawyer');
	}

	public function hasMinimumRights($minimum)
	{
		return  ($this->role == 'admin' && in_array($minimum, ['employee', 'lawyer', 'admin'])) ||
				($this->role == 'lawyer' && in_array($minimum, ['employee', 'lawyer'])) ||
				($this->role == 'employee' && in_array($minimum, ['employee']));
	}

	/**
	 *
	 * @return mixed
	 */
	public function getIsSamlAttribute()
	{
		return session()->get('sessionIndex', null) !== null;
	}
}
