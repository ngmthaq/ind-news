<!DOCTYPE html>
<html lang="{{ getLangCode() }}">

<head>
    @include('partials.generic-head', compact('seo'))
    @stack('head')
</head>

<body data-bs-theme={{ $_COOKIE['PHPTHEME'] ?? 'light' }}>
    <div id="admin-layout">
        @include('partials.admin-sidebar', compact('features'))
        <div class="admin-wrapper">
            <h1 class="cms-title d-flex align-items-center justify-content-between">
                <span><?php echo $seo->title; ?></span>
                <button id="toggle-theme-cms-button"
                    class="btn @if ($_COOKIE['PHPTHEME'] === 'light') btn-dark @else btn-light @endif"
                    title="{{ trans('toggle_theme_tooltip') }}" data-light-icon="bi bi-sun-fill"
                    data-dark-icon="bi bi-moon-fill">
                    @if ($_COOKIE['PHPTHEME'] === 'light')
                        <i class="bi bi-moon-fill"></i>
                    @else
                        <i class="bi bi-sun-fill"></i>
                    @endif
                </button>
            </h1>
            <section class="cms-section">
                @yield('content')
            </section>
            <div class="text-center mt-3">
                <small>Copyright @ngmthaq ©️ 2024 - {{ date('Y') }}</small>
            </div>
        </div>
    </div>

    @include('partials.generic-scripts')
    @stack('js')
</body>

</html>
