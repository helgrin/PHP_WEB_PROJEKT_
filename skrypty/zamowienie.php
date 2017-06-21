<?php

require_once "klasy/Baza.php";
require_once "klasy/UserLog.php";

function drukuj_form() {
    $form = '<form method="post" action="#" >
                        <table>
                            <tr>
                                <td><label for="imie">Imię i Nazwisko:</label></td>
                                <td><input id="imie" type="text" placeholder="Jan Kowalski" name="imie" pattern="[A-Z][a-z]{2,} [A-Z][a-z]{2,}" title="Imię i nazwisko zamawiającego" required="required"></td>
                            </tr>
                            <tr>
                                <td><label for="telefon">Telefon :</label></td>
                                <td><input id="telephone" type="text" placeholder="xxx-xxx-xxx" name="telefon" pattern="[0-9]{3}-[0-9]{3}-[0-9]{3}" title="Numer telefonu bez kodu krajowego" required="required" ></td>
                            </tr>
                            <tr>
                <td> <label for="bohater">Wybierz bohatera: </label></td>
                <td><input list="lista" name="bohater" id="bohater" required="required" title="Wybierz bohatera">
                    <datalist id="lista">
                        <option>Rumble</option>
                        <option>Garen</option>
                        <option>Cassiopeia</option>
                        <option>Tristana</option>
                        <option>Poppy</option>
                        <option>Rek Sai</option>
                        <option>Cho Gath</option>
                        <option>Master Yi</option>
                        <option>Gangplank</option>
                        <option>Ryze</option>
                        <option>Blitzcrank</option>
                    </datalist> 
                </td>
            </tr>
                            <tr>
                                <td><label for="platnosc">Płatność :</label></td>
                                <td><input type="radio"
                                   name="platnosc"
                                   value="visa" required/> Visa
                            <input type="radio"
                                   name="platnosc"
                                   value="mastercard" required/> MasterCard
                                   <input type="radio"
                                   name="platnosc"
                                   value="przelew" required/> Przelew bankowy </td>
                            </tr>
                            <br>
                           <tr>
                                <td><input type="submit" name="zatwierdz" value=" Zatwierdz "/></td>
                                <td><input type="reset" value=" Anuluj "/></td>
                            </tr>
                            </table>
                </form>';
    return $form;
}

function zamow() {
    $blad = false;
    $zawartosc = "";
    $opt = array("options" => array("regexp" => "/^[A-Z][a-z]{2,} [A-Z][a-z]{2,}$/"));
    if (!filter_var($_POST['imie'], FILTER_VALIDATE_REGEXP, $opt) === false) {
        $imie = htmlspecialchars(trim($_POST['imie']));
    } else {
        $zawartosc .= "<h4>Niepoprawny format imienia i nazwiska</h4>";
        $blad = true;
    }

    $opt = array("options" => array("regexp" => "/^[0-9]{3}-[0-9]{3}-[0-9]{3}$/"));
    if (!filter_var($_POST['telefon'], FILTER_VALIDATE_REGEXP, $opt) === false) {
        $telefon = htmlspecialchars(addslashes(strip_tags(trim($_POST['telefon']))));
    } else {
        $zawartosc .= "<h4>Niepoprawny format numeru telefonu</h4>";
        $blad = true;
    }

    if (isset($_POST['bohater'])) {
        $bohater = $_POST['bohater'];
    } else {
        $zawartosc .= "<h4>Nie wybrano bohatera</h4>";
        $blad = true;
    }

    if (isset($_POST['platnosc'])) {
        $platnosc = $_POST['platnosc'];
    } else {
        $zawartosc .= "<h4>Nie wybrano sposobu płatności</h4>";
        $blad = true;
    }

    if (!$blad) {
        $data = date('Y-m-d H:i:s');
        $ob = new Baza("localhost", "root", "", "misan_projekt");
        $zawartosc .= '<h2>Twoje dane zamówienia: </h2>';
        $zawartosc .= "<b>Login: </b>" . $_SESSION["userOK"]->getName() . "<br/>" . "<b>Imię i nazwisko: </b>" . $imie . "<br/>" . "<b>Telefon: </b>" . $telefon . "<br/>" . "<b>Bohater: </b>" . $bohater . "<br/>" . "<b>Płatność: </b>" . $platnosc . "<br/>" . "<b>Data zamówienia: </b>" . $data . "<br/>";
        $ob->insert("INSERT INTO `zamowienia` (`id`, `username`, `fullname`, `telefon`, `bohater`, `platnosc`, `date`) VALUES (NULL, '" . $_SESSION["userOK"]->getName() . "', '$imie', '$telefon', '$bohater', '$platnosc', '$data')");
        $zawartosc .= '</br><h2>Dane zostały pomyślnie dodane. Dziękujemy.</h2>';
        $zawartosc .= "<h2>Twoj numer zamowienia to: " . $ob->numer_zam() . "</h2>";
    } else {
        $zawartosc = '</br><h2>Zapisanie danych nie powiodło się. Spróbuj jeszcze raz!</h2>';
    }
    return $zawartosc;
}

$tytul = "";

$zawartosc = '<article><h2>Formularz zamówienia</h2>';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION["userOK"])) {
    $zawartosc .= drukuj_form() . "</article>";
    if (isset($_POST['zatwierdz'])) {
        $zawartosc = "<article>" . zamow() . "</article>";
    }
} else {
    $zawartosc = '<article><h2>Musisz zalogować się !</h2></article>';
}
