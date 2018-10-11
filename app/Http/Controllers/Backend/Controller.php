<?php
/*
  * This file is part of the Record of processing activities project.
  * Its original location is https://github.com/Safran/RoPA
  * 
  * SPDX-License-Identifier: GPL-3.0-only
  */


namespace App\Http\Controllers\Backend;

use App\Models\Statement;
use App\Models\Transformers\StatementTransformer;
use DataTables;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

/**
 * Class Controller
 * @package App\Http\Controllers\Backend
 */
class Controller extends BaseController
{

	use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


	public function __construct()
	{
		$this->middleware('admin');
	}


	/**
	 * Update all possible translatable attribute from request
	 *
	 * @param Model   $model
	 * @param Request $request
	 * @param array   $except
	 */
	protected function updateTranslations(Model $model, Request $request, $except = [])
	{
		foreach (locales() as $locale)
		{
			foreach ($model->getTranslatableAttributes() as $fieldName)
			{
				if ( ! $request->exists($fieldName) || in_array($fieldName, $except))
				{
					continue;
				}
				$translations = $request->get($fieldName);
				if ( ! array_key_exists($locale, $translations))
				{
					continue;
				}
				$model->setTranslation($fieldName, $locale, $translations[$locale]);
			}
		}
	}


	/**
	 * get Translations
	 *
	 * @param Model $model
	 *
	 * @return array
	 */
	protected function getTranslationsRequestFields(Model $model)
	{
		$fields = [];
		foreach (locales() as $locale)
		{
			foreach ($model->getTranslatableAttributes() as $fieldName)
			{
				$fields[] = $fieldName . '[' . $locale . ']';
			}
		}

		return $fields;
	}


	/**
	 * Show admin dashboard
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function dashboard()
	{
		return view('backend.dashboard.index');
	}


	/**
	 * @return \Spatie\Fractal\Fractal
	 */
	public function statements()
	{
		$statements = Statement::latest()->get();

		return DataTables::collection($statements)
			->setTransformer(new StatementTransformer)
			->make(true);

		//return fractal($statements, new StatementTransformer)->parseExcludes('pages');
	}


	/**
	 * @param Statement $statement
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function getStatementModalDelete(Statement $statement)
	{
		$model         = 'dashboard.statements';
		$confirm_route = $error = null;
		try
		{
			$confirm_route = route('admin.statements.delete', [ $statement ]);

			return view('layouts.common._modal_confirmation', compact('error', 'model', 'confirm_route'));
		}
		catch (\Exception $e)
		{

			$error = trans('admin/forms.element.error.destroy', compact('id'));

			return view('backend.layouts.modal_confirmation', compact('error', 'model', 'confirm_route'));
		}
	}


	/**
	 * @param Statement $statement
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 * @throws \Exception
	 */
	public function StatementDestroy(Statement $statement)
	{
		if ($statement->delete())
		{
			return redirect(route('admin.dashboard') )->with('success',
				trans('admin/commons.messages.success.delete', [ 'element' => __('admin/dashboard.statements.title') ]));
		}
		else
		{
			return redirect(route('admin.dashboard'))->with('success',
				trans('admin/commons.messages.error.delete', [ 'element' => __('admin/dashboard.statements.title') ]));
		}
	}
}
