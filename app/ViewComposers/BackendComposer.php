<?php
/*
  * This file is part of the Record of processing activities project.
  * Its original location is https://github.com/Safran/RoPA
  * 
  * SPDX-License-Identifier: GPL-3.0-only
  */






namespace App\ViewComposers;

use Illuminate\View\View;

class BackendComposer
{
	public function compose(View $view)
	{
		$view->with('logged_in_user', auth()->user());
	}
}