<?php
/*
  * This file is part of the Record of processing activities project.
  * Its original location is https://github.com/Safran/RoPA
  * 
  * SPDX-License-Identifier: GPL-3.0-only
  */


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Company
 *
 * @mixin \Eloquent
 * @property int $id
 * @property string $name
 * @property string|null $logo
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Company whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Company whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Company whereLogo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Company whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Company whereUpdatedAt($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $users
 */
class Company extends Model
{
	protected $fillable = [
		'name',
		'lawyer_id',
	];


	/**
	 * Every known people for this company
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function users()
	{
		return $this->hasMany(User::class);
	}


	/**
	 * Lawyers of the company
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function lawyers()
	{
		return $this->hasMany(User::class)->where('role', 'lawyer');
	}


	/**
	 * Default lawyer for this company
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasOne
	 */
	public function lawyer()
	{
		return $this->hasOne(User::class, 'id', 'lawyer_id');
	}
}
