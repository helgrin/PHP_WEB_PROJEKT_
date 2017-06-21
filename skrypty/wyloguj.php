<?php



require_once "klasy/UserLog.php";

$tytul = "";


if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (isset($_SESSION["userOK"])) {
    $old_user = $_SESSION["userOK"]; //czy nastąpiło logowanie
    if ($old_user != null) {
        $zawartosc = '<article><h2>Wylogowano użytkownika: ' . $old_user->getName() . '.</h2></article>';
        unset($_SESSION["userOK"]);
        $old_user->logout();
    }
}
else{
    $zawartosc = '<article><h2>Użytkownik niezalogowany.</h2></article>';
}


