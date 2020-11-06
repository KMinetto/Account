<?php

$dbDsn = 'mysql:host=127.0.0.1;dbname=noidea';
$dbUsername = 'root';
$dbPass = '';

$pdo = new PDO($dbDsn, $dbUsername, $dbPass);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);