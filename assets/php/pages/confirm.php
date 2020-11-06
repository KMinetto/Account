<?php

$userId = $_GET['id'];
$token = $_GET['token'];
require_once '../pdo/db.php';
$req = $pdo->prepare('SELECT * FROM users WHERE id = ?');
$req->execute([$userId]);
$user = $req->fetch();
session_start();

if ($user && $user->confirmation_token == $token) {
    $pdo->prepare('UPDATE users SET confirmation_token = NULL, confirmed_at = NOW() WHERE id = ?')->execute([$userId]);
    $_SESSION['flash']['success'] = "Votre compte a bien été validé";
    $_SESSION['auth'] = $user;
    header('Location: ../../../account.php');
} else {
    $_SESSION['flash']['danger'] = "Votre cconfirmation n'est plus valide";
    header('Location: login.php');
}