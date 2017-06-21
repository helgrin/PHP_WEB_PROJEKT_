<?php

require_once("klasy/Strona.php");

//sprawdź co wybrał użytkownik:
if (isset($_GET['strona'])) {
    $strona = $_GET['strona'];
    switch ($strona) {
        case 'zamowienie':$strona = 'zamowienie';
            break;
        case 'galeria':$strona = 'galeria';
            break;
        case 'anulowanie':$strona = 'anulowanie';
            break;
        case 'rejestracja':$strona = 'rejestracja';
            break;
        case 'zaloguj':$strona = 'zaloguj';
            break;
        case 'statystyki': $strona = 'statystyki';
            break;
        case 'wyloguj': $strona = 'wyloguj';
            break;
        default: $strona = 'home';
            break;
    }
} else
    $strona = "home";


$strona_akt = new Strona($strona);

//dołącz wyb rany plik z ustawioną zmienną $tytul i $zawartosc
$plik = "skrypty/" . $strona . ".php";
if (file_exists($plik)) {
    require_once($plik);
    $strona_akt->ustaw_tytul($tytul);
    $strona_akt->ustaw_zawartosc($zawartosc);
    $strona_akt->wyswietl();
}
?>