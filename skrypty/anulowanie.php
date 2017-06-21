<?php

require_once 'klasy/Baza.php';
require_once "klasy/UserLog.php";

$blad = false;

function drukuj_form() {
    $form = '<form id="cancel" method="POST" action="#">
                    <table>
                        <tr>
                            <td><label for="nr_zam">Numer zamówienia</label></td>
                            <td><input id="nr_zam" type="text" name="nr" pattern="[1-9][0-9]{0,}" placeholder="nr zamowienia" title="Proszę podać poprawny numer zamówienia" required="required"></td>
                        </tr>
                    </table>
                    <input class="guzik" id="zatwierdz" name="anuluj" type="submit" value="Anuluj zamówienie" />
                </form>';
    return $form;
}

function anuluj($username) {
    global $blad;
    $zawartosc = "";

    $opt = array("options" => array("regexp" => "/^[1-9][0-9]{0,}$/"));
    if ((isset($_POST['nr'])) && ($_POST['nr'] > 0)) {
        $id = htmlspecialchars(addslashes(strip_tags(trim($_POST['nr']))));
    } else {
        $blad = true;
    }

    if (!$blad) {
        $ob = new Baza("localhost", "root", "", "misan_projekt");
        $sql = "delete from `zamowienia` where id=" . $id;
        if ($ob->sprawdz($id, $username)) {
            $ob->delete($sql);
            $zawartosc .= '<h2>Twoje zamówienie zostało usunięte.</h2>';
        } else {
            $zawartosc .= '<h2>Zamówienia o danym id nie istnieje lub to nie jest twoje zamowienie!.</h2>';
            $zawartosc .= '<p>Spróbuj jeszcze raz!</p>';
            $blad = true;
        }
    } else {
        $zawartosc .= '<h2>Anulowanie nie powiodło się.</h2> <p>Spróbuj jeszcze raz!</p>';
        $blad = true;
    }
    return $zawartosc;
}

$tytul = "";

$zawartosc = '<article><h2>Formularz anulowania</h2>';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION["userOK"])) {
    $zawartosc .= drukuj_form() . "</article>";
    if (isset($_POST['anuluj'])) {
        $zawartosc = "<article>" . anuluj($_SESSION["userOK"]->getName());
        if($blad){
            $zawartosc .= drukuj_form();
        }
        $zawartosc .= "</article>";
    }
} else {
    $zawartosc = '<article><h2>Musisz zalogować się !</h2></article>';
}

