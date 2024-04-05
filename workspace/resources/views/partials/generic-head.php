<!-- HTML normal head tags -->
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="theme-color" content="#ffffff" />
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" type="text/css">

<!-- PHP XCSRF Handler -->
<?php echo Src\Configs\Csrf::meta() ?>

<?php if (isset($seo)) : ?>
    <!-- SEO Title Handler -->
    <title><?php echo $seo->title ?></title>

    <!-- SEO Icon Handler -->
    <link rel="icon" href="<?php echo assets("/images/favicon.ico") ?>" type="image/x-icon">
    <link rel="shortcut icon" href="<?php echo assets("/images/favicon.ico") ?>" type="image/x-icon">
    <link rel="apple-touch-icon" href="<?php echo assets("/images/logo-transparent.png") ?>" sizes="180x180">

    <!-- SEO URL Handler -->
    <?php if ($seo->url !== "") : ?>
        <link rel="canonical" href="<?php echo $seo->url ?>" />
        <meta property="og:url" content="<?php echo $seo->url ?>" />
        <meta property="og:site_name" content="<?php echo $seo->url ?>" />
        <meta property="twitter:url" content="<?php echo $seo->url ?>" />
    <?php endif; ?>

    <!-- SEO Description Handler -->
    <?php if ($seo->description !== "") : ?>
        <meta http-equiv="audience" content="General" />
        <meta http-equiv="content-language" content="vi" />
        <meta name="resource-type" content="Document" />
        <meta name="distribution" content="Global" />
        <meta name="revisit-after" content="1 days" />
        <meta property="og:type" content="website" />
        <meta name="description" content="<?php echo $seo->description ?>" />
        <meta property="og:description" content="<?php echo $seo->description ?>" />
        <meta property="twitter:description" content="<?php echo $seo->description ?>" />
        <meta name="title" content="<?php echo $seo->title ?>" />
        <meta property="og:title" content="<?php echo $seo->title ?>" />
        <meta property="twitter:title" content="<?php echo $seo->title ?>" />
    <?php endif; ?>

    <!-- SEO Keywords Handler -->
    <?php if ($seo->keywords !== "") : ?>
        <meta name="keywords" content="<?php echo $seo->keywords ?>" />
    <?php endif; ?>

    <!-- SEO Image Handler -->
    <?php if ($seo->image !== "") : ?>
        <meta name="image" content="<?php echo $seo->image ?>" />
        <meta property="og:image" content="<?php echo $seo->image ?>" />
        <meta property="twitter:card" content="summary_large_image" />
        <meta property="twitter:image" content="<?php echo $seo->image ?>" />
    <?php endif; ?>
<?php endif; ?>