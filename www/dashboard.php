<?php

if ($request_path === "/") {
    if (!isset($_SESSION['token'])) {
        header("Location: /login");
    }
}
