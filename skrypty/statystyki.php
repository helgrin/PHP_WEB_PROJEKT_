<?php

require_once 'klasy/Baza.php';
require_once "klasy/UserLog.php";

$tytul = "";

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION["userOK"])) {
    $ob = new Baza("localhost", "root", "", "misan_projekt");
    $stats = $ob->select($_SESSION["userOK"]->getName());
    if($stats != ""){
        $zawartosc  = '<article><h2>Statystyki zamówień dla ' . $_SESSION["userOK"]->getName() . ': </h2>';
        $zawartosc .= $stats . "</article>";
    }
    else{
        $zawartosc = "<article><h2>Brak zamówień dla " . $_SESSION["userOK"]->getName() . "!</h2></article>";
    }
    
    
} else {
    $zawartosc = '<article><h2>Musisz zalogować się !</h2></article>';
}             

