<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (
    empty($_SERVER['PHP_AUTH_USER']) &&
    !empty($_SESSION['admin_user']) &&
    !empty($_SESSION['admin_pass'])
) {
    $_SERVER['PHP_AUTH_USER'] = $_SESSION['admin_user'];
    $_SERVER['PHP_AUTH_PW']   = $_SESSION['admin_pass'];
}

$PHP_AUTH_USER = isset($_SERVER['PHP_AUTH_USER']) ? $_SERVER['PHP_AUTH_USER'] : '';
$PHP_AUTH_PW   = isset($_SERVER['PHP_AUTH_PW']) ? $_SERVER['PHP_AUTH_PW'] : '';

$use_adminlte = 1;
$short_header = 1;
$no_header = 1;
?>