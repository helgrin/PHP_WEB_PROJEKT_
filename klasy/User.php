<?php

 require_once 'User.php';
 require_once 'Baza.php';

class User {
    protected $user_name;
    protected $passwd;
    protected $full_name;
    protected $email;
    protected $date;

    function __construct($userName, $fullName, $email, $passwd) {
//implementacja konstruktora
        $this->user_name = $userName;
        $this->passwd = hash('sha256', $passwd);
        $this->email = $email;
        $this->full_name = $fullName;
        $this->date = date('Y-m-d H:i:s');
    }
    
    function check_username(){
        $ob = new Baza("localhost", "root", "", "dragni_projekt");
        $result = $ob->getMysqli()->query("select * from `users` where username='" . $this->user_name . "' ");
        $ile = $result->num_rows;
        if($ile != 0){
            return false;
        }
        return true;
    }
    
    function save(){
        $ob = new Baza("localhost", "root", "", "dragni_projekt");
        $ob->insert("INSERT INTO `users` (`id`, `username`, `password`, `full_name`, `email`, `data`) VALUES (NULL, '$this->user_name', '$this->passwd', '$this->full_name', '$this->email', '$this->date')");
        return '<h2 class="hdng">Dane zostały pomyślnie dodane. <br/><span>Dziękujemy!</span></h2><br/><br/>';  
    }
    
    function show() {
        $zawartosc = "<strong>-----Dane użytkownika: -----</strong><br/>";
        $zawartosc .= "User_name: " . $this->user_name . '<br/>';
        $zawartosc .= "Full_name: " . $this->full_name . '<br/>';
        $zawartosc .= "Passwd (hash): " . $this->passwd . '<br/>';
        $zawartosc .= "Email: " . $this->email . '<br/>';
        $zawartosc .= "Date: " . $this->date . '<br/>';
        return $zawartosc;
    }
    
    function set_user_name($usr) {
        $this->user_name = $usr;
    }

    function get_user_name() {
        return $this->user_name;
    }
    
    static function checkForm($userName, $fullName, $email, $passwd, &$user) {
        $blad = false;
        $zawartosc = "";
        $opt = array("options" => array("regexp" => "/^[A-Za-z][A-Za-z0-9_,.]{5,}$/"));
        if (!filter_var($userName, FILTER_VALIDATE_REGEXP, $opt) === false) {
            $v_user = htmlspecialchars(trim($userName));
        } else {
            //$zawartosc .= "<p>Bledne user_name</p>";
            $blad = true;
        }

        $opt = array("options" => array("regexp" => "/^[A-Za-z0-9_,.]{8,}$/"));
        if (!filter_var($passwd, FILTER_VALIDATE_REGEXP, $opt) === false) {
            $v_pass = htmlspecialchars(trim($passwd));
        } else {
            //$zawartosc .= "<p>Haslo musi zawierac min. 8 znaków</p>";
            $blad = true;
        }

        $opt = array("options" => array("regexp" => "/^[A-Z][a-z]{2,} [A-Z][a-z]{2,}$/"));
        if (!filter_var($fullName, FILTER_VALIDATE_REGEXP, $opt) === false) {
            $v_fullname = htmlspecialchars(trim($fullName));
        } else {
            //$zawartosc .=  "<p>Bledne imie i nazwisko</p>";
            $blad = true;
        }

        $email = filter_input(INPUT_POST, "email");
        if (!filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            $v_email = htmlspecialchars(trim($email));
        } else {
            //$zawartosc .=  "<p>Nie poprawny E-mail</p>";
            $blad = true;
        }

        if (!$blad) {
            $user = new User($v_user, $v_fullname, $v_email, $v_pass);
        } else {
            $zawartosc = '<article><h2>Wprowadzone dane są niepoprawne!</h2></article>';
        }
        return $zawartosc;
    }
}
