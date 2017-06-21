<?php

function drukuj_form() {
    $form = '<form id="rej" action="?strona=rejestracja" method="post">
                    <table>
                        <tr>
                            <td><label for="nazwa">Nazwa użytkownika</label></td>
                            <td><input type="text" id="nazwa" name="userName" pattern="[A-Za-z][A-Za-z0-9_,.]{5,}" title="Nazwa użytkownika" placeholder="login" required="required"></td>
                        </tr>

                        <tr>    
                            <td><label for="imie">Imię i nazwisko</label></td>
                            <td><input type="text" id="imie" name="fullName" pattern="[A-Z][a-z]{2,} [A-Z][a-z]{2,}" title="Imie i nazwisko" placeholder="Jan Kowalski" required="required"></td>
                        </tr>

                        <tr> 
                            <td><label for="email">E-mail</label></td>
                            <td><input type="email" id="email" name="email" title="Adres e-mail" placeholder="email@example.com" required="required"></td>
                        </tr> 

                        <tr>
                            <td><label for="haslo">Hasło</label></td>
                            <td><input type="password" id="haslo" name="password" pattern="[A-Za-z0-9_,.]{8,}" title="Hasło do konta min. 8 znaków" placeholder="password" required="required"></td>
                        </tr>

                        <tr>
                            <td><input class="guzik" type="submit" name="rejestruj" value="Rejestruj"></td>
                            <td><input class="guzik" type="reset" value="Anuluj"></td>
                        </tr>
                    </table>
                </form>';
    return $form;
}

include_once "klasy/Baza.php";
include_once "klasy/User.php";

$tytul = "";

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION["userOK"])) {
    $zawartosc = '<article><h2>Formularz rejestracji</h2>';
    $zawartosc .= drukuj_form() . "</article>";
    if (isset($_POST['rejestruj'])) {
        $userName = htmlspecialchars(trim($_POST['userName']));

        $fullName = htmlspecialchars(trim($_POST['fullName']));

        $email = htmlspecialchars(trim($_POST['email']));

        $passwd = htmlspecialchars(trim($_POST['password']));


        $user = null;
        $zawartosc = User::checkForm($userName, $fullName, $email, $passwd, $user);

        if ($user != null) {
            $user1 = new User($userName, $fullName, $email, $passwd);
            if ($user1->check_username()) {
                $zawartosc = "<article>" . $user1->save();
                $zawartosc .= $user1->show() . "</article>";
            } else {
                $zawartosc = '<article><h2>Użytkownik o takiej nazwie już istnieje!</h2>';
                $zawartosc .= drukuj_form();
                $zawartosc .= "</article>";
            }
        }
    }
} else {
    $zawartosc = '<article><h2>Musisz wylogować się przed rejestracją!</h2></article>';
}


