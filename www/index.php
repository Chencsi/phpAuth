<?php

use App\User\Login;
use App\User\Register;

require __DIR__ . "/vendor/autoload.php";

$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();

$dataPath = "data/data.json";

session_start();

if (!file_exists($dataPath)) {
    file_put_contents($dataPath, json_encode([]));
}

$request_path = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
$token = isset($_SESSION["token"]) ? $_SESSION["token"] : null;
$posted_data = $_POST;

if (!empty($posted_data)) {
    if (isset($_POST["logout"])) {
        unset($_SESSION["token"]);
    }
    switch ($request_path){
        case ("/login"):
            $login = new Login($posted_data["username"], $posted_data["password"]);
            header("Location: /dashboard");
            break;
        case ("/register"):
            $register = new Register($posted_data["username"], $posted_data["email"], $posted_data["password"]);
            header("Location: /login");
            break;
    }
}

if ($token !== null) {
    $userFromToken = Login::getUserFromToken($token);
    if ($userFromToken === false) {
        if (in_array($request_path, ["/login", "/register"])) {
            session_destroy();
            header("Location: /login");
        }
    } else {
        if ($request_path !== "/dashboard") {
            header("Location: /dashboard");
        }
    }
} else {
    if (!in_array($request_path, ["/login", "/register"])) {
        header("Location: /login");
    }
}

?>

<!DOCTYPE html>
<html lang="hu">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>index</title>
    <link rel="stylesheet" href="/assets/styles/style-tailwind.css">
</head>

<body>
    <main>
        <?php
        switch ($request_path) {
            case '/dashboard':
                require __DIR__ . '/dashboard.php';
                break;
            case '/login':
                require __DIR__ . '/login.php';
                break;
            case '/register':
                require __DIR__ . '/register.php';
                break;
            default:
                header('Location: /dashboard');
                break;
        }
        ?>
    </main>
</body>

</html>