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
 * App\Models\Disclaimerstatus
 *
 * @property-read \App\Models\User $user
 * @mixin \Eloquent
 * @property int $id
 * @property int $user_id
 * @property \Carbon\Carbon $seen_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Disclaimerstatus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Disclaimerstatus whereSeenAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Disclaimerstatus whereUserId($value)
 */
class Disclaimerstatus extends Model
{
    protected $fillable = ['seen_at'];
    protected $dates = [ 'seen_at' ];

    public $timestamps = false;

    public function user()
    {
    	return $this->belongsTo(User::class);
    }
}
