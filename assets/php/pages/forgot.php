<?php
require_once '../pdo/db.php';
session_start();
    if (!empty($_POST)) {
        if (empty($_POST['password']) || empty($_POST['email'] || (empty($_POST['password']) && empty($_POST['email'])))) {
            $_SESSION['flash']['danger'] = "Des champs n'ont pas été complétés";
        }elseif ($_POST['password'] != $_POST['password_confirm']) {
            $_SESSION['flash']['danger'] = 'Les mots de passe ne correspondent pas';
        } else {
            $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
            $req = $pdo->prepare('UPDATE users SET password = ? WHERE email = ?');
            $req->execute([$password, $_POST['email']]);
            $_SESSION['flash']['success'] = 'Votre mot de passe a bien été mis à jour';
        }
    }
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
          integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="../../css/style.css">
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
            integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <title>noIdea | Login</title>
</head>
<body>
<!--Main Navigation-->
<header>
    <nav class="navbar navbar-expand-lg navbar-dark pink scrolling-navbar">
        <a id="accueil" class="navbar-brand log" href="../../../index.php"><strong>Accueil</strong></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link log" href="register.php">S'enregistrer<span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link log" href="login.php">Se connecter</a>
                </li>
            </ul>
            <ul class="navbar-nav nav-flex-icons">
                <li class="nav-item">
                    <a class="nav-link"><i class="fab fa-facebook-f"></i></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link"><i class="fab fa-twitter"></i></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link"><i class="fab fa-instagram"></i></a>
                </li>
            </ul>
        </div>
    </nav>
</header>
<!--Main Navigation-->

<main role="main" class="index">

    <div class="container">
        <div class="row">
            <h1 class="col-12 olondon text-center">Mot de passe oublié <span class="the">?</span></h1>

            <div class="wrapper fadeInDown zero-raduis">
                <div id="formContent">
                    <!-- Tabs Titles -->

                    <?php if (isset($_SESSION['flash'])): ?>
                        <?php foreach ($_SESSION['flash'] as $type => $message) : ?>
                            <div class="alert alert-<?= $type ?>">
                                <p><?= $message ?></p>
                            </div>
                        <?php endforeach; ?>
                        <?php unset($_SESSION['flash']); ?>
                    <?php endif; ?>

                    <!-- Icon -->
                    <div class="fadeIn first">
                        <!-- <img src="http://danielzawadzki.com/codepen/01/icon.svg" id="icon" alt="User Icon" /> -->
                        <h2 class="my-5">Log In</h2>
                    </div>

                    <!-- Login Form -->
                    <form action="" method="post">
                        <input type="email" id="email" class="fadeIn second zero-radius" name="email" placeholder="Votre email">
                        <input type="password" id="pseudo" class="fadeIn third zero-radius" name="password" placeholder="Nouveau mot de passe">
                        <input type="password" id="password" class="fadeIn fourth zero-radius" name="password_confirm" placeholder="Confirmation mot de passe">
                        <input type="submit" class="fadeIn fifth zero-raduis" value="login">
                    </form>
                </div>
            </div>
        </div>
    </div>

</main>
