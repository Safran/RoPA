@extends('layouts.backend')

@section('title')
    @yield('form-title') @parent
@stop


@section('header_styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/dataTables.bootstrap4.min.css') }}"/>
    <style>
        textarea {
            resize: vertical;
        }

        .__locale_text {
            display: inline-block;
            min-width: 2em;
            height: 2em;
            padding: 0 3px;
            color: #0056b3;
            background: #fff;
            border: 1px solid #bbbbbe;
            border-radius: 1em;
            -webkit-box-shadow: 0 3px rgba(34, 34, 34, .075);
            box-shadow: 0 3px rgba(34, 34, 34, .075);
            font-size: 12px;
            font-size: .75rem;
            font-weight: 700;
            line-height: 1.8;
            text-align: center;
            text-transform: uppercase;
        }
    </style>
@stop

@section('content')
    @yield('open-form')
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">
                @yield('form-title')
            </h4>
            <div class="float-right">
                <div class="btn-group">
                    <input type="submit" class="my-1 btn btn-success" value="@lang('admin/commons.save-button')"/>
                    <a href="{{route('admin.forms.edit', [$form, '#fields/'.(isset($formElement) ? $formElement->page_id : $formPage->id)])}}"
                       class="my-1 btn btn-danger">@if(isset($formElement)) @lang('admin/commons.back-button') @else @lang('admin/commons.cancel-button') @endif</a>
                </div>
            </div>
        </div>
        <br/>
        <div class="card-body">
            <div class="container">
                {{ bs()->formGroup(bs()->text('name', old('name', isset($formElement) ? $formElement->name : ''))->if(isset($formElement) && $formElement->isLocked(), function($control) { return $control->readOnly(); }))
                 ->label(__('admin/forms.element.fields.name.label'))
                 ->helpText(__('admin/forms.element.fields.name.help'))
                 }}
                {{bs()->formGroup(bs()->select('page_id', $form->pages->pluck('title', 'id'), old('page_id', isset($formElement) ? $formElement->page_id : $formPage->id)))
                 ->label(__('admin/forms.element.fields.page.label'))
                 ->helpText(__('admin/forms.element.fields.page.help'))
                 }}
                @if(isset($formElement) && isset($formElement->id))
                    {{ bs()->formGroup(bs()->select('type', \App\Models\FormElement::types(), old('type', isset($formElement) ? $formElement->type : 'text'))->disabled()->id('form-element-type'))
                     ->label(__('admin/forms.element.fields.type.label'))

                     ->helpText(__('admin/forms.element.fields.type.help'))
                     }}
                @else
                {{ bs()->formGroup(bs()->select('type', \App\Models\FormElement::types(), old('type', isset($formElement) ? $formElement->type : 'text'))->id('form-element-type'))
                 ->label(__('admin/forms.element.fields.type.label'))

                 ->helpText(__('admin/forms.element.fields.type.help'))
                 }}
                @endif

                @include('partials.form.fields.translatableinputtext', [
                     'label' => __('admin/forms.element.fields.label.label'),
                     'name' => 'label',
                     'required' => false,
                     'model' => isset($formElement) ? $formElement : null,
                 ])

                @include('partials.form.fields.translatableinputtextarea', [
                     'label' => __('admin/forms.element.fields.tips.label'),
                     'name' => 'tips',
                     'required' => false,
                     'model' => isset($formElement) ? $formElement : null,
                 ])

                @include('partials.form.fields.translatableinputtext', [
                     'label' => __('admin/forms.element.fields.placeholder.label'),
                     'name' => 'placeholder',
                     'required' => false,
                     'model' => isset($formElement) ? $formElement : null,
                 ])

                <fieldset class="form-group border p-2" id="fieldsetspecial">
                    <div id="special" @if(isset($formElement)) data-togo="{{ route('admin.elements.specialhtml', [$form, $formElement]) }}" @endif></div>
                </fieldset>
                <fieldset class="form-group border p-2" id="fieldsetrequirements">
                    <legend class="border p-1">@lang('admin/forms.formelement.requirements')</legend>
                    <div class="row">
                        <div class="col-md-6">
                            {{ bs()->formGroup(bs()->checkBox('field_required', __('admin/forms.element.fields.required.label'), old('required', isset($formElement) ? $formElement->field_required : false)))
                                            ->helpText(__('admin/forms.element.fields.required.help'))

                                            }}
                        </div>
                        <div class="col-md-6">
                            {{ bs()->formGroup(bs()->checkBox('cnil_required', __('admin/forms.element.fields.cnil_required.label'), old('cnil_required', isset($formElement) ? $formElement->cnil_required : false)))
                                            ->helpText(__('admin/forms.element.fields.cnil_required.help'))

                                            }}
                        </div>
                    </div>
                </fieldset>


                @if($possiblerules->count() > 0)
                    <fieldset class="form-group border p-2" id="fieldsetrules">
                        <legend class="border p-1">@lang('admin/forms.formelement.rules.title')</legend>
                        <table id="rules-table" width="100%" class="table table-striped table-responsive">
                            <thead>
                            <tr>
                                <th width="50%">@lang('admin/forms.formelement.rules.headers.name')</th>
                                <th width="50%">@lang('admin/forms.formelement.rules.headers.value')</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
							<?php $i = 0;?>
                            @if(isset($formElement) && ! empty($formElement->element_show_if))

                                @foreach($formElement->rules as $rule)
                                    <?php
                                            // FIX BEGIN
                                            if($rule->element->page->form->id != $form->id)
                                            {
                                            	// Relocate rule
	                                            $newelement = $form->elements()->where('name', 'LIKE', $rule->element->name.'%')->first();

	                                            $rule->element = $newelement;
                                            }
                                            // FIX END
                                    ?>
                                    <tr id="rules_tr_{{ $i }}" data-index="{{ $i }}">
                                        <td>
                                            <input type="hidden" name="rules[{{$i}}][element]"
                                                   value="{{ $rule->element->id }}"/><span
                                                    class="rule-element-name">{{ $rule->element->name }}</span>
                                        </td>
                                        <td>
                                            <input type="hidden" name="rules[{{$i}}][value]"
                                                   value="{{ $rule->value->id }}"/><span
                                                    class="rule-element-value">{{ $rule->value->label }}</span>
                                        </td>
                                        <td>

                                            <button type="button" class="btn btn-danger remove-rule"
                                                    data-index="{{ $i }}"><i class="zmdi zmdi-delete"></i>
                                            </button>
                                        </td>
                                    </tr>
									<?php $i++;?>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                        <div class="">
                            <select class="custom-select custom-select-sm mb-2" id="rule-select-element" name="select-rules{{ "[$i][name]" }}">
                                <option value="">@lang('admin/forms.formelement.rules.select-field')</option>
                                @foreach($possiblerules as $element)
                                    <option value="{{$element->id}}"
                                            data-url="{{ route('admin.elements.values', [$element]) }}">{{ $element->name }}</option>
                                @endforeach
                            </select>
                            <select class="custom-select custom-select-sm" id="rule-select-element-value"
                                    name="select-rules{{ "[$i][value]" }}" disabled>

                            </select>
                            <button type="button" class="btn btn-success" id="add-rule" disabled><i
                                        class="zmdi zmdi-plus" ></i>
                            </button>
                            <span class="help-block">@lang('admin/forms.formelement.rules.add-rule-button')</span>
                        </div>

                    </fieldset>
                @endif
            </div>
        </div>
    </div>
    {{ bs()->closeForm() }}
@stop


@section('footer_scripts')
    <script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('js/ckeditor.js') }}"></script>
    <script src="{{ asset('ckeditor/adapters/jquery.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/dataTables.bootstrap4.min.js') }}"></script>

    <script>
        jQuery(document).ready(function () {
            function setForm($type) {
                @foreach(\App\Models\FormElement::types() as $type => $label)
				<?php
					try
					{
					$className = \App\Models\FormElement::type($type);
					$element = new $className(new \App\Models\FormElement, request());
					?>
                if ($type == '{{ $type }}') {
                    @if($element->hasLabel())
                    $('#fieldsetlabel').show();
                    @else
                    $('#fieldsetlabel').hide();
                    @endif
                    @if($element->hasHelp())
                    $('#fieldsettips').show();
                    @else
                    $('#fieldsettips').hide();
                    @endif
                    @if($element->hasPlaceholder())
                    $('#fieldsetplaceholder').show();
                    @else
                    $('#fieldsetplaceholder').hide();
                    @endif
                    @if($element->hasSpecial())
                    $('#fieldsetspecial').show();

                    @switch($element->specialType())
                    @case('text')
                    $('#fieldsetspecialtext').show();
                    $('#fieldsetspecialtextarea').hide();
                    $('#fieldsetspecialtextareachoices').hide();
                    $('#special').html('');
                    @break
                    @case('editor')
                    $('#fieldsetspecialtext').hide();
                    $('#fieldsetspecialtextarea').show();
                    $('#fieldsetspecialtextareachoices').hide();
                    var url = $('#special').data('togo');
                    if (url) {
                        $.ajax({
                            url: url,
                            type: 'GET',
                            success: function (data) {
                                $('#special').html(data);
                                $('.atxeditor').ckeditor();
                            }
                        });
                    } else {
                        $('#special').html('<div class="alert alert-warning my-2 text-center py-2">@lang('admin/forms.formelement.special-warning-editor')</div>');
                    }
                    @break
                    @case('settings')
                    @case('choices')
                    $('#fieldsetspecialtext').hide();
                    $('#fieldsetspecialtextarea').hide();
                    $('#fieldsetspecialtextareachoices').hide();
                    var url = $('#special').data('togo');
                    if (url) {
                        $.ajax({
                            url: url,
                            type: 'GET',
                            success: function (data) {
                                $('#special').html(data);
                            }
                        });
                    } else {
                        $('#special').html('<div class="alert alert-warning my-2 text-center py-2">@lang('admin/forms.formelement.special-warning')</div>');
                    }
                    @break
                    @default
                    $('#fieldsetspecial').hide();
                    $('#special').html('');
                    @endswitch
                    @else
                    $('#fieldsetspecial').hide();
                    $('#special').html('');
                    @endif

                }
				<?php } catch (Exception $e)
			{
				dd( $e );
				} ?>
                @endforeach
            }

            jQuery('#form-element-type').on('change', function () {
                let $type = $(this).val();
                setForm($type);
            });

            setForm(jQuery('#form-element-type').val());

            $('.atxeditor').ckeditor({
                language: '{{ locale() }}',
                customConfig: '{{ asset('js/ckeditor.js') }}'
            });

            $('#rule-select-element').on('change', function () {
                let $selected = $(this).find(':selected'),
                url = $selected.data('url');
                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function (result) {
                        //  $('#special').html(data);
                        if(!result.hasOwnProperty("data") )
                        {
                            $('#rule-select-element-value').empty().attr('disabled', true)  ;
                            $('#add-rule').attr('disabled', true);
                            return;
                        }
                        let data = result.data,
                            htmlOptions = [];
                        if (data.length) {
                            $.each( data, function( key, item ) {
                                let found = false;
                                $("#rules-table").find('tr').each(function () {
                                        $col1 = $( this ).find('td:first'),
                                        $input1 = $col1.find('input:hidden'),
                                        $label1 = $col1.find('span.rule-element-name'),
                                        $col2 = $( this ).find('td:nth-child(2)'),
                                        $input2 = $col2.find('input:hidden'),
                                        $label2 = $col2.find('span.rule-element-value');

                                        if($input1.val() == $selected.val() &&
                                        $input2.val() == item.value)
                                        {
                                            found = true;
                                            return false;
                                        }
                                });
                                if(!found) {
                                    html = '<option value="' + item.value + '">' + item.label + '</option>';
                                    htmlOptions[htmlOptions.length] = html;
                                }
                            });
                            $('#rule-select-element-value').attr('disabled', false);

                            $('#add-rule').attr('disabled', false);
                            $('#rule-select-element-value').empty().append(htmlOptions.join(''));
                        }
                    }
                });
            });
            if ($("#rules-table").length > 0) {
                $(document).on('click', '#add-rule', function () {
                    var index = $('#rules-table tr:last').data('index');
                    if (isNaN(index)) {
                        index = 0;
                    } else {
                        index++;
                    }
                    let $element = $('#rule-select-element').find(':selected'),
                        $elementvalue = $('#rule-select-element-value').find(':selected');

                    $('#rules-table tr:last').after('<tr id="rules_tr_' + index + '" data-index="' + index + '">' +
                        '<td><input name="rules[' + index + '][element]" type="hidden" data-url="' + $element.data('url') + '" value="' + $element.val() + '" class="form-control"/><span class="rule-element-name">' + $element.text() + '</span></td>'
                        + '<td><input name="rules[' + index + '][value]" type="hidden" ' + ' value="' + $elementvalue.val() + '" class="form-control"/><span class="rule-element-value">' + $elementvalue.text() + '</span></td>'

                        + '<td><button type="button" class="btn btn-danger remove-rule" data-index="' + index + '">'
                        + '<i class="zmdi zmdi-delete"></i></button></td>' +
                        '</tr>');
                    $elementvalue.remove();
                    if ($('#rule-select-element-value option').length == 0) {
                        $element.remove();
                    }
                    if ($('#rule-select-element option').length == 1) {
                        $('#rule-select-element').attr('disabled', true);
                        $('#rule-select-element-value').attr('disabled', true);
                        $('#add-rule').attr('disabled', true);
                    }
                });
                $(document).on('click', '.remove-rule', function () {
                    let $index = $(this).data('index'),
                        $line = $("#rules_tr_" + $index),
                        $col1 = $line.find('td:first'),
                        $input = $col1.find('input:hidden'),
                        $label = $col1.find('span.rule-element-name'),
                        $option = $('#rule-select-element option[value="' + $input.val() + '"]');

                    if ($option.length == 0) {
                        $('#rule-select-element').append('<option value="' + $input.val() + '" data-url="' + $input.data('url') + '">' + $label.text() + '</option>');
                        $('#rule-select-element').val($input.val());
                    }
                    $col2 = $line.find('td:nth-child(2)'),
                        $input = $col2.find('input:hidden'),
                        $label = $col2.find('span.rule-element-value');
                    $('#rule-select-element-value').append('<option value="' + $input.val() + '">' + $label.text() + '</option>');


                    $('#rule-select-element').attr('disabled', false);
                    $('#rule-select-element-value').attr('disabled', false);
                    $('#add-rule').attr('disabled', false);

                    $line.remove();
                });
            }
        });
    </script>
@stop