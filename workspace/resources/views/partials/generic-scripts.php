<script>
    window.__lang_data = <?php echo json_encode(getLangData()) ?>;
    window.__x_csrf_key = "<?php echo Src\Configs\Csrf::TOKEN_KEY ?>";
    window.__x_csrf_token = "<?php echo $_SESSION[Src\Configs\Csrf::TOKEN_KEY] ?>";
</script>

<script src="<?php echo assets('/vendor/index.bundle.js') ?>"></script>