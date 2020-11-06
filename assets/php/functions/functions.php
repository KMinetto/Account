<?php

function debug($variables) {
    echo '<pre style="font-size: 2.0rem">' . print_r($variables, true) . '</pre>';
}

function stringRandom($length) {
    $alphabet = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
    return substr(str_shuffle(str_repeat($alphabet, $length)), 0, $length);
}