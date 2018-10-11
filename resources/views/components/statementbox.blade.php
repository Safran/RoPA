<section class="{{ $type }}-declarations">
    <h2>@lang('statements.widgets.'.$type.'.title')</h2>
    <p>@lang('statements.widgets.'.$type.'.disclaimer')</p>
    <div class="declarations-items">
        @foreach($datas as $k => $data)
            <a href="{{ route('frontend.statements.edit', [$data]) }}" class="declaration-component" style="background-color: {{ \App\Models\Statement::color($type, $k) }}">
                <ul>
                    @if($data->get('date'))<li>{{ $data->get('date')->formatLocalized("%x") }}</li>@endif
                    @if($data->get('main_country'))<li>{{ $data->get('main_country')->name }}</li>@endif
                    @if($data->get('company'))<li>{{ $data->get('company')->name }}</li>@endif
                    @if($data->get('name'))<li class="title bold">{{ $data->get('name') }}</li>@endif
                </ul>
                @if(!isset($hasProgressBar) || $hasProgressBar)
                    <progress-bar progress-value="{{ $data->progress['global'] }}" ></progress-bar>
                @endif
            </a>
        @endforeach

        @for($i = 0; $i < 4 - $datas->count(); $i++)
            <div class="declarations-items__placeholder"></div>
        @endfor
    </div>
    @if($showmorelink)
    <div class="declarations-see-more">
        <div class="plus">
            <span class="plus-line-1 plus-line"></span>
            <span class="plus-line-2 plus-line"></span>
            <span></span>
        </div>
        <a href="{{ route('frontend.statements.'.$route) }}">@lang('locale.welcome.see-all-'.$type)</a>
    </div>
    @endif
</section>