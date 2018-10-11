<div class="header-menu" :class="enableShadow ? 'shadow' : ''">
    <div class="header-menu__content header-menu__desktop">
        <a href="{{ route('frontend.home') }}">
            <img class="logo" src="{{ asset('images/general/logo.svg') }}"
                 alt="@lang('locale.logo_alt')">
        </a>
        {!!  Menu::render('main-menu', ['class' => 'header-menu__links']) !!}
        <ul class="header-menu__links">
            <li>
                <notifications-component :notifications="{{ $notifications }}"></notifications-component>
            </li>
            @if(! auth()->user()->isSaml )
            <li>
                <a href="{{ route('logout') }}">
                    <img src="{{ asset('images/menu/logout.svg') }}" alt="@lang('locale.logout_alt')">
                </a>
            </li>
            @endif
            <li>
                <select id="langswitch" class="lang-select small text-primary border-primary" onchange="changeLang()">
                    @foreach(locales() as $locale)
                        <option value="{{ getUrlWithSelectedLocale($locale) }}" {{  locale() == $locale ? 'selected' : '' }}>@lang('locale.'.$locale)</option>
                    @endforeach
                </select>
            </li>
        </ul>
    </div>
</div>