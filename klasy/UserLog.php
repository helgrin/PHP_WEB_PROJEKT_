<?php

class UserLog {
    
    private $name;
    private $pass;
    private $log = false;

    function __construct($name, $pass) {
        $this->name = $name;
        $this->pass = $pass;
    }

    public function getName() {
        return $this->name;
    }

    public function logout() {
        $this->log = false;
        $_SESSION = array();
        if (isset($_COOKIE[session_name()])) {
            setcookie(session_name(), '', time() - 42000, '/');
        }
        session_destroy();
    }

    static function loginForm($link) {
        $zawartosc = '<form id="rej" action="' . $link . '" method="post" />
                    <table>
                        <tr>
                            <td><label for="nazwa">Nazwa użytkownika</label></td>
                            <td><input type="text" id="nazwa" name="nazwa"></td>
                        </tr>

                        <tr>
                            <td><label for="haslo">Hasło</label></td>
                            <td><input type="password" id="haslo" name="haslo"></td>
                        </tr>
                        
                        <tr>
                            <td><input class="guzik" type="submit" name="zaloguj" value="Zaloguj"></td>
                            <td><input class="guzik" type="reset" value="Anuluj"></td>
                        </tr>
                    </table>
                </form>';
        return $zawartosc;
    }
    
    static function login($name, $pass, $bd, $table) { //$bd - uchwyt do BD, $table – nazwa tabeli z uzytkownikami w bazie
        $user = null;
        if (($name !== "") && ($pass !== "")) {
            $sql = "select * from " . $table . " where username='" . $name . "' and password='" . $pass . "' ";
            if ($result = $bd->getMysqli()->query($sql)) {
                $ile = $result->num_rows; //ile wierszy
                if ($ile == 1) { //użytkownik zalogowany
                    $user = new UserLog($name, $pass);
                    $user->log = true;
                    $_SESSION["userOK"] = $user;
                }
                $result->close(); /* zwolnij pamięć */
            }
        } return $user;
    }

}
