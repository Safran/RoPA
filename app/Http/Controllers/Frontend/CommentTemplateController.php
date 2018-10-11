<?php
/*
  * This file is part of the Record of processing activities project.
  * Its original location is https://github.com/Safran/RoPA
  * 
  * SPDX-License-Identifier: GPL-3.0-only
  */






namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\CommentTemplate;
use App\Models\FormElement;
use App\Models\Transformers\CommentTemplateTransformer;
use Illuminate\Http\Request;
use Spatie\Fractalistic\ArraySerializer;

/**
 * Class CommentTemplateController
 *
 * @package App\Http\Controllers\Frontend
 */
class CommentTemplateController extends Controller
{

	/**
	 * @param Request     $request
	 * @param FormElement $element
	 *
	 * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
	 * @throws \Illuminate\Auth\Access\AuthorizationException
	 */
	public function store(Request $request, FormElement $formElement)
	{
		$this->authorize('commenttemplate', $formElement);

		$request->validate([
			'title' => 'required|min:3',
			'body'  => 'required|min:3',
		]);

		$template = CommentTemplate::create([
			'title'           => $request->get('title'),
			'form_element_id' => $formElement->id,
			'locale'          => locale(),
			'created_by'      => auth()->user()->id,
			'body'            => $request->get('body'),
		]);

		return response(json_encode([ 'id'    => $template->id,
		                              'title' => $request->get('title'),
		                              'body'  => $template->body,
		]), 201);
	}


	/**
	 * @return \Spatie\Fractal\Fractal
	 * @throws \Illuminate\Auth\Access\AuthorizationException
	 */
	public function data()
	{
		$this->authorize('data', CommentTemplate::class);

		$templates = CommentTemplate::where('locale', locale())->get();

		return fractal($templates, new CommentTemplateTransformer)->parseIncludes('element');
	}


	/**
	 * @param FormElement $formElement
	 *
	 * @return \Spatie\Fractal\Fractal
	 * @throws \Illuminate\Auth\Access\AuthorizationException
	 */
	public function templates(FormElement $formElement)
	{
		$this->authorize('data', CommentTemplate::class);

		$templates = CommentTemplate::where([
			[ 'form_element_id', '=', $formElement->id ],
			[ 'locale', '=', locale() ]
		])->get();

		return fractal($templates, new CommentTemplateTransformer)->parseIncludes('body');
	}


	/**
	 * @param CommentTemplate $commentTemplate
	 *
	 * @return \Spatie\Fractal\Fractal
	 * @throws \Illuminate\Auth\Access\AuthorizationException
	 */
	public function body(CommentTemplate $commentTemplate)
	{
		$this->authorize('data', CommentTemplate::class);

		return fractal($commentTemplate, new CommentTemplateTransformer, new ArraySerializer)->parseIncludes('body');
	}


	/**
	 * @param CommentTemplate $commentTemplate
	 *
	 * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
	 * @throws \Illuminate\Auth\Access\AuthorizationException
	 * @throws \Exception
	 */
	public function destroy(CommentTemplate $commentTemplate)
	{
		$this->authorize('delete', CommentTemplate::class);

		$commentTemplate->delete();

		return response('', 204);
	}
}
