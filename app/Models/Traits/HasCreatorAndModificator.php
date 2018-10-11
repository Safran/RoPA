<?php
/*
  * This file is part of the Record of processing activities project.
  * Its original location is https://github.com/Safran/RoPA
  * 
  * SPDX-License-Identifier: GPL-3.0-only
  */






namespace App\Models\Traits;

use App\Models\User;

trait HasCreatorAndModificator
{
	public function author()
	{
		return $this->belongsTo(User::class, 'created_by');
	}

	public function modificator()
	{
		return $this->belongsTo(User::class, 'modified_by');
	}

	public function editor()
	{
		if ($this->modified_by)
		{
			return $this->belongsTo(User::class, 'modified_by');
		}
		else
		{
			return $this->belongsTo(User::class, 'created_by');
		}
	}
}