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
            <h1 class="cms-title"><?php echo $seo->title; ?></h1>
            <section class="cms-section">
                @yield('content')
            </section>
        </div>
    </div>

    @include('partials.generic-scripts')
    @stack('js')
</body>

</html>
