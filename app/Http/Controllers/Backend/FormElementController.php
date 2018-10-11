<?php
/*
  * This file is part of the Record of processing activities project.
  * Its original location is https://github.com/Safran/RoPA
  * 
  * SPDX-License-Identifier: GPL-3.0-only
  */






namespace App\Http\Controllers\Backend;

use App\Http\Requests\ElementRequest;
use App\Models\Form;
use App\Models\FormElement;
use App\Models\FormPage;

/**
 * Class FormElementController
 *
 * @package App\Http\Controllers\Backend
 */
class FormElementController extends Controller
{

	public function create(Form $form, FormPage $formPage)
	{
		$possiblerules = $formPage->elements->whereIn('type', [
			'radiogroup',
			'checkboxgroup'
		]);//collect((isset($formElement) ? :$formPage->elements->whereIn('type', ['radiogroup', 'checkboxgroup'])->pluck('name', 'id'))->all());

		return view('backend.elements.create', compact('form', 'formPage', 'possiblerules'));
	}


	/**
	 * @param ElementRequest $request
	 * @param Form           $form
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function store(ElementRequest $request, Form $form)
	{
		//$this->authorize('manage', $form);

		$request->merge([
			'created_by'     => auth()->id(),
			'field_required' => ( $request->has('field_required') && $request->get('field_required') == 1 ),
			'cnil_required'  => ( $request->has('cnil_required') && $request->get('cnil_required') == 1 ),
		]);

		$element = FormElement::create($request->all());

		if ($element->id)
		{
			// Manage rules
			$rules = $request->get('rules');
			if ($rules)
			{
				foreach ($rules as $rule)
				{
					$ifElement = FormElement::find($rule['element']);
					$element->element_show_if()->attach($ifElement, [ 'if_element_value' => $rule['value'] ]);
				}
			}

			\Cache::clear();
			return redirect(route('admin.elements.edit',
					[ $form, $element ]) . '#fields/' . $element->page_id)->with('success',
				trans('admin/commons.messages.success.create', [ 'element' => __('admin/forms.element.title') ]));
		}
		else
		{
			return redirect(route('admin.elements.edit',
					[ $form, $element ]) . '#fields/' . $element->page_id)->withInput()->with('error',
				trans('admin/commons.messages.error.create', [ 'element' => __('admin/forms.element.title') ]));
		}
	}


	/**
	 *
	 * @param Form        $form
	 * @param FormElement $formElement
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function edit(Form $form, FormElement $formElement)
	{
		$possiblerules = $formElement->page->elements->whereIn('type', [
			'radiogroup',
			'checkboxgroup'
		])->where('id', '<>',
			$formElement->id);//collect((isset($formElement) ? :$formPage->elements->whereIn('type', ['radiogroup', 'checkboxgroup'])->pluck('name', 'id'))->all());


		return view('backend.elements.edit', compact('form', 'formElement', 'possiblerules'));
	}


	/**
	 * get Possible value for an element. Only relevant for radiogroup and checkboxesgroup
	 * @param FormElement $formElement
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function getPossibleValue(FormElement $formElement)
	{
		if ( ! in_array($formElement->type, [ 'radiogroup', 'checkboxgroup' ]))
		{
			return response()->json([], 500);
		}
		$specials = json_decode($formElement->special, true);

		return fractal($specials, function (array $special) {
			return [
				'value' => $special['value'],
				'label' => array_key_exists(locale(), $special['label']) ? $special['label'][locale()] : '',
			];
		})->respond();
	}


	/**
	 *
	 * @param ElementRequest $request
	 * @param Form           $form
	 * @param FormElement    $formElement
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function update(ElementRequest $request, Form $form, FormElement $formElement)
	{
		//$this->authorize('manage', $form);
		$special = $formElement->getSpecialToSave($request);
		if($special)
		{
			$request->merge([
				'special' => $special->toJson(JSON_PRETTY_PRINT),
			]);
		}
		$this->updateTranslations($formElement, $request);

		$request->merge([
			'modified_by'    => auth()->id(),
			'field_required' => ( $request->has('field_required') && $request->get('field_required') == 1 ),
			'cnil_required'  => ( $request->has('cnil_required') && $request->get('cnil_required') == 1 ),
		]);

		//
		$rules = $request->get('rules');
		if ($rules)
		{
			$formElement->element_show_if()->detach();
			foreach ($rules as $rule)
			{
				$ifElement = FormElement::find($rule['element']);
				$formElement->element_show_if()->attach($ifElement, [ 'if_element_value' => $rule['value'] ]);
			}
		} else {
			// Delete rules
			$formElement->element_show_if()->detach();
		}

		if ($formElement->update($request->except(array_merge($formElement->getTranslatableAttributes(),
			[ '_method', '_token', 'type' ]))))
		{
			\Cache::clear();
			return redirect(route('admin.forms.edit', [ $form ]) . '#fields/' . $formElement->page_id)->with('success',
				trans('admin/commons.messages.success.update', [ 'element' => __('admin/forms.element.title') ]));

		}
		else
		{
			return redirect(route('admin.forms.edit',
					[ $form ]) . '#fields/' . $formElement->page_id)->withInput()->with('error',
				trans('admin/commons.messages.error.update', [ 'element' => __('admin/forms.element.title') ]));
		}
	}


	/**
	 *
	 * @param Form        $form
	 * @param FormElement $formElement
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function getModalDelete(Form $form, FormElement $formElement)
	{
		$model         = 'forms.formelement';
		$confirm_route = $error = null;
		try
		{
			$confirm_route = route('admin.elements.delete', [ $form, $formElement ]);

			return view('layouts.common._modal_confirmation', compact('error', 'model', 'confirm_route'));
		}
		catch (\Exception $e)
		{

			$error = trans('admin/forms.element.error.destroy', compact('id'));

			return view('backend.layouts.modal_confirmation', compact('error', 'model', 'confirm_route'));
		}
	}


	/**
	 *
	 * @param Form        $form
	 * @param FormElement $formElement
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 * @throws \Exception
	 */
	public function destroy(Form $form, FormElement $formElement)
	{
		if ($formElement->delete())
		{
			return redirect(route('admin.forms.edit', [ $form ]) . '#fields')->with('success',
				trans('admin/commons.messages.success.delete', [ 'element' => __('admin/forms.element.title') ]));
		}
		else
		{
			return redirect(route('admin.forms.edit', [ $form ]) . '#fields')->with('success',
				trans('admin/commons.messages.error.delete', [ 'element' => __('admin/forms.element.title') ]));
		}
	}


