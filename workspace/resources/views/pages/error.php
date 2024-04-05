<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $message ?></title>
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
            justify-content: flex-start;
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
        <h1><?php echo $code ?></h1>
        <p><?php echo $message ?></p>
        <?php if ($code !== 503) : ?>
            <a href="/"><?php echo trans("back_to_homepage") ?></a>
        <?php endif ?>
    </div>
    <pre>
        <?php print_r($details) ?>
    </pre>
</body>

</html>