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
            <section class="cms-section">
                <form id="setting-form" action="/admin/setting/save.html" method="post">
                    <div class="row">
                        <div class="mb-4 col-12 col-sm-12 col-md-12 col-lg-6 col-xl-4">
                            <label for="theme-mode" class="form-label required"><?php echo trans("theme_mode") ?></label>
                            <select class="form-select" id="theme-mode" name="theme">
                                <option value="light"><?php echo trans("light_mode") ?></option>
                                <option value="dark"><?php echo trans("dark_mode") ?></option>
                            </select>
                        </div>
                        <div class="mb-4 col-12 col-sm-12 col-md-12 col-lg-6 col-xl-4">
                            <label for="language" class="form-label required"><?php echo trans("language") ?></label>
                            <select class="form-select" id="language" name="language">
                                <option value="vi">Tiếng Việt</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-4">
                            <label for="seo-title" class="form-label required"><?php echo trans("seo_title") ?></label>
                            <input type="text" class="form-control" id="seo-title" name="title" placeholder="Industry News">
                        </div>
                        <div class="mb-4">
                            <label for="seo-keywords" class="form-label required"><?php echo trans("seo_keywords") ?></label>
                            <input type="text" class="form-control" id="seo-keywords" name="keywords" placeholder="industry, news">
                        </div>
                        <div class="mb-4">
                            <label for="seo-url" class="form-label required"><?php echo trans("seo_url") ?></label>
                            <input type="text" class="form-control" id="seo-url" name="url" placeholder="https://example.com">
                        </div>
                        <div class="mb-4">
                            <label for="seo-file" class="form-label required"><?php echo trans("seo_image") ?></label>
                            <input class="form-control" type="file" id="seo-file" name="file">
                        </div>
                        <div class="mb-4">
                            <label for="seo-desc" class="form-label required"><?php echo trans("seo_description") ?></label>
                            <textarea type="text" class="form-control" id="seo-desc" name="description" placeholder="Industry News Description" rows="6"></textarea>
                        </div>
                        <div class="d-flex align-items-center justify-content-end">
                            <button type="submit" class="btn btn-primary" style="min-width: 160px;">
                                <?php echo trans("save") ?>
                            </button>
                        </div>
                    </div>
                </form>
            </section>
        </div>
    </div>

    <?php partial("generic-scripts.php") ?>
    <script src="<?php echo assets("/vendor/adminDashboard.bundle.js") ?>"></script>
    <script src="<?php echo assets("/vendor/adminSetting.bundle.js") ?>"></script>
</body>

</html>