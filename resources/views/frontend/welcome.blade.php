@extends('layouts.frontend')

@section('title')
    @lang('locale.welcome.page-title') @parent
@stop

@section('pageclass', 'home-page container')

@section('content')
    <section class="welcome-content">
        <div class="welcome-content-item welcome-content-image">
            <img v-if="getTablet" src="{{ Config::get('settings.home_picture_pad') }}"
                 alt="@lang('locale.home_pict_alt')">
            <img v-else src="{{ Config::get('settings.home_picture_desktop') }}" alt="@lang('locale.home_pict_alt')">
        </div>
        <div class="welcome-content-item welcome-content-text">
            <h1>@lang('locale.welcome.title', ['name' => auth()->user()->fullname])</h1>
            <p>@lang('locale.welcome.introduction')</p>

            <a href="{{ auth()->user()->seenDisclaimer ? route('frontend.statements.create'): route('frontend.statements.disclaimer') }}"
               class="btn-primary">@lang('locale.welcome.start-button')</a>
        </div>
    </section>
    @can('manage', \App\Models\Statement::class)
        @if($pendings->isNotEmpty())
            @statementbox(['type' => 'pending', 'route' => 'pendings', 'datas' => $pendings, 'hasProgressBar' => false, 'showmorelink' => $pendingsshowmorelink])
            @endstatementbox
        @endif
    @endcan
    @if($inprogress->isNotEmpty())
        @statementbox(['type' => 'inprogress', 'route' => 'inprogress', 'datas' => $inprogress, 'showmorelink' => $inprogressshowmorelink])
        @endstatementbox
    @endif
    @if($finished->isNotEmpty())
    @statementtable(['type' => 'history', 'datas' => $finished, 'hasProgressBar' => false, 'companies' => $companies, 'countries' => $countries])
    @endstatementtable
    @endif
@stop

