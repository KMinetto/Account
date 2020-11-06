<?php

function debug($variables) {
    echo '<pre style="font-size: 2.0rem">' . print_r($variables, true) . '</pre>';
}

function stringRandom($length) {
    $alphabet = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
    return substr(str_shuffle(str_repeat($alphabet, $length)), 0, $length);
}

function loggedOnly() {
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    if (!isset($_SESSION['auth'])) {
        $_SESSION['flash']['danger'] = "Vous n'avez pas le droit d'acceder à cette page";
        header('Location: assets/php/pages/login.php');
        exit();
    }
}