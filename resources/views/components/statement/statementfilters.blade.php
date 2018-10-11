@can('filterbystatements', \App\Models\Statement::class)
    <div class="filters-group__item">
        {{ bs()->formGroup(bs()->select('statements', ['' => __('statements.select-all-statements'), '1' => __('statements.select-only-mine')], request()->get('statements', 1))->attribute('onChange', 'this.form.submit()'))->label(__('statements.filters.ownerfilter')) }}
    </div>
@endcan

@if($type == 'finished')
    <div class="filters-group__item">
        @can('filterbystatus', \App\Models\Statement::class)
            {{ bs()->formGroup(bs()->select('status', ['' => __('statements.select-all-status'), '1' => __('statements.select-only-archived'), '2' => __('statements.select-only-validated')], request()->get('status'))->attribute('onChange', 'this.form.submit()'))->label(__('statements.filters.statusfilter')) }}
        @endcan
    </div>
@endif

@can('filterbycompany', \App\Models\Statement::class)
    <div class="filters-group__item">
        {{ bs()->formGroup(bs()->select('company_id', $companies->prepend(__('statements.select-all-companies'), ''), request()->get('company_id'))->attribute('onChange', 'this.form.submit()'))->label(__('statements.filters.companyfilter')) }}
    </div>
@endcan

<div class="filters-group__item">
    {{ bs()->formGroup(bs()->select('country_id', $countries->prepend(__('statements.select-all-countries'), ''), request()->get('country_id'))->attribute('onChange', 'this.form.submit()'))->label(__('statements.filters.countryfilter')) }}
</div>

@can('manage', \App\Models\Statement::class)
    <div class="filters-group__item filters-group__small">
        <a href="{{ route('frontend.statements.csv', ['type' => $type]) }}">
            <img src="{{ asset('images/filters/export.svg') }}" alt="Export">
        </a>
    </div>
@endcan