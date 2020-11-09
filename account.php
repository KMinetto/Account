<?php
session_start();
require_once 'assets/php/functions/functions.php';
require_once 'assets/php/pdo/db.php';

loggedOnly();

$errors = array();

if (!empty($_POST)) {
    if (empty($_POST['namePlayer']) || !preg_match('/^[a-zA-Z0-9_]+$/', $_POST['namePlayer'])) {
        $errors['namePlayer'] = "Vous devez rentrer un nom pour votre personnage";
    } else {
        $req = $pdo->prepare('SELECT * FROM players WHERE name = ?');
        $req->execute([$_POST['namePlayer']]);
        $player = $req->fetch();
        if ($player) {
            $errors['namePlayer'] = "Ce nom existe déjà";
        }
    }

    if (empty($_POST['racePlayer']) || !preg_match('/^[a-zA-Z]+$/', $_POST['racePlayer'])) {
        $errors['racePlayer'] = "Vous devez rentrer une race pour votre personnage";
    } else {
        $req = $pdo->prepare('SELECT * FROM players WHERE race = ?');
        $req->execute([$_POST['racePlayer']]);
        $player = $req->fetch();
    }

    if (empty($_POST['playerDescription'])) {
        $errors['playerDescription'] = "Votre description est vide";
    } else {
        $req = $pdo->prepare('SELECT * FROM players WHERE description = ?');
        $req->execute([$_POST['playerDescription']]);
        $player = $req->fetch();
    }

    if (empty($errors)) {
        $req = $pdo->prepare("INSERT INTO players SET name = ?, race = ?, description = ?");
        $req->execute([$_POST['namePlayer'], $_POST['racePlayer'], $_POST['playerDescription']]);
        $playerId = $pdo->lastInsertId();
        $_SESSION['flash']['success'] = "Votre personnage est créé";
        header("Location: account.php");
        exit();
    }
}

    if (!empty($_POST) && !empty($_POST['namePlayer']) && !empty(['racePlayer']) && !empty($_POST['playerDescription'])) {
        $req = $pdo->prepare('SELECT * FROM players WHERE (name = :name)');
        $req->execute(['name' => $_POST['namePlayer']]);
        $player = $req->fetch();
        $_SESSION['player'] = $player;
    }

    debug($_SESSION);
?>

<?php require_once 'assets/php/require/header.php'; ?>

<div class="container">
    <h1 class="text-center title">Bonjour <span class="olondon the"><?= $_SESSION['auth']->pseudo ?></span></h1>
</div>
<div class="container">
    <div class="row">
        <div class="col-6">
            <form action="" method="post">
                <div class="form-group">
                    <label for="namePlayer">Nom du joueur</label>
                    <input type="text" class="form-control" id="namePlayer" name="namePlayer" placeholder="Entrez le nom de votre joueur...">
                </div>
                <div class="form-group">
                    <label for="racePlayer">Race du joueur</label>
                    <input type="text" class="form-control" id="racePlayer" name="racePlayer" placeholder="Entrez le nom de votre joueur...">
                </div>
                <div class="form-group">
                    <label for="playerDescription">Description du joueur</label>
                    <textarea class="form-control" name="playerDescription" id="playerDescription" name="playerDescription" rows="5"
                              placeholder="Description de votre joueur"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Enregistrer votre personnage</button>
            </form>
        </div>
        <div class="col-6">
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
                        <h2 class="my-5">Votre personnage</h2>
                    </div>

                    <!-- Login Form -->
                    <form action="" method="post">
                        <div>
                            <?php if (!empty($_POST)) : ?>
                            <p>
                                Nom : <?= $_SESSION['player']->name ?>
                            </p>
                            <?php else : ?>
                            <p>Nom : </p>
                            <?php endif; ?>
                        </div>
                        <div>
                            <p>
                                <?php if (!empty($_POST)) : ?>
                            <p>
                                Race : <?= $_SESSION['player']->race ?>
                            </p>
                            <?php else : ?>
                                <p>Race : </p>
                            <?php endif; ?>
                            </p>
                        </div>
                        <div>
                            <?php if (!empty($_POST)) : ?>
                                <p>
                                   Niveau : <?= $_SESSION['player']->level ?>
                                </p>
                            <?php else : ?>
                                <p>Niveau : </p>
                            <?php endif; ?>
                        </div>
                        <div>
                            <?php if (!empty($_POST)) : ?>
                                <p>
                                    Description : <?= $_SESSION['player']->description ?>
                                </p>
                            <?php else : ?>
                                <p>Description : </p>
                            <?php endif; ?>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>