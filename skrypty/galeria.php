<?php

$tytul = "Galeria zdjęć";
$zawartosc = "";
$licznik = 1;

$zawartosc .= '<article style="text-align: center">
				<div><img id="foto" src="img/01.jpg" alt="foto"></div><br/>';
				

for ($i = 1; $i < 13; $i++) {
        $nazwa = "img/obraz" . $i;
        $zawartosc .= '<a href=' . "javascript:zdjecie('$nazwa')" . '><img src="' . "$nazwa" . '.jpg" alt="male 03"></a>';  
}
$zawartosc .= '</article>';