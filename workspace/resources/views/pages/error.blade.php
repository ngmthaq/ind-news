<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $message }}</title>
    <style>
        * {
            padding: 0;
            margin: 0;
            font-family: sans-serif;
        }

        body {
            width: 100vw;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            background: #212529;
        }

        section {
            padding: 16px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            max-width: 600px;
        }

        div {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 32px;
        }

        h1 {
            color: #dc3545;
            margin: 0;
            padding-right: 16px;
            margin-right: 16px;
            border-right: 1px solid #dc3545;
            display: inline-block;
            font-weight: 400;
            font-size: 32px;
        }

        p {
            margin: 0;
            color: #f8f9fa;
            font-size: 16px;
        }

        span {
            width: 100%;
            display: block;
        }

        a {
            color: #0d6efd;
        }
    </style>
</head>

<body>
    <section>
        <div>
            <h1>{{ $code }}</h1>
            <p>{{ $message }}</p>
        </div>
        @if ($code !== 503 && $code !== 429)
            <span>
                <a href="/">&#8629; {{ trans('back_to_homepage') }}</a>
            </span>
        @endif
    </section>

    @if (isProd() === false)
        <script>
            console.error("Error: {!! $message !!} ({!! $code !!})");
            console.error(JSON.parse("{!! json_encode($details) !!}"));
        </script>
    @endif
</body>

</html>
