{{ bs()->openForm('get', \Request::url(), ['inline' => true]) }}
<div class="declarations-{{$type}}">
    @if(!isset($onlytable) || !$onlytable )
        <h2>@lang('statements.widgets.'.$type.'.title')</h2>
        <p>@lang('statements.widgets.'.$type.'.disclaimer')</p>
    @endif
        <div>
            <statements-component
                    :data="{{ $datas->values()->makeHidden('form')->toJson() }}"
                validated-text="@lang('locale.validated-statement')"
                archived-text="@lang('locale.archived-statement')"
                button-text="@lang('statements.edit-button')">
            @include('components.statement.statementfilters', ['type' => $type])
            <template slot="no-content">
                @include('components.nocontent', ['type' => $type])
            </template>
        </statements-component>
    </div>
</div>
{{bs()->closeForm()}}