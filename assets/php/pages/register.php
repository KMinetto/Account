<?php
require_once '../functions/functions.php';
require_once '../pdo/db.php';

session_start();

$errors = array();

if (!empty($_POST)) {
    if (empty($_POST['pseudo']) || !preg_match('/^[a-zA-Z0-9_]+$/', $_POST['pseudo'])) {
        $errors['pseudo'] = "Votre pseudo n'est pas valide";
    } else {
        $req = $pdo->prepare('SELECT * FROM users WHERE pseudo = ?');
        $req->execute([$_POST['pseudo']]);
        $user = $req->fetch();
        if ($user) {
            $errors['pseudo'] = "Cet username est déjà pris";
        }
    }

    if (empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Votre email n'est pas un email valide";
    } else {
        $req = $pdo->prepare('SELECT * FROM users WHERE email = ?');
        $req->execute([$_POST['email']]);
        $user = $req->fetch();
        if ($user) {
            $errors['email'] = "Cet email est déjà utilisé";
        }
    }

    if (empty($_POST['password'])) {
        $errors['password'] = "Vous devez rentrer un mot de passe valide";
    }

    if (empty($_POST['confirm']) || $_POST['confirm'] !== $_POST['password']) {
        $errors['confirm'] = "Vos mots de passe de sont pas identiques";
    }

    if (empty($errors)) {
        $req = $pdo->prepare("INSERT INTO users SET pseudo = ?, password = ?, email = ?, confirmation_token = ?");
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
        $token = stringRandom(60);
        $req->execute([$_POST['pseudo'], $password, $_POST['email'], $token]);
        $userId = $pdo->lastInsertId();
        mail($_POST['email'], 'Confirmation de votre compte',
            "Afin de valider votre compte, merci de cliquer sur ce lien\n\nhttp://localhost:63342/noIdea/assets/php/pages/confirm.php?id=$userId&token=$token");
        $_SESSION['flash']['success'] = "Un email de confirmation vous a été envoyé";
        header("Location: login.php");
        exit();
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
    <title>noIdea | register</title>
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

<!--Main Layout-->
<main role="main" class="index">

   <div class="container">
       <div>
           <h1 class="text-center olondon"><span class="the">The</span> Orca's IV</h1>
       </div>
       <div class="wrapper fadeInDown zero-raduis">
           <div id="formContent">
               <!-- Tabs Titles -->

               <?php if (!empty($errors)) : ?>
                <div class="alert alert-danger">
                    <p>Vous n'avez pas rempli le formulaire correctement</p>
                    <ul>
                    <?php foreach ($errors as $error) : ?>
                        <li><?= $error; ?></li>
                    <?php endforeach; ?>
                    </ul>
                </div>
               <?php endif; ?>

               <!-- Icon -->
               <div class="fadeIn first">
                   <!-- <img src="http://danielzawadzki.com/codepen/01/icon.svg" id="icon" alt="User Icon" /> -->
                   <h2 class="my-5">Sign In</h2>

               <!-- Login Form -->
               <form action="" method="post">
                   <input type="text" id="pseudo" class="fadeIn second zero-radius" name="pseudo" placeholder="pseudo">
                   <input type="email" id="email" class="fadeIn third zero-radius" name="email" placeholder="email">
                   <input type="password" id="password" class="fadeIn fourth zero-radius" name="password" placeholder="password">
                   <input type="password" id="password_confirm" class="fadeIn fifth, zero-radius" name="confirm" placeholder="confirm password">

                   <input type="submit" class="fadeIn fourth zero-raduis" name="inscription" value="register">
                   <h2>You already have an account ?</h2>
                           <a href="login.php"><input type="button" class="fadeIn fourth zero-raduis pc" value="login"></a>
               </form>
           </div>
       </div>
   </div>