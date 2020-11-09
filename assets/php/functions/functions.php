<?php

function debug($variables) {
    echo '<pre style="font-size: 2.0rem">' . print_r($variables, true) . '</pre>';
}

function stringRandom($length) {
    $alphabet = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
    return substr(str_shuffle(str_repeat($alphabet, $length)), 0, $length);
}

function loggedOnly() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if (!isset($_SESSION['auth'])) {
        $_SESSION['flash']['danger'] = "Vous n'avez pas le droit d'acceder à cette page";
        header('Location: assets/php/pages/login.php');
        exit();
    }
}

function reconnectCookie() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
            if (isset($_COOKIE['remember']) && !isset($_SESSION['auth'])) {
            require_once '../pdo/db.php';
            if (!isset($pdo)) {
                global $pdo;
            }
            $rememberToken = $_COOKIE['remember'];
            $parts = explode('==', $rememberToken);
            $userId = $parts[0];
            $req = $pdo->prepare('SELECT * FROM users WHERE id = ?');
            $req->execute([$userId]);
            $user = $req->fetch();
            if ($user) {
                $expected = $userId . '==' . $user->remember_token . sha1($userId . 'ratonLaveurs');
                if ($expected === $rememberToken) {
                    session_start();
                    $_SESSION['auth'] = $user;
                    setCookie('remember', $rememberToken, time() + 60 * 60 * 24 * 7);
                }
            } else {
                setCookie('remember', null, -1);
            }
        } else {
                setCookie('remember', null, -1);
            }
}