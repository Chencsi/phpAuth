<?php

use App\User\Login;

?>

<p>username: <?= json_encode(Login::getUserFromToken($_SESSION["token"])["username"]); ?></p>
<p>session token: <?= $_SESSION["token"] ?></p>

<form action="/" method="post">
    <input type="submit" name="logout" value="Kijelentkezés">
</form>