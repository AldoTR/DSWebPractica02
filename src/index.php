<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['usuario_autenticado']) && $_SESSION['usuario_autenticado'] === true) {
    header("Location: home.php");
    exit();
} else {
    header("Location: login.php");
    exit();
}
?>