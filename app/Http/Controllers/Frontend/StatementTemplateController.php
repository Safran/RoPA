<?php
/*
  * This file is part of the Record of processing activities project.
  * Its original location is https://github.com/Safran/RoPA
  * 
  * SPDX-License-Identifier: GPL-3.0-only
  */


namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Form;
use App\Models\StatementTemplate;
use App\Models\StatementTemplateAnswer;
use App\Models\Transformers\StatementTemplateTransformer;
use Illuminate\Http\Request;
use Spatie\Fractalistic\ArraySerializer;

/**
 * Class StatementTemplateController
 *
 * @package App\Http\Controllers\Frontend
 */
class StatementTemplateController extends Controller
{

	/**
	 * @return \Spatie\Fractal\Fractal
	 */
	public function data()
	{
		$statementtemplates = StatementTemplate::all();

		return fractal($statementtemplates, new StatementTemplateTransformer, new ArraySerializer);
	}


	/**
	 *
	 * @param StatementTemplate $statementTemplate
	 *
	 * @return $this
	 */
	public function answers(StatementTemplate $statementTemplate)
	{
		return fractal($statementTemplate, new StatementTemplateTransformer,
			new ArraySerializer)->parseIncludes('answers');
	}


	/**
	 * @param Request $request
	 *
	 * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
	 * @throws \Illuminate\Auth\Access\AuthorizationException
	 */
	public function store(Request $request)
	{
		$this->authorize('store', StatementTemplate::class);

		$request->validate([
			'__title' => 'required|unique:statement_templates,title',
		]);
		$statementtemplate = StatementTemplate::create([
			'title'      => $request->get('__title'),
			'created_by' => auth()->user()->id,
		]);
		$form              = Form::current();
		foreach ($form->pages as $page)
		{
			foreach ($page->elements as $element)
			{
				if ($request->has($element->name) && isset($request->{$element->name}))
				{
					StatementTemplateAnswer::create([
						'form_element_id'       => $element->id,
						'statement_template_id' => $statementtemplate->id,
						'answer'                => serialize($request->{$element->name}),
						'created_by'            => auth()->user()->id,
					]);
				}
			}
		}

		return response([ 'id' => $statementtemplate->id ], 201);
	}


	/**
	 *
	 * @param StatementTemplate $statementTemplate
	 *
	 * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
	 * @throws \Illuminate\Auth\Access\AuthorizationException
	 */
	public function destroy(StatementTemplate $statementTemplate)
	{
		$this->authorize('delete', StatementTemplate::class);

		$statementTemplate->forceDelete();

		return response('', 204);
	}
}