	/**
	 * Saving order
	 */
	public function saveOrder()
	{
		FormElement::setNewOrder(request('ids'));
	}


	/**
	 *
	 * @param Form     $form
	 * @param FormPage $formPage
	 *
	 * @return mixed
	 * @throws \Exception
	 */
	public function data(Form $form, FormPage $formPage)
	{
		return datatables()->of(
			FormElement::where('page_id', $formPage->id)
				->orderBy('ordering')->get([
			'id',
			'name',
			'type',
			'field_required',
			'cnil_required',
			'created_at'
		])->each(function(&$element) use($form){
					$wrongrules = collect($element->rules);
					$wrongrules = $wrongrules->filter(function($rule) use($form){
							return $rule->element->page->form->id != $form->id;
						});

					if($wrongrules->isNotEmpty())
					{
						$element->name =' !!! ' . $element->name . ' !!!! ';
					}
				}))->addColumn('action', function ($element) use ($form, $formPage) {
			return '<a href="#" data-remote="' . route('admin.elements.confirm-delete', [ $form, $element->id ]) . '"
                                                       data-toggle="modal"
                                                       data-target="#delete_confirm"><i class="zmdi zmdi-delete"></i></a>
                                             ';
		})->toJson();
	}


	/**
	 * get Special html code tp add fonctionnalities
	 * to input field form
	 *
	 * @param Form        $form
	 * @param FormElement $formElement
	 *
	 * @return mixed
	 * @throws \App\Form\Exceptions\FieldTypeDoesNotExists
	 */
	public function getSpecialHtml(Form $form, FormElement $formElement)
	{
		return $formElement->getSpecial();
	}
}
