<?php
/*
  * This file is part of the Record of processing activities project.
  * Its original location is https://github.com/Safran/RoPA
  * 
  * SPDX-License-Identifier: GPL-3.0-only
  */


namespace App\Models\Transformers;

use Imtigger\LaravelJobStatus\JobStatus;
use League\Fractal\TransformerAbstract;

class JobStatusTransformer extends TransformerAbstract
{
	public function transform(JobStatus $jobStatus)
	{
		return [
			'status'              => $jobStatus->status,
			'progress_now'        => $jobStatus->progress_now,
			'progress_max'        => $jobStatus->progress_max,
			'progress_percentage' => $jobStatus->progress_percentage,
			'is_ended'            => $jobStatus->is_ended,
		];
	}

}