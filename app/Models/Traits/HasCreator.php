<?php
/*
  * This file is part of the Record of processing activities project.
  * Its original location is https://github.com/Safran/RoPA
  * 
  * SPDX-License-Identifier: GPL-3.0-only
  */






namespace App\Models\Traits;

use App\Models\User;

trait HasCreator
{
	public function author()
	{
		return $this->belongsTo(User::class, 'created_by');
	}
}