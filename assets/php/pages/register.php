<?php

require_once '../pdo/db.php';
$validate = false;

if (isset($_POST['inscription'])) {
    if (!empty($_POST['pseudo']) && !empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['confirm'])) {
        $pseudo = htmlspecialchars($_POST['pseudo']);
        $mail = htmlspecialchars($_POST['email']);
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
        $confirm = password_hash($_POST['confirm'], PASSWORD_BCRYPT);

        if (filter_var($mail, FILTER_VALIDATE_EMAIL)) {
            $reqmail = $bdd->prepare('SELECT * FROM membres WHERE mail = ?');
            $reqmail->execute(array($mail));
            $mailExist = $reqmail->rowCount();
            if ($mailExist == 0) {
                if ($_POST['confirm'] == $_POST['password']) {
                    $insertmbr = $bdd->prepare("INSERT INTO membres (pseudo, mail, password) VALUES (?, ?, ?)");
                    $insertmbr->execute(array($pseudo, $mail, $password));
                    $validate = true;
                    $error = 'Votre compte est bien créé';
    //                $_SESSION['crated_account'] = 'Votre compte est bien créé';
                    // TODO Redirection vers une autre page
                } else {
                    $error = 'Vos mots de passe ne sont pas identiques';
                }
            } else {
                $error = 'Adresse mail déjà utilisée';
            }
        } else {
            $error = 'Votre email est invalide';
        }

    } else {
        $error = 'Tous les champs doivent être complétés';
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
    <nav class="navbar fixed-top navbar-expand-lg navbar-dark pink scrolling-navbar">
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

               <?php
               if (isset($error) && $validate == true) {
                   echo "<p class='alert alert-success'>$error</p>";
               } elseif (isset($error) && $validate == false) {
                   echo "<p class='alert alert-danger'>$error</p>";
               }
               ?>

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
                   <h2>You already have an account ?<h2>
                           <a href="login.php"><input type="button" class="fadeIn fourth zero-raduis pc" value="login"></a>
               </form>
           </div>
       </div>
   </div>