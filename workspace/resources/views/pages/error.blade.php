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
        }

        div {
            padding: 16px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            max-width: 600px;
        }

        h1 {
            color: red;
            margin-bottom: 16px;
            border-bottom: 2px solid red;
            display: inline-block;
        }

        p {
            margin-bottom: 16px;
        }

        a {
            color: blue;
        }
    </style>
</head>

<body>
    <div>
        <h1>{{ $code }}</h1>
        <p>{{ $message }}</p>
        @if ($code !== 503)
            <a href="/">{{ trans('back_to_homepage') }}</a>
        @endif
    </div>

    @if (isProd() === false)
        <script>
            console.error("Error: {{ $message }} ({{ $code }})");
            console.error(JSON.parse("{{ json_encode($details) }}"));
        </script>
    @endif
</body>

</html>
