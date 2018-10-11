@extends('layouts.backend')

@section('title')
    @lang('admin/translations.title') @parent
@stop

@section('header_styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/dataTables.bootstrap4.min.css') }}"/>
    <style>
        .atxinputaslink {
            border: none;
            border-bottom: 1px dotted #0056b3;
        }
        .atxinputshow {
            border: 1px solid #0056b3;
        }
    </style>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">
                @lang('admin/translations.translations-list', ['group' => $selectedGroup])
            </h4>
            <div class="float-right">
                <div class="btn-group">
                    <a href="{{ route('admin.translations.refresh', ['filter-group' => $selectedGroup ])}}"
                       class="my-1 btn btn-success">@lang('admin/translations.refresh-button')</a>
                </div>
            </div>
        </div>
        <br/>
        <div class="card-body">
            <div class="container">
                <div class="row my-2 ">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="table">
                            <thead>
                            <tr class="filters">
                                <th>@lang('admin/translations.headers.key')</th>
                                @foreach (($locales = config('app.locales')) as $locale)
                                    <th>{{ $locale }}</th>
                                @endforeach
                            </tr>
                            </thead>
                            <tbody>
                            @if(!empty($translations))
                                @foreach($translations as $translation)
                                    <tr>
                                        <td>
                                            {{ $translation->key }}
                                            @if(!isset($translation->id))
                                                <form action="{{ route('admin.translations.store') }}"  onSubmit="return convert('#filter{{ \Illuminate\Support\Str::slug($translation->group.$translation->key) }}')" method="POST">
                                                    @csrf
                                                    <input type="hidden" value="{{ $translation->key }}" name="key"/>
                                                    <input type="hidden" value="{{ $translation->group }}"
                                                           name="group"/>
                                                    <input type="hidden" value="" id="filter{{ \Illuminate\Support\Str::slug($translation->group.$translation->key) }}"
                                                           name="filter-group"/>
                                                    @foreach (($locales = config('app.locales')) as $locale)
                                                        @if(array_key_exists($locale, $translation->text))
                                                        <input type="hidden" value="{{ $translation->text[$locale] }}"
                                                               name="text[{{ $locale }}]"/>
                                                        @endif
                                                    @endforeach
                                                    <button type="submit"
                                                            class="btn btn-dark">@lang('admin/translations.convert')</button>
                                                </form>
                                            @endif
                                        </td>
                                        @foreach (($locales = config('app.locales')) as $locale)
                                            @if(!isset($translation->id))
                                                <td data-search=" @if(array_key_exists($locale, $translation->text)){{ $translation->text[$locale] }}@endif">
                                                    @if(array_key_exists($locale, $translation->text))
                                                    {{ $translation->text[$locale] }}
                                                    @else
                                                        @lang('admin/translations.notsetyet');
                                                    @endif
                                                </td>
                                            @else
                                                <td data-search="{{ array_key_exists($locale, $translation->text) ? $translation->text[$locale] : '' }}">
                                                    <form action="{{ route('admin.translations.update', [$translation->id]) }}"
                                                          onSubmit="return convert('#filterupdate{{ \Illuminate\Support\Str::slug($translation->group.$translation->key) }}')"
                                                          method="POST">
                                                        @csrf
                                                        <input type="hidden" value="PUT" name="_method"/>
                                                        <input type="hidden" value="{{ $translation->key }}"
                                                               name="key"/>
                                                        <input type="hidden" value="{{ $translation->group }}"
                                                               name="group"/>
                                                        <input type="hidden" value="" id="filterupdate{{ \Illuminate\Support\Str::slug($translation->group.$translation->key) }}"
                                                               name="filter-group"/>
                                                        <input type="hidden" value="{{ $locale }}" name="locale"/>
                                                        <input type="text" name="{{$translation->key}}[{{$locale}}]"
                                                               class="form-control atxupdatelang atxinputaslink"
                                                               value="{{ array_key_exists($locale, $translation->text) ? $translation->text[$locale] : '' }}" />
                                                    </form>
                                                </td>
                                            @endif
                                        @endforeach
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
    <div id="translationselector" style="display: none;">
        <div class="input-group">
            <select class="custom-select" id="group-select">
                <option value="" >@lang('admin/translations.select-all-group')</option>
                @foreach($groups as $group)
                    @if(count($groups))
                        <option value="{{ $group }}"
                                @if(isset($selectedGroup) && $group == $selectedGroup) selected @endif>{{ $group }}</option>

                    @endif
                @endforeach
            </select>
        </div>
    </div>
@stop

@section('footer_scripts')
    <script type="text/javascript" src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/dataTables.bootstrap4.min.js') }}"></script>

    <script>
        function convert(id)
        {
            let group = document.getElementById('group-select').value;
            $(id).val(group);
        }
        $(document).ready(function () {

            $('#table').DataTable({
                stateSave: true,
                iDisplayLength: 50,
                language: {
                    url: '{{ asset('js/dataTables/'.App::getLocale().'.json') }}'
                },
                dom: '<"btn-toolbar">frtip',
                fnInitComplete: function () {
                    $('div.btn-toolbar').html($('#translationselector').html());

                    $('#group-select').on('change', function() {
                        let group = document.getElementById('group-select').value;
                        window.location.search = `filter-group=${group}`;
                    });
                }
            });

            $('input.atxupdatelang').on('focusout', function(e){
                $(this).removeClass('atxinputshow').addClass('atxinputaslink');
            });

            $('input.atxupdatelang').on('focusin', function(e){
                $(this).removeClass('atxinputaslink').addClass('atxinputshow');
            });
        });


    </script>
@stop