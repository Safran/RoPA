@extends('layouts.backend')

@section('title')
    @lang('admin/settings.title') @parent
@stop

@section('header_styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/colorbox.css') }}"/>
    <style>
        .thumbnail {
            width: 100px;
            height: 100px;
        }

        .small, small {
            font-size: .8rem;
        }
    </style>
@stop

@section('content')
    {{ bs()->openForm('post', route('admin.settings.store')) }}
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">
                @lang('admin/settings.settings-list')
            </h4>
            <div class="float-right">
                <div class="btn-group">
                    {{ bs()->submit(__('admin/settings.save-button'))->addClass(['my-1', 'btn', 'btn-sucess']) }}
                </div>
            </div>
        </div>
        <br/>
        <div class="card-body">
            <div class="container">
                <div class="row my-2 ">
                    <table class="table table-bordered">
                        <thead>
                        <tr class="filters">
                            <th>@lang('admin/settings.headers.label')</th>
                            <th>@lang('admin/settings.headers.key')</th>
                            <th>@lang('admin/settings.headers.value')</th>
                            <th>@lang('admin/settings.headers.date')</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(!empty($settings))
                            @foreach($settings as $key => $group)
                                <tr class="group text-lg-center">
                                    <td colspan="5">@lang('admin/settings.groups.'.$key)</td>
                                </tr>
                                @foreach($group as $setting)
                                    <tr>
                                        <td>{{ $setting->label }}</td>
                                        <td>{{ $setting->key }}</td>
                                        <td>{{ $setting->input }}</td>
                                        <td>{{ $setting->created_at->diffForHumans() }}</td>
                                    </tr>
                                @endforeach
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    {{ bs()->closeForm() }}
@stop


@section('footer_scripts')
    <script src="{{ asset('js/jquery.colorbox-min.js') }}"></script>
    <script src="{{ asset('js/i18n/jquery.colorbox-'.locale().'.js') }}"></script>

    <script>

        $(document).on('click', '.popup_selector', function (event) {
            event.preventDefault();
            var updateID = $(this).attr('data-inputid');
            var elfinderUrl = '/elfinder/popup/';

            var triggerUrl = elfinderUrl + updateID;
            $.colorbox({
                href: triggerUrl,
                fastIframe: true,
                iframe: true,
                width: '70%',
                height: '70%'
            });

        });
        function processSelectedFile(fileUrl, requestingField) {
            $('#' + requestingField).val(fileUrl).trigger('change');
            $('#img' + requestingField).attr('src', fileUrl)
        }
    </script>

@stop