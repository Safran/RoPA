@extends('layouts.backend')

@section('title')
    @lang('admin/forms.title') @parent
@stop

@section('header_styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/waves.min.css') }}"/>
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

        .actions {
            position: fixed;
            right: 32px;
            bottom: 55px;
            z-index: 1290;
            -webkit-animation-duration: 3s;
            -o-animation-duration: 3s;
            animation-duration: 3s;
        }

        .actions .btn {
            -webkit-box-shadow: 0 10px 10px 0 rgba(60, 60, 60, .1);
            box-shadow: 0 10px 10px 0 rgba(60, 60, 60, .1)
        }
    </style>
@stop
@section('content')
    {{ bs()->openForm('put', route('admin.forms.update', [$form])) }}
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">
                @lang('admin/forms.forms-edit')
            </h4>
            <div class="float-right">
                <div class="btn-group">
                    <input type="submit" class="my-1 btn btn-success" value="@lang('admin/commons.save-button')"/>
                    <a href="{{route('admin.forms')}}"
                       class="my-1 btn btn-danger">@lang('admin/commons.cancel-button')</a>
                </div>
            </div>
        </div>
        <br/>
        <div class="card-body">
            <div class="container">
                @include('partials.form.fields.translatableinputtext', [
                    'label' => __('admin/forms.fields.title.label'),
                    'name' => 'title',
                    'model' => $form,
                    'required' => true,
                ])
                <ul class="nav nav-tabs" role="tablist" id="tab-list">
                    <li class="nav-item">
                        <a class="nav-link active" id="disclaimer-tab" data-toggle="tab" href="#disclaimer" role="tab"
                           aria-controls="disclaimer" aria-selected="true">@lang('admin/forms.disclaimer')</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="pages-tab" data-toggle="tab" href="#pages" role="tab"
                           aria-controls="pages" aria-selected="true">@lang('admin/forms.pages-title')</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link @if($form->pages->isEmpty()) disabled @endif"
                           id="fields-tab" data-toggle="tab" href="#fields" role="tab"
                           aria-controls="fields" aria-selected="true">@lang('admin/forms.fields-title')</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="disclaimer" role="tabpanel"
                         aria-labelledby="disclaimer-tab">
                        @include('partials.form.fields.translatableinputtextarea', [
                     'name' => 'disclaimer',
                     'model' => $form,
                     'required' => true,
                 ])
                    </div>
                    <div class="tab-pane fade" id="pages" role="tabpanel" aria-labelledby="pages-tab">
                        <div class="my-2">
                            <div class="button-bar">
                                <div id="pages-table-toolbar">
                                    <a class="btn-group my-1" href="{{ route('admin.pages.create', [$form]) }}">
                                        <button type="button" class="btn">+</button>
                                    </a>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table" id="pages-table"
                                       data-sortable="{{ route('admin.pages.save_order') }}" style="width:100%">
                                    <thead>
                                    <tr class="filters">
                                        <th>@lang('admin/forms.pages.headers.ordering')</th>
                                        <th data-orderable="false">@lang('admin/forms.pages.headers.count')</th>
                                        <th data-orderable="false">@lang('admin/forms.pages.headers.title')</th>
                                        <th data-orderable="false">@lang('admin/forms.pages.headers.fields')</th>
                                        <th data-orderable="false">@lang('admin/forms.pages.headers.date')</th>
                                        <th data-orderable="false"></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if($form->pages->isNotEmpty())
										<?php $i = 1; ?>
                                        @foreach($form->pages as $page)
                                            <tr data-row-id="{{ $page->id }}">
                                                <td><i class="zmdi zmdi-format-list-numbered"></i></td>
                                                <td>{{ $i++ }} / {{ $form->pages->count() }}</td>
                                                <td>
                                                    <a href="{{ route('admin.pages.edit', [$form, $page]) }}">{{ $page->title }}</a>
                                                </td>
                                                <td>{{ $page->elements->count() }}</td>
                                                <td>{{ $page->created_at }}</td>
                                                <td><a href="#"
                                                       data-remote="{{ route('admin.pages.confirm-delete', [$form, $page]) }}"
                                                       data-toggle="modal"
                                                       data-target="#delete_confirm"><i
                                                                class="zmdi zmdi-delete"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="fields" role="tabpanel" aria-labelledby="fields-tab">
                        <div class="my-2">
                            <div class="button-bar">
                                <select class="custom-select atx-change-page">
                                    @foreach($form->pages as $page)
                                        <option value="{{ $page->id }}">{{ $page->title }}</option>
                                    @endforeach
                                </select>
                                <a class="btn-group my-1 atx-create-element" href="#"
                                   data-ref="{{ route('admin.elements.create', [$form]) }}">
                                    <button type="button" class="btn">+
                                    </button>
                                </a>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table" id="fields-table"
                                   data-sortable="{{ route('admin.elements.save_order') }}" style="width:100%">
                                <thead>
                                <tr class="filters">
                                    <th>@lang('admin/forms.fields.headers.ordering')</th>
                                    <th data-orderable="false">@lang('admin/forms.fields.headers.name')</th>
                                    <th data-orderable="false">@lang('admin/forms.fields.headers.type')</th>
                                    <th data-orderable="false">@lang('admin/forms.fields.headers.required')</th>
                                    <th data-orderable="false">@lang('admin/forms.fields.headers.cnil_required')</th>
                                    <th data-orderable="false">@lang('admin/forms.fields.headers.date')</th>
                                    <th data-orderable="false">@lang('admin/forms.fields.headers.action')</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if($form->pages->isNotEmpty() && $form->pages->first()->elements->isNotEmpty())
                                    @foreach($form->pages->first()->elements as $element)
                                        <tr data-row-id="{{ $element->id }}">
                                            <td><i class="zmdi zmdi-format-list-numbered"></i></td>
                                            <td>{{ $element->name }}</td>
                                            <td>{{ $element->type }}</td>
                                            <td>@if($element->field_required) @lang('admin/commons.yes') @else @lang('admin/commons.no') @endif</td>
                                            <td>@if($element->cnil_required) @lang('admin/commons.yes') @else @lang('admin/commons.no') @endif</td>
                                            <td>{{ $element->date }}</td>
                                            <td>...</td>
                                        </tr>
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    {{ bs()->closeForm() }}
@stop

@section('footer_scripts')
    <script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('js/ckeditor.js') }}"></script>
    <script src="{{ asset('ckeditor/adapters/jquery.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/waves.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/dataTables.bootstrap4.min.js') }}"></script>
    <script>
        (function ($) {
            $(function () {
                jQuery(document).ready(function ($) {
                    $('#pages-table').on('sorted', function (event, data) {
                        var i = 1;
                        $('#pages-table').find('tr td:nth-child(2)').each(function () {
                            var $td = $(this);
                            $td.html(i++ + ' / ' + $('#pages-table').find('tbody > tr').length);
                        });
                    });

                    $('.atxeditor').ckeditor({
                        language: '{{ locale() }}',
                        customConfig: '{{ asset('js/ckeditor.js') }}',
                        extraPlugins: 'pagebreak',
                    });

                    $('#pages-table').DataTable({
                        language: {
                            url: '{{ asset('js/dataTables/'.App::getLocale().'.json') }}'
                        },
                        pageLength: 40,
                    });
                    @if($form->pages->isNotEmpty())
                    $('#fields-table').DataTable({
                        language: {
                            url: '{{ asset('js/dataTables/'.App::getLocale().'.json') }}'
                        },
                        initComplete: function (settings, json) {

                                var hash = document.location.hash;
                                if (hash && hash.length > 1) {
                                    hash = hash.split('/');
                                    hash[0] && $('ul.nav a[href="' + hash[0] + '"]').tab('show');
                                    if (hash[1]) {
                                        $('.atx-change-page').val(hash[1]);
                                       if ( $.fn.dataTable.isDataTable( '#fields-table' ) ) {
                                            $('#fields-table').DataTable().ajax.url('{!!  url(locale().'/admin/elements/' . $form->id . '/data')  !!}/' + hash[1]);
                                           $('#fields-table').DataTable().ajax.reload();
                                       }
                                    }
                                }

                        },
                        pageLength: 40,
                        ajax: '{!!  url(locale().'/admin/elements/' . $form->id . '/data')  !!}/{{ $form->pages->first()->id }}',
                        columns: [
                            {
                                data: 'id',
                                name: 'id',
                                orderable: false,
                                searchable: false,
                                render: function (data, type, full, meta) {
                                    return '<i class="zmdi zmdi-format-list-numbered"></i>'
                                },
                            },
                            {
                                data: 'name',
                                name: 'name',
                                render: function (data, type, full, meta) {
                                    return '<a href="{!!  url(locale() .'/admin/elements/'.$form->id . '/edit/') !!}/' + full.id + '"><i class="zdmi zdmi-user"></i> ' + data + '</a>';
                                }
                            },
                            {
                                data: 'type',
                                name: 'type'
                            },
                            {
                                data: 'field_required',
                                name: 'field_required',
                                render: function (data, type, full, meta) {
                                    if (data) {
                                        return '@lang('admin/commons.yes')';
                                    } else {
                                        return '@lang('admin/commons.no')';
                                    }
                                }
                            },
                            {
                                data: 'cnil_required',
                                name: 'cnil_required',
                                render: function (data, type, full, meta) {
                                    if (data) {
                                        return '@lang('admin/commons.yes')';
                                    } else {
                                        return '@lang('admin/commons.no')';
                                    }
                                }
                            },
                            {
                                data: 'created_at',
                                name: 'created_at'
                            },
                            {
                                data: 'action',
                                name: 'action'
                            }
                        ],
                        order: [[0, 'asc']],
                        createdRow: function (row, data, index) {
                            $(row).attr('data-row-id', data.id);
                        }
                    });
                    $('.atx-change-page').on('change', function () {
                        var id = $(this).val();
                        $('#fields-table').DataTable().ajax.url('{!!  url(locale().'/admin/elements/' . $form->id . '/data')  !!}/' + id);
                        $('#fields-table').DataTable().ajax.reload();
                    });
                    $('.atx-create-element').on('click', function () {
                        var $select = $('.atx-change-page').val();

                        document.location = $(this).attr('data-ref') + '/' + $select;
                    });
                    @endif
                });
            });
        })(jQuery);
    </script>
    <div class="modal fade" id="delete_confirm" tabindex="-1" role="dialog" aria-labelledby="form_delete_confirm_title"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content"></div>
        </div>
    </div>
    <script>
        jQuery(document).ready(function ($) {
            jQuery('body').on('click', '[data-toggle="modal"]', function () {
                jQuery(jQuery(this).data("target") + ' .modal-content').load(jQuery(this).data("remote"));
            });
            jQuery('body').on('hidden.bs.modal', '.modal', function () {
                jQuery(this).removeData('bs.modal');
            });
        });
    </script>
@endsection