<!DOCTYPE html>
<html lang="{{ getLangCode() }}">

<head>
    @include('partials.generic-head', compact('seo'))
    @stack('head')
</head>

<body data-bs-theme={{ $_COOKIE['PHPTHEME'] ?? 'light' }}>
    @yield('content')
    @include('partials.generic-scripts')
    @stack('js')
</body>

</html>
