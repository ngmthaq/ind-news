<aside class="admin-sidebar">
    <div class="admin-sidebar-logo">
        <img src="<?php echo assets("/images/logo-transparent.png") ?>" alt="Logo">
        <h2>Admin CMS</h2>
    </div>
    <div class="admin-sidebar-list">
        <?php foreach ($features as $feature) : ?>
            <a href="<?php echo $feature->url ?>" class="admin-sidebar-list-item <?php echo $feature->isActive() ? 'active' : '' ?>" title="<?php echo trans($feature->i18nKey) ?>">
                <i class="<?php echo $feature->bsIcon ?>"></i>
                <span><?php echo trans($feature->i18nKey) ?></span>
            </a>
        <?php endforeach; ?>
        <form action="/logout.html" method="post">
            <?php echo Src\Configs\Csrf::input() ?>
            <input type="hidden" name="callbackUrl" value="/admin/login.html">
            <button type="submit" class="admin-sidebar-list-item" title="<?php echo trans("logout") ?>">
                <i class="bi bi-box-arrow-right"></i>
                <span><?php echo trans("logout") ?></span>
            </button>
        </form>
    </div>
    <button id="sidebar-toggle-width-button" data-hide-icon="bi bi-chevron-bar-left" data-show-icon="bi bi-chevron-bar-right">
        <i class="bi bi-chevron-bar-left"></i>
    </button>
</aside>