<?php
/*
  * This file is part of the Record of processing activities project.
  * Its original location is https://github.com/Safran/RoPA
  * 
  * SPDX-License-Identifier: GPL-3.0-only
  */






namespace App\Policies;

trait AdminPolicy {
	public function before($user, $ability)
	{
		if ($user->isAdmin()) {
			return true;
		}
	}
}