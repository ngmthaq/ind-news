<head>
    <!-- HTML normal head tags -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#0d6efd" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap">

    <!-- PHP Handler -->
    <?php echo Src\Configs\Csrf::meta() ?>

    <!-- SEO Handler -->
    <title><?php echo $seo->title ?></title>
    <link rel="icon" href="<?php echo assets("/images/favicon.ico") ?>" type="image/x-icon">
    <link rel="shortcut icon" href="<?php echo assets("/images/favicon.ico") ?>" type="image/x-icon">
    <link rel="shortcut icon" href="<?php echo assets("/images/logo-transparent.png") ?>" sizes="180x180">
    <link rel="canonical" href="<?php echo $seo->url ?>" />
    <meta http-equiv="audience" content="General" />
    <meta http-equiv="content-language" content="vi" />
    <meta name="resource-type" content="Document" />
    <meta name="distribution" content="Global" />
    <meta name="revisit-after" content="1 days" />
    <meta name="title" content="<?php echo $seo->title ?>" />
    <meta name="description" content="<?php echo $seo->description ?>" />
    <meta name="image" content="<?php echo $seo->image ?>" />
    <meta name="keywords" content="<?php echo $seo->keywords ?>" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="<?php echo $seo->url ?>" />
    <meta property="og:site_name" content="<?php echo $seo->url ?>" />
    <meta property="og:title" content="<?php echo $seo->title ?>" />
    <meta property="og:description" content="<?php echo $seo->description ?>" />
    <meta property="og:image" content="<?php echo $seo->image ?>" />
    <meta property="twitter:card" content="summary_large_image" />
    <meta property="twitter:url" content="<?php echo $seo->url ?>" />
    <meta property="twitter:title" content="<?php echo $seo->title ?>" />
    <meta property="twitter:description" content="<?php echo $seo->description ?>" />
    <meta property="twitter:image" content="<?php echo $seo->image ?>" />
</head>