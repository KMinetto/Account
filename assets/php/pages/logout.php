<?php
session_start();
setCookie('remember', NULL, -1);
unset($_SESSION['auth']);
$_SESSION['flash']['success'] = 'Vous êtes maintenant déconnecté';
header('Location: login.php');