<div class="no-content">
    <div class="no-content__text">
        <p>@lang('statements.'.$type.'.empty')</p>
        <a href="{{ route('frontend.statements.disclaimer') }}">@lang('statements.'.$type.'.learn-more')</a>
    </div>

    <div class="no-content__images">
        <img class="cloud cloud-1 cloud-s" src="{{ asset('images/general/cloud.svg')}}" alt="@lang('locale.cloud_alt')">
        <img class="cloud cloud-2 cloud-m" src="{{ asset('images/general/cloud.svg')}}" alt="@lang('locale.cloud_alt')">
        <img class="cloud cloud-3 cloud-s" src="{{ asset('images/general/cloud.svg')}}" alt="@lang('locale.cloud_alt')">
        <img class="cloud cloud-4 cloud-s" src="{{ asset('images/general/cloud.svg')}}" alt="@lang('locale.cloud_alt')">
        <img class="cloud cloud-5 cloud-l" src="{{ asset('images/general/cloud.svg')}}" alt="@lang('locale.cloud_alt')">
        <img class="plane" src="{{ asset('images/general/plane.svg')}}" alt="@lang('locale.plane_alt')">
    </div>
</div>