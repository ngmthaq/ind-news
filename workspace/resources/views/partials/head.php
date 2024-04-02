<head>
    <!-- HTML normal head tags -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="audience" content="General" />
    <meta http-equiv="content-language" content="vi" />
    <meta name="resource-type" content="Document" />
    <meta name="distribution" content="Global" />
    <meta name="revisit-after" content="1 days" />
    <meta name="theme-color" content="#0d6efd" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap">

    <!-- PHP Handler -->
    <?php echo Src\Configs\Csrf::meta() ?>

    <!-- PHP SEO Handler -->
    <title><?php echo $title ?></title>
    <link rel="icon" href="<?php echo assets("/images/favicon.ico") ?>" type="image/x-icon">
    <link rel="shortcut icon" href="<?php echo assets("/images/favicon.ico") ?>" type="image/x-icon">
    <link rel="shortcut icon" href="<?php echo assets("/images/logo-transparent.png") ?>" sizes="180x180">
    <link rel="canonical" href="%REACT_APP_SEO_URL%" />
    <meta name="title" content="%REACT_APP_SEO_TITLE%" />
    <meta name="description" content="%REACT_APP_SEO_DESCRIPTION%" />
    <meta name="image" content="%REACT_APP_SEO_IMAGE%" />
    <meta name="author" content="%REACT_APP_SEO_AUTHOR%" />
    <meta name="copyright" content="%REACT_APP_SEO_AUTHOR%" />
    <meta name="keywords" content="%REACT_APP_SEO_KEYWORDS%" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="%REACT_APP_SEO_URL%" />
    <meta property="og:site_name" content="%REACT_APP_SEO_URL%" />
    <meta property="og:title" content="%REACT_APP_SEO_TITLE%" />
    <meta property="og:description" content="%REACT_APP_SEO_DESCRIPTION%" />
    <meta property="og:image" content="%REACT_APP_SEO_IMAGE%" />
    <meta property="og:image:alt" content="%REACT_APP_SEO_TITLE%" />
    <meta property="og:image:type" content="image/png" />
    <meta property="og:image:width" content="600" />
    <meta property="og:image:height" content="315" />
    <meta property="twitter:card" content="summary_large_image" />
    <meta property="twitter:url" content="%REACT_APP_SEO_URL%" />
    <meta property="twitter:title" content="%REACT_APP_SEO_TITLE%" />
    <meta property="twitter:description" content="%REACT_APP_SEO_DESCRIPTION%" />
    <meta property="twitter:image" content="%REACT_APP_SEO_IMAGE%" />
</head>