<div class="header-menu" :class="enableShadow ? 'shadow' : ''">
    <div class="header-menu__content  header-menu__desktop">
        <a href="{{ route('admin.dashboard') }}">
            <img class="logo" src="{{ asset('images/general/logo.svg') }}"
                 alt="@lang('locale.logo_alt')">
        </a>
        <ul class="header-menu__links">
            @can('manage', \App\Models\Form::class)
                <li class="">
                    <a class="{!! (isActiveUrl('admin/forms') ? ' active' : '') !!}"
                       href="{{ route('admin.forms') }}">
                        @lang('admin/forms.title')
                    </a>
                </li>
            @endcan
            @can('manage', \App\Models\User::class)
                <li class="">
                    <a class="{!! (isActiveUrl('admin/users') ? ' active' : '') !!}"
                       href="{{ route('admin.users') }}">
                        @lang('admin/users.title')
                    </a>
                </li>
            @endcan
                @can('manage', \App\Models\Company::class)
                    <li class="">
                        <a class="{!! (isActiveUrl('admin/companies') ? ' active' : '') !!}"
                           href="{{ route('admin.companies') }}">
                            @lang('admin/companies.title')
                        </a>
                    </li>
                @endcan
            @can('manage', \App\Models\Staticpage::class)
                <li class="">
                    <a class="{!! (isActiveUrl('admin/staticpages') ? ' active' : '') !!}"
                       href="{{ route('admin.staticpages') }}">
                        @lang('admin/staticpages.title')
                    </a>
                </li>
            @endcan
            @can('manage', \App\Models\Menu::class)
                <li class="">
                    <a class="{!! (isActiveUrl('admin/menus') ? ' active' : '') !!}"
                       href="{{ route('admin.menus') }}">
                        @lang('admin/menus.title')
                    </a>
                </li>
            @endcan
            @can('manage', \App\Models\Translation::class)
                <li class="">
                    <a class="{!! (isActiveUrl('admin/translations') ? ' active' : '') !!}"
                       href="{{ route('admin.translations') }}">
                        @lang('admin/translations.title')
                    </a>
                </li>
            @endcan
            @can('manage', \App\Models\Setting::class)
                <li class=" ">
                    <a class="{!! (isActiveUrl('admin/settings') ? ' active' : '') !!}"
                       href="{{ route('admin.settings') }}"><img
                                src="{{ asset('images/menu/settings.png') }}" alt="@lang('admin/settings.title')"></a>
                </li>
            @endcan
            <li class=" ">
                <a class="" href="{{ URL::route('frontend.home') }}" target="_blank"><img
                            src="{{ asset('images/menu/website.png') }}" alt="@lang('locale.site')"></a>
            </li>
            <li class=" ">
                <a class="" href="{{ URL::route('logout') }}"><img src="{{ asset('images/menu/logout.svg') }}"
                                                                   alt="@lang('locale.logout')"></a>
            </li>
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