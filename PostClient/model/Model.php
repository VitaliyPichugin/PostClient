<?php

class Model
{
    public $db;

    public function __construct($host, $user, $pass, $db ){
        $this->db = mysql_connect($host, $user,$pass, $db );
        if(!$this->db){
            exit('No connection with DB');
        }
        if(!mysql_select_db($db, $this->db)){
            exit('No table');
        }
        mysql_query('SET NAMES utf8');

        return $this->db;
    }

    public function get_messages($user_mail){
        $messages = array();
        $user_mail = $this->clearData($user_mail);
        $query = "SELECT * FROM mail WHERE user_mail='$user_mail'";

        $res = mysql_query($query);

        if(!$res){
            exit('Error');
        }else{
            while($row=mysql_fetch_assoc($res)){
                $messages[] = $row;
            }
        }
        return $messages;
    }

    public function login($email, $password){
        $user = array();
        $query = "SELECT * FROM user WHERE email='$email' AND password='$password'";

        $res = mysql_query($query);

        if(mysql_num_rows($res) == 0){
            return false;
        }else{
            while($row=mysql_fetch_assoc($res)){
                $user[] = $row;
            }
            return $user;
        }
    }

    public function save_user($email, $pass){
        $email = $this->clearData($email);
        $pass = $this->clearData($pass);

        $query = "INSERT INTO user (email, password) VALUES ('$email', '$pass')";
       if(mysql_query($query)){
           return true;
       }else{
           return false;
       }
    }

    public function save_mail($user_mail,  $to_mail, $subject, $text){
        $to_mail = $this->clearData($to_mail);
        $subject = $this->clearData($subject);
        $text = $this->clearData($text);
        $user_mail = $this->clearData($user_mail);

        if(!empty($user_mail) && !empty($to_mail) && !empty($subject) && !empty($text)){
            $query = "INSERT INTO mail (to_mail, subject, message, user_mail) VALUES ('$to_mail', '$subject', '$text', '$user_mail')";
            mysql_query($query);
        }else{
            exit('error');
        }
    }

    public function remove_mail($id){
        $query = "DELETE FROM mail WHERE id IN($id) ";
       if(mysql_query($query)) {
           return true;
       }else{
           return false;
       }
    }

    private function clearData($var){
        $var = trim(mysql_real_escape_string($var));
        return $var;
    }

}