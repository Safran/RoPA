<?php
/*
  * This file is part of the Record of processing activities project.
  * Its original location is https://github.com/Safran/RoPA
  * 
  * SPDX-License-Identifier: GPL-3.0-only
  */






namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Models\Transformers\AnswerTransformer;
use Illuminate\Http\Request;

/**
 * Class AnswerController
 *
 * @package App\Http\Controllers\Frontend
 */
class AnswerController extends Controller
{
	/**
	 * @param Answer  $answer
	 * @param Request $request
	 *
	 * @return \Illuminate\Contracts\Routing\ResponseFactory|\Spatie\Fractal\Fractal|\Symfony\Component\HttpFoundation\Response
	 * @throws \Illuminate\Auth\Access\AuthorizationException
	 */
    public function tagHasValidate(Answer $answer, Request $request)
    {
	    $this->authorize('can-validate', $answer);

	    $request->validate([
		    'valide' => 'required|boolean',
	    ]);


	    $needRefresh = false;
	    if($request->get('valide', false) === true)
	    {
	    	if($answer->validated_at !== null && $answer->validated_at !== false)
		    {
		    	return response(json_encode(['error' => 'already set']),400);
		    }
		    $answer->validated_at = today();
	    } else {
		    if($answer->validated_at === null && $answer->validated_at !== false)
		    {
			    return response(json_encode(['error' => 'already set']),400);
		    }
		    $answer->validated_at = null;
		    if($answer->statement->validated)
		    {
			    $answer->statement->validated = false;
			    $answer->statement->archived = false;
			    $needRefresh = $answer->statement->save();
		    }
	    }
	    $answer->save();
	    \Cache::flush(); // flush cache to reprocess progress calculation
	    $needRefresh = $needRefresh || ($answer->statement->progress['global'] === 100);

	    return fractal($answer, AnswerTransformer::class)->parseIncludes('progress')->addMeta(['needRefresh' => $needRefresh]);
    }
}
