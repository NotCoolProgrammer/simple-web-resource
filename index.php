<?php

session_start();

$requestUri = $_SERVER["REQUEST_URI"];
$requestMethod = $_SERVER["REQUEST_METHOD"];
$scriptAssets = [];

if (is_null($_SESSION["currentUser"]) && $requestUri != '/login') {
    header("Location: /login");
    die();
}

include "users-controller.php";

if ($requestUri == "/logout") {
    session_destroy();
    header("Location: /");
    die();
}

if ($requestUri == "/login") {
    include "login.html";
    die();
}

if ($requestUri == "/about") {
    $handleRequest = function() {
        echo "about";
    };

    include "layout.php";
    die();
}

if ($requestUri == "/profile") {
    $handleRequest = function() {
        echo "profile";
    };

    include "layout.php";
    die();
}


if ($requestUri == "/") {
    $handleRequest = function() {
        echo "ГЛАВНАЯ";
    };

    include "layout.php";
    die();
}

if ($requestUri == "/auth") {
    $login = filter_var($_POST['login'] ,FILTER_SANITIZE_STRING);
    $password = filter_var($_POST['password'] ,FILTER_SANITIZE_STRING);


    foreach ($users as $user) {
        if ($user['login'] == $login && password_verify($password, $user['password'])) {
            $_SESSION["currentUser"] = $user;
        }
    }
    header("Location: /");
    die();
}


http_response_code(404);
die();
