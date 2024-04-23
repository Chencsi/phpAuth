<?php

use App\User\Login;

?>

<div class="w-screen sm:w-[700px] md:w-[800px] lg:w-[1000px] h-fit px-14 py-14 bg-slate-500 block mx-auto drop-shadow lg:scale-125">
    <div class="flex flex-col sm:grid sm:grid-cols-2 lg:grid-cols-3 gap-3">
        <div class="bg-slate-400 flex items-center">
            <p class="w-full text-center p-5 text-2xl">Felhasználónév:</p>
        </div>
        <div class="bg-slate-400 flex items-center">
            <p class="w-full text-center p-5 text-2xl"><?= Login::getUserFromToken($_SESSION["token"])["username"]; ?></p>
        </div>

        <div class="col-span-2 lg:col-auto bg-blue-600 hover:bg-blue-700 transition duration-200 cursor-pointer flex items-center">
            <form action="/" method="post" class="w-full text-center">
                <input type="submit" name="logout" value="Kijelentkezés" class="p-5 text-2xl w-full">
            </form>
        </div>

        <div class="col-span-2 lg:col-span-3 bg-slate-400 h-full">
            <h1 class="text-center text-5xl font-extrabold py-5">Hírek</h1>
            <div class="p-5">
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Sint autem itaque nesciunt quam aliquam id sunt laudantium eos quis libero, fuga, accusantium obcaecati corrupti facere doloremque temporibus voluptatum quidem voluptas?</p>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Eum soluta sint neque odit rerum vitae quisquam repellendus facilis, distinctio quod magnam, dolor necessitatibus hic, itaque modi sed nihil ab commodi!</p>
            </div>
        </div>
    </div>

</div>