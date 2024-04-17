<aside class="admin-sidebar @if ($_COOKIE['PHPTOGGLESIDEBAR'] === '1') minimize @endif">
    <div class="admin-sidebar-logo">
        <img src="{{ assets('/images/logo-transparent.png') }}" alt="Logo">
        <h2>Admin CMS</h2>
    </div>
    <div class="admin-sidebar-list">
        @foreach ($features as $feature)
            <a href="{{ $feature->url }}" class="admin-sidebar-list-item @if ($feature->isActive()) active @endif"
                title="{{ trans($feature->i18nKey) }}">
                <i class="{{ $feature->bsIcon }}"></i>
                <span>{{ trans($feature->i18nKey) }}</span>
            </a>
        @endforeach
        <form action="/logout.html" method="post">
            {!! Src\Configs\Csrf::input() !!}
            <input type="hidden" name="callbackUrl" value="/admin/login.html">
            <button type="submit" class="admin-sidebar-list-item" title="{{ trans('logout') }}">
                <i class="bi bi-box-arrow-right"></i>
                <span>{{ trans('logout') }}</span>
            </button>
        </form>
    </div>
    <button id="sidebar-toggle-width-button" title="{{ trans('toggle_sidebar_tooltip') }}"
        data-hide-icon="bi bi-chevron-bar-left" data-show-icon="bi bi-chevron-bar-right">
        @if ($_COOKIE['PHPTOGGLESIDEBAR'] === '1')
            <i class="bi bi-chevron-bar-right"></i>
        @else
            <i class="bi bi-chevron-bar-left"></i>
        @endif
    </button>
</aside>
