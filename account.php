<?php
session_start();
require_once 'assets/php/functions/functions.php';

loggedOnly();
?>

<?php require_once 'assets/php/require/header.php'; ?>

<div class="container">
    <h1 class="text-center title">Bonjour <span class="olondon the"><?= $_SESSION['auth']->pseudo ?></span></h1>
</div>