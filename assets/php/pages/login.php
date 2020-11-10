<?php
require_once '../pdo/db.php';
require_once '../functions/functions.php';
//reconnectCookie();
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['auth'])) {
    header('Location: ../../../account.php');
    exit();
}
if (!empty($_POST) && !empty($_POST['pseudo']) && !empty(['password'])) {
    $req = $pdo->prepare('SELECT * FROM users WHERE (pseudo = :pseudo OR email = :pseudo) 
                      AND confirmed_at IS NOT NULL');
    $req->execute(['pseudo' => $_POST['pseudo']]);
    $user = $req->fetch();
    if(password_verify($_POST['password'], $user->password)) {
        $_SESSION['auth'] = $user;
        $_SESSION['flash']['success'] = 'Vous êtes maintenant connecté';
        if ($_POST['rememberMe']) {
            $rememberToken = stringRandom(250);
            $pdo->prepare('UPDATE users SET remember_token = ? WHERE id = ?')->execute([$rememberToken, $user->id]);
            setCookie('remember', $user->id . '==' . $rememberToken . sha1($user->id . 'ratonLaveurs'), time() + 60 * 60 * 24 * 7);
        }
        header('Location: ../../../account.php');
        exit();
    } else {
        $_SESSION['flash']['danger'] = 'Identifiant ou mot de passe incorrect';
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

<!--Main Layout-->
<main role="main" class="index">

<div class="container">
    <div>
        <h1 class="text-center olondon"><span class="the">The</span> Orca's IV</h1>
    </div>
    <div class="wrapper fadeInDown zero-raduis">
        <div id="formContent">
            <!-- Tabs Titles -->

            <?php if (isset($_SESSION['flash'])): ?>
                <?php foreach ($_SESSION['flash'] as $type => $message) : ?>
                   <div style="" class="alert alert-<?= $type ?>">
                       <p style="font-size: 20px"><?= $message ?></p>
                   </div>
                <?php endforeach; ?>
            <?php unset($_SESSION['flash']); ?>
            <?php endif; ?>

            <!-- Icon -->
            <div class="fadeIn first">
                <h2 class="my-5">Log In</h2>
            </div>

            <!-- Login Form -->
            <form action="" method="post">
                <input type="text" id="pseudo" class="fadeIn second zero-radius" name="pseudo" placeholder="email ou pseudo">
                <input type="password" id="password" class="fadeIn third zero-radius" name="password" placeholder="password">
                <div id="formFooter">
                    <a class="underlineHover" href="forgot.php">Forgot Password?</a>
                </div>
                <div>
                    <label for="">
                        <input type="checkbox" name="rememberMe" id="rememberMe" value="1"> Se souvenir de moi
                    </label>
                </div>
                <input type="submit" class="fadeIn fourth zero-raduis" value="login">
                <h2>You don't have a account ?</h2>
                <a class="nav-link" href="register.php"><input type="button" class="fadeIn fourth zero-raduis pc" value="register"></a>
            </form>
        </div>
    </div>
</div>
