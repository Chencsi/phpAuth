<?php

require __DIR__ . '/vendor/autoload.php';

$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();

$request_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

?>

<!DOCTYPE html>
<html lang="hu">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auth</title>
    <link rel="stylesheet" href="/assets/styles/style-tailwind.css">
</head>

<body>
    <main>
        <?php
        switch ($request_path) {
            case '/':
                require __DIR__ . '/dashboard.php';
                break;
            case '/login':
                require __DIR__ . '/login.php';
                break;
            case '/register':
                require __DIR__ . '/register.php';
                break;
            default:
                require __DIR__ . '/assets/views/404.php';
                break;
        }
        ?>
    </main>
</body>

</html>