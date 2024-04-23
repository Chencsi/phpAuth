<form action="" method="post">

    <label for="username">username:</label>
    <input type="text" name="username">

    <label for="email">email:</label>
    <input type="email" name="email">

    <label for="password">password:</label>
    <input type="password" name="password">

    <button type="submit">register</button>

    <?php if (isset($register)): ?>
        <p><?= $register->success ?></p>
    <?php endif; ?>
    <?php if (isset($register)): ?>
        <p><?= $register->error ?></p>
    <?php endif; ?>
</form>