<?php
/*
  * This file is part of the Record of processing activities project.
  * Its original location is https://github.com/Safran/RoPA
  * 
  * SPDX-License-Identifier: GPL-3.0-only
  */






namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Attachment;

/**
 * Class AttachmentController
 *
 * @package App\Http\Controllers\Frontend
 */
class AttachmentController extends Controller
{

	/**
	 * @param Attachment $attachment
	 *
	 * @return mixed
	 * @throws \Illuminate\Auth\Access\AuthorizationException
	 */
	public function show(Attachment $attachment)
	{
		$this->authorize('show', $attachment);
		return response()->file(storage_path('statements/'.$attachment->path));
	}
}
