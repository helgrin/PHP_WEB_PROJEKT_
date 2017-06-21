<?php

function drukuj_form() {
    $form = '<form id="rej" action="#" method="post">
                    <table>
                        <tr>
                            <td><label for="nazwa">Nazwa użytkownika</label></td>
                            <td><input type="text" id="nazwa" name="nazwa" pattern="[A-Za-z][A-Za-z0-9_,.]{5,}" title="Nazwa użytkownika" placeholder="login" required="required"></td>
                        </tr>

                        <tr>
                            <td><label for="haslo">Hasło</label></td>
                            <td><input type="password" id="haslo" name="haslo" pattern="[A-Za-z0-9_,.]{8,}" title="Hasło do konta min. 8 znaków" placeholder="password" required="required"></td>
                        </tr>
                        
                        <tr>
                            <td><input class="guzik" type="submit" name="zaloguj" value="Zaloguj"></td>
                            <td><input class="guzik" type="reset" value="Anuluj"></td>
                        </tr>
                    </table>
                </form>';
    return $form;
}

require_once "klasy/Baza.php";
require_once "klasy/UserLog.php";

$tytul = "";

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION["userOK"])) {
    $zawartosc = '<article><h2>Użytkownik ' . $_SESSION['userOK']->getName() . ' zalogowany.</h2></article>';
} else {
    $zawartosc = "<article><h2>Formularz logowania</h2>";
    $zawartosc .= drukuj_form() . "</article>";
}

if (isset($_POST['zaloguj'])) {
    $blad = false;
    $bd = new Baza("localhost", "root", "", "misan_projekt");

    $opt = array("options" => array("regexp" => "/^[A-Za-z][A-Za-z0-9_,.]{5,}$/"));
    if (!filter_var($_POST['nazwa'], FILTER_VALIDATE_REGEXP, $opt) === false) {
        $name = htmlspecialchars(trim($_POST['nazwa']));
    } else {
        $blad = true;
    }
    if (!$blad) {
        $pass = hash('sha256', addslashes($_POST['haslo']));
        $user = UserLog::login($name, $pass, $bd, 'users');
        if ($user == null) {
            $zawartosc = '<article><h2>Błąd logowania.</h2>';
            $zawartosc .= '<p> Spróbuj jeszcze raz!</p>';
            $zawartosc .= drukuj_form() . "</article>";
        }
    } else {
        $zawartosc = '<h2>Wprowadzone dane są niepoprawne!</h2>';
    }
    if (isset($_SESSION["userOK"])) {
        $zawartosc = '<article><h2>Użytkownik ' . $_SESSION['userOK']->getName() . ' zalogowany.</h2></article>';
    }
}

