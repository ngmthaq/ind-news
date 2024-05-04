<script>
    window.__lang_data = {!! getLangJsonData() !!};
    window.__x_csrf_key = "{!! Src\Configs\Csrf::TOKEN_KEY !!}";
    window.__x_csrf_token = "{!! $_SESSION[Src\Configs\Csrf::TOKEN_KEY] !!}";
</script>

<script src="{{ assets('/vendor/index.bundle.js') }}"></script>
