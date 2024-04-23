<?php

use App\User\Login;
?>
<?php
    if (isset($_SESSION["token"])) {
        echo "token: " . $_SESSION["token"] ."<br>";
    }
?>
<form action="" method="post">

    <label for="username">username:</label>
    <input type="text" name="username">

    <label for="password">password:</label>
    <input type="password" name="password">

    <button type="submit">login</button>
</form>
<?php if (isset($login)) : ?>
    <p><?= $login->error ?></p>
<?php endif; ?>