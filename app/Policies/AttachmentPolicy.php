<?php
/*
  * This file is part of the Record of processing activities project.
  * Its original location is https://github.com/Safran/RoPA
  * 
  * SPDX-License-Identifier: GPL-3.0-only
  */






namespace App\Policies;

use App\Models\Attachment;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AttachmentPolicy
{
	use HandlesAuthorization;


	public function show(User $user, Attachment $attachment)
	{
		$statment = $attachment->attachmentable->answer->statement;

		return $user->hasRole('admin') ||
			  ($user->hasRole('lawyer') && ($user->id == $statment->supervisor_id)) ||
			  ($user->hasRole('employee') &&  ($user->id == $statment->owner_id || $user->id == $statment->created_by));
	}
}