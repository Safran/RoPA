@extends('layouts.backend')

@section('title')
    @lang('admin/forms.title') @parent
@stop

@section('header_styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/waves.min.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/dataTables.bootstrap4.min.css') }}"/>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">
                @lang('admin/forms.forms-list')
            </h4>
            <div class="float-right">
                <div class="btn-group">
                    @if(\App\Models\Form::current() != null && \App\Models\Form::latest()->first()->published_at)
                        <a href="{{ route('admin.forms.create') }}"
                           class="btn btn-success">@lang('admin/forms.create-button')</a>
                    @endif
                </div>
            </div>
        </div>
        <br/>
        @if(request()->has('processing'))
            <div class="card-body">
                <div class="container">
                    <div class="progress">
                        <div class="progress-bar" id="publish-status" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
                    </div>
                </div>
            </div>
        @endif
        <div class="card-body">
            <div class="container">
                <div class="row my-2 ">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="table" style="width:100%;">
                            <thead>
                            <tr class="filters">
                                <th>@lang('admin/forms.headers.id')</th>
                                <th>@lang('admin/forms.headers.title')</th>
                                <th>@lang('admin/forms.headers.author')</th>
                                <th>@lang('admin/forms.headers.date')</th>
                                <th>@lang('admin/forms.headers.counts')</th>
                                <th>@lang('admin/forms.headers.status')</th>
                                <th>@lang('admin/forms.headers.actions')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(!empty($forms))
                                @foreach($forms as $form)
                                    <tr>
                                        <td>{{ $form->id }}</td>
                                        <td>{{ $form->title }}</td>
                                        <td>{{ $form->editor->full_name }}</td>
                                        <td>{{ $form->created_at }}</td>
                                        <td><span class="badge badge-info" data-toggle="tooltip" data-placement="top" title="@lang('admin/forms.headers.validated')">{{ $form->statements->where('validated', true)->where('archived', false)->count() }}</span> <span class="badge badge-warning" data-toggle="tooltip" data-placement="top" title="@lang('admin/forms.headers.archived')">{{ $form->statements->where('archived', true)->count() }}</span> <span class="badge badge-primary" data-toggle="tooltip" data-placement="top" title="@lang('admin/forms.headers.inprogress')">{{ $form->statements->where('archived', false)->where('validated', false)->count() }}</span></td>
                                        <td>@if($form->published_at)@lang('admin/forms.published_infos', ['date' => $form->published_at->formatLocalized('%d %B %Y'), 'publisher' => $form->publisher->full_name]) @else @lang('admin/commons.draft') @endif</td>
                                        <td>
                                            <div class="btn-group">
                                                @if(! $form->published_at)
                                                @if(! request()->has('processing'))
                                                    <a href="{{ route('admin.forms.edit', [$form]) }}"
                                                   class="btn"><i class="zmdi zmdi-edit zmdi-hc-2x text-success"></i></a>
                                                    <a href="{{ route('admin.forms.publish', [$form]) }}" class="btn"><i class="zmdi zmdi-upload zmdi-hc-2x text-primary"></i></a>
                                                    <a data-toggle="modal"
                                                       data-target="#delete_confirm"
                                                       data-remote="{{ route('admin.forms.confirm-delete', [$form]) }}" class="btn"><i class="zmdi zmdi-delete zmdi-hc-2x text-primary"></i></a>

                                                    @else
                                                        <small>@lang('admin/forms.publish-in-progress')</small>
                                                @endif
                                                @endif
                                            </div>
                                        </td>
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
@stop

@section('footer_scripts')
    <script type="text/javascript" src="{{ asset('js/waves.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/dataTables.bootstrap4.min.js') }}"></script>

    <script>
        $(document).ready(function () {
            $('#table').DataTable({
                order: [[ 3, "desc" ]],
                language: {
                    url: '{{ asset('js/dataTables/'.App::getLocale().'.json') }}'
                },
                initComplete: function (settings, json) {

                },
            });
        });
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
    <script>
        var interval = 1000;
        function doAjax() {
            $.ajax({
                type: 'GET',
                url: '{{ route('admin.forms.publish.status', ['id' => request()->get('processing')]) }}',
                success: function (data) {
                    $('#publish-status').css('width', data.progress_percentage + '%');
                    $('#publish-status').text(data.progress_percentage + '%');
                    $('#publish-status').attr('aria-valuenow', data.progress_percentage);
                },
                complete: function (data) {
                    if(! data.is_ended && (data.status != 'failed'))
                    {
                        setTimeout(doAjax, interval);
                    } else {
                        window.location.href = this.$url('/forms');
                    }
                }
            });
        }
        setTimeout(doAjax, interval);
    </script>
@stop