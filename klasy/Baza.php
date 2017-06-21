<?php

class Baza {

    private $mysqli; //uchwyt do BD

    public function __construct($serwer, $user, $pass, $baza) {
        $this->mysqli = new mysqli($serwer, $user, $pass, $baza);
        /* sprawdz połączenie */
        if ($this->mysqli->connect_errno) {
            printf("Nie udało sie połączenie z serwerem: %s\n", $mysqli->connect_error);
            exit();
        }
        /* zmien kodowanie na utf8 */
        if ($this->mysqli->set_charset("utf8")) {
//udało sie zmienić kodowanie
        }
    }

//koniec funkcji konstruktora

    function __destruct() {
        $this->mysqli->close();
    }

    public function getMysqli() {
        return $this->mysqli;
    }

    public function numer_zam() {
        $result = $this->mysqli->query("select max(id) as max from `zamowienia`");
        if ($result) {
            if ($result->num_rows == 1) {
                $id = $result->fetch_object()->max;
            }
        }
        return $id;
    }

    public function select($username) {

        $tresc = "";
        if ($result = $this->mysqli->query("select * from `zamowienia` where username='" . $username . "' ")) {
            $ile = $result->num_rows;
            if ($ile > 0) {
                $pola = array("id", "username", "fullname", "telefon", "bohater", "platnosc", "date");
                $tresc.="<table><tbody>";
                while ($row = $result->fetch_object()) {
                    $tresc.="<tr>";
                    for ($i = 0; $i < 7; $i++) {
                        $p = $pola[$i];
                        $tresc.="<td>" . $row->$p . "</td>";
                    }
                    $tresc.="</tr>";
                }
                $tresc.="</table></tbody>";
            }
            $result->close(); /* zwolnij pamięć */
        }
        return $tresc;
    }

    public function insert($sql) {
        if ($this->mysqli->query($sql)) {
            return true;
        } else {
            return false;
        }
    }

    public function sprawdz($id, $username) {
        $sql = "select * from `zamowienia` where username='" . $username . "' and id=" . $id;

        if ($result = $this->mysqli->query($sql)) {
            $ile = $result->num_rows; //ile wierszy
            if ($ile == 1) {
                return true;
            } else {
                return false;
            }
        }
        return false;
    }

    public function delete($sql) {
        if ($this->mysqli->query($sql)) {
            return true;
        } else {
            return false;
        }
    }

    public function count($sql) {
        if ($result = $this->mysqli->query($sql)) {
            $ile = $result->num_rows;
        }
        return $ile;
    }

}

//koniec klasy Baza
?>
