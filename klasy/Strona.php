<?php

class Strona {

    //pola (własności) klasy:
    protected $zawartosc;
    protected $tytul = "League od Legends";
    protected $slowa_kluczowe;
    protected $przyciski = array("Home" => "?strona=home",
        "Galeria" => "?strona=galeria",
        "Zamowienie" => "?strona=zamowienie",
        "Usuń zamówienie" => "?strona=anulowanie",
        "Statystyki" => "?strona=statystyki",
        "Rejestracja" => "?strona=rejestracja",
        "Zaloguj" => "?strona=zaloguj",
        "Wyloguj" => "?strona=wyloguj");

    //interfejs klasy – metody modyfikujące fragmenty strony
    public function ustaw_zawartosc($nowa_zawartosc) {
        $this->zawartosc = $nowa_zawartosc;
    }

    function ustaw_tytul($nowy_tytul) {
        $this->tytul = $nowy_tytul;
    }

    public function ustaw_slowa_kluczowe($nowe_slowa) {
        $this->slowa_kluczowe = $nowe_slowa;
    }

    public function ustaw_przyciski($nowe_przyciski) {
        $this->przyciski = $nowe_przyciski;
    }

    public function ustaw_style($url) {
        echo '<link rel="stylesheet" href=' . $url . ' type="text/css" />';
    }

    //interfejs klasy – funkcje wyświetlające stronę
    public function wyswietl() {
        $this->wyswietl_naglowek();
        $this->wyswietl_menu();
        $this->wyswietl_zawartosc();
        $this->wyswietl_stopke();
    }

    public function wyswietl_tytul() {
        echo "<title>$this->tytul</title>";
    }

    public function wyswietl_slowa_kluczowe() {
        echo "<meta name=\"keywords\" contents=\"$this->slowa_kluczowe\">";
    }
    
    public function wyswietl_menu() {
        echo "<nav>";
        while (list($nazwa, $url) = each($this->przyciski))
            echo '<a href="' . $url . '">' . $nazwa . '</a>';
        echo "</nav>";
    }

    public function wyswietl_naglowek() {
        ?>
        <!DOCTYPE html>
<html>
    <head>
        <title>League od Legends - witamy</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <?php
                $this->ustaw_style('css/style.css');
                echo '		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
		<script src="js/zdjecie.js"></script>
                <title>' . $this->tytul . '</title></head><body><div id="strona">
            <header>
                <img src="img/baner.jpg" alt="baner"/>
            </header>';
            }

            public function wyswietl_zawartosc() {
                echo $this->zawartosc;
            }

            public function wyswietl_stopke() {
                echo'<footer>
                &copy; Vitaliy Misan 2017
            </footer>
        </div>
    </body>
</html>';
            }

        }

