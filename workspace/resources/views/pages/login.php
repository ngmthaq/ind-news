<!DOCTYPE html>
<html lang="vi">

<head>
    <?php partial("generic-head.php", compact("seo")) ?>
</head>

<body>
    <form method="post" class="login-form">
        <?php echo Src\Configs\Csrf::input() ?>
        <div class="logo-container">
            <img src="<?php echo assets("/images/logo-transparent.png") ?>" alt="Logo">
        </div>
        <div class="form-container">
            <div class="mb-4">
                <h2 class="text-center"><?php echo trans("cms_title") ?></h2>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label required"><?php echo trans("email_address") ?></label>
                <input type="text" name="email" id="email" class="form-control" placeholder="name@example.com" value="<?php echo old("email") ?>">
                <small class="text-danger"><?php echo flash("email") ?></small>
            </div>
            <div class="mb-4">
                <label for="password" class="form-label required"><?php echo trans("password") ?></label>
                <div class="input-group">
                    <input type="password" name="password" id="password" class="form-control" placeholder="<?php echo trans("password_placeholder") ?>">
                    <button class="btn btn-outline-secondary" type="button" id="toggle-show-password" data-show="false" data-show-icon="bi bi-eye-fill" data-hide-icon="bi bi-eye-slash-fill">
                        <i class="bi bi-eye-fill"></i>
                    </button>
                </div>
                <small class="text-danger"><?php echo flash("password") ?></small>
            </div>
            <div class="mb-3">
                <button name="login" type="submit" class="btn btn-primary w-100"><?php echo trans("login") ?></button>
            </div>
        </div>
    </form>

    <?php partial("generic-scripts.php") ?>
    <script src="<?php echo assets('/vendor/adminLogin.bundle.js') ?>"></script>
</body>

</html>