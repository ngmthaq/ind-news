<!-- HTML normal head tags -->
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="theme-color" content="#ffffff" />
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="stylesheet"
    href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
    type="text/css">

@if (isset($seo))
    <!-- SEO Title Handler -->
    <title>{{ $seo->title }}</title>

    <!-- SEO Icon Handler -->
    <link rel="icon" href="{{ assets('/images/favicon.ico') }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ assets('/images/favicon.ico') }}" type="image/x-icon">
    <link rel="apple-touch-icon" href="{{ assets('/images/logo-transparent.png') }}" sizes="180x180">

    <!-- SEO URL Handler -->
    @if ($seo->url !== '')
        <link rel="canonical" href="{{ $seo->url }}" />
        <meta property="og:url" content="{{ $seo->url }}" />
        <meta property="og:site_name" content="{{ $seo->url }}" />
        <meta property="twitter:url" content="{{ $seo->url }}" />
    @endif

    <!-- SEO Description Handler -->
    @if ($seo->description !== '')
        <meta http-equiv="audience" content="General" />
        <meta http-equiv="content-language" content="vi" />
        <meta name="resource-type" content="Document" />
        <meta name="distribution" content="Global" />
        <meta name="revisit-after" content="1 days" />
        <meta property="og:type" content="website" />
        <meta name="description" content="{{ $seo->description }}" />
        <meta property="og:description" content="{{ $seo->description }}" />
        <meta property="twitter:description" content="{{ $seo->description }}" />
        <meta name="title" content="{{ $seo->title }}" />
        <meta property="og:title" content="{{ $seo->title }}" />
        <meta property="twitter:title" content="{{ $seo->title }}" />
    @endif

    <!-- SEO Keywords Handler -->
    @if ($seo->keywords !== '')
        <meta name="keywords" content="{{ $seo->keywords }}" />
    @endif

    <!-- SEO Image Handler -->
    @if ($seo->image !== '')
        <meta name="image" content="{{ $seo->image }}" />
        <meta property="og:image" content="{{ $seo->image }}" />
        <meta property="twitter:image" content="{{ $seo->image }}" />
        <meta property="twitter:card" content="summary_large_image" />
    @endif
@endif
