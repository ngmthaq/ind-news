<!DOCTYPE html>
<html lang="vi">

<head>
    <?php partial("generic-head.php", compact("seo")) ?>
</head>

<body>
    <div id="admin-layout">
        <?php partial("admin-sidebar.php", compact("features")) ?>
        <div class="admin-wrapper">
            <h1 class="cms-title"><?php echo $seo->title ?></h1>
            <section class="cms-section"></section>
        </div>
    </div>

    <?php partial("generic-scripts.php") ?>
    <script src="<?php echo assets("/vendor/adminDashboard.bundle.js") ?>"></script>
</body>

</html>