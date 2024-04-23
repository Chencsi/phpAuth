<?php

use App\User\Login;

?>
<div class="max-w-[350px] px-14 py-14 bg-slate-500 block mx-auto drop-shadow sm:scale-125">
    <form action="" method="post" class="flex flex-col gap-5">

        <h1 class="text-center font-extrabold text-3xl sm:text-4xl drop-shadow mb-3">Novin Auth</h1>

        <div class="flex flex-col gap-1">
            <label for="username">Felhasználónév</label>
            <input type="text" name="username" class="bg-slate-400 outline-none px-2 py-1">
        </div>

        <div class="flex flex-col gap-1">
            <label for="password">Jelszó</label>
            <input type="password" name="password" class="bg-slate-400 outline-none px-2 py-1">
        </div>

        <div class="flex flex-row gap-3">
            <button type="submit"
                class="block w-full bg-blue-800 hover:bg-blue-900 transition duration-200">Belépés</button>
            <a href="/register"
                class="block w-full bg-slate-400 text-center py-1 hover:bg-slate-200 hover:text-slate-600 transition duration-200">Regisztráció</a>
        </div>

        <div>
            <?php if (isset($login)): ?>
                <p><?= $login->success ?></p>
            <?php endif; ?>
            <?php if (isset($login)): ?>
                <p><?= $login->error ?></p>
            <?php endif; ?>
        </div>
    </form>
</div>