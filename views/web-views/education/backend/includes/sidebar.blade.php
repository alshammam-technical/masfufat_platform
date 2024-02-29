<aside class="vironeer-sidebar">
    <div class="overlay"></div>
    <div class="vironeer-sidebar-header">
        <a href="{{ route('admin.dashboard') }}" class="vironeer-sidebar-logo">
            <img src="{{ asset($settings['website_light_logo']) }}" alt="{{ $settings['website_name'] }}" />
        </a>
    </div>
    <div class="vironeer-sidebar-menu" data-simplebar>
        <div class="vironeer-sidebar-links">
            <p class="vironeer-sidebar-links-title mb-0">{{ __('General') }}</p>
            <div class="vironeer-sidebar-links-cont">
                <a href="{{ route('admin.dashboard') }}" class="vironeer-sidebar-link @if (request()->segment(2) == 'dashboard') current @endif">
                    <p class="vironeer-sidebar-link-title">
                        <span><i class="fas fa-th-large"></i>{{ __('Dashboard') }}</span>
                    </p>
                </a>
                <a href="{{ route('users.index') }}" class="vironeer-sidebar-link @if (request()->segment(2) == 'users') current @endif">
                    <p class="vironeer-sidebar-link-title">
                        <span><i class="fa fa-users"></i>{{ __('Manage Users') }}</span>
                    </p>
                </a>
                <a href="{{ route('tickets.index') }}" class="vironeer-sidebar-link @if (request()->routeIs('tickets.*')) current @endif">
                    <p class="vironeer-sidebar-link-title">
                        <span><i class="fas fa-headset"></i>{{ __('Tickets') }}</span><span
                            class="counter @if ($ticketsNeedsAction > 0) bg-warning text-dark @else bg-light text-dark @endif">{{ $ticketsNeedsAction }}</span>
                    </p>
                </a>
            </div>
        </div>

        <div class="vironeer-sidebar-links">
            <p class="vironeer-sidebar-links-title mb-0">{{ __('Application') }}</p>
            <div class="vironeer-sidebar-links-cont">
                <div class="vironeer-sidebar-link @if (request()->segment(3) == 'navbarMenu' or request()->segment(3) == 'footerMenu') active @endif" data-dropdown>
                    <p class="vironeer-sidebar-link-title">
                        <span><i class="fas fa-bars"></i>{{ __('Navigation') }}</span>
                        <span class="arrow"><i class="fas fa-chevron-right fa-sm"></i></span>
                    </p>
                    <div class="vironeer-sidebar-link-menu">
                        <a href="{{ route('admin.footerMenu.index') }}"
                            class="vironeer-sidebar-link @if (request()->segment(3) == 'footerMenu') current @endif">
                            <p class="vironeer-sidebar-link-title"><span>{{ __('Footer Menu') }}</span></p>
                        </a>
                    </div>
                </div>
                <div class="vironeer-sidebar-link  @if (request()->segment(3) == 'articles' or request()->segment(3) == 'categories') active @endif" data-dropdown>
                    <p class="vironeer-sidebar-link-title">
                        <span><i class="far fa-life-ring"></i>{{ __('HelpDesk') }}</span>
                        <span class="arrow"><i class="fas fa-chevron-right fa-sm"></i></span>
                    </p>
                    <div class="vironeer-sidebar-link-menu">
                        <a href="{{ route('articles.index') }}"
                            class="vironeer-sidebar-link @if (request()->segment(3) == 'articles') current @endif">
                            <p class="vironeer-sidebar-link-title"><span>{{ __('Articles') }}</span></p>
                        </a>
                        <a href="{{ route('categories.index') }}"
                            class="vironeer-sidebar-link @if (request()->segment(3) == 'categories') current @endif">
                            <p class="vironeer-sidebar-link-title"><span>{{ __('Categories') }}</span></p>
                        </a>
                    </div>
                </div>
                <a href="{{ route('admin.settings') }}" class="vironeer-sidebar-link @if (request()->segment(2) == 'settings') current @endif">
                    <p class="vironeer-sidebar-link-title">
                        <span><i class="fa fa-cog"></i>{{ __('Settings') }}</span>
                    </p>
                </a>
            </div>
        </div>

        <div class="vironeer-sidebar-links">
            <p class="vironeer-sidebar-links-title mb-0">{{ __('Additional') }}</p>
            <div class="vironeer-sidebar-links-cont">
                <a href="{{ route('admin.additional.notice') }}"
                    class="vironeer-sidebar-link @if (request()->segment(3) == 'popup-notice') current @endif">
                    <p class="vironeer-sidebar-link-title"><i
                            class="far fa-window-restore"></i><span>{{ __('PopUp Notice') }}</span></p>
                </a>
                <a href="{{ route('admin.additional.css') }}"
                    class="vironeer-sidebar-link @if (request()->segment(3) == 'custom-css') current @endif">
                    <p class="vironeer-sidebar-link-title"><i
                            class="fab fa-css3"></i><span>{{ __('Custom CSS') }}</span></p>
                </a>
                <a href="{{ route('admin.additional.cache') }}" class="vironeer-link-confirm vironeer-sidebar-link">
                    <p class="vironeer-sidebar-link-title"><i
                            class="far fa-trash-alt"></i><span>{{ __('Clear Cache') }}</span></p>
                </a>
            </div>
        </div>
    </div>
</aside>
