<?php
require_once 'config.php';
session_start();

function __autoload($file){
    if(file_exists('controller/'.$file.'.php')){
        require_once 'controller/'.$file.'.php';
    }else{
        require_once 'model/'.$file.'.php';
    }
}

if($_POST['logout']){
    unset($_SESSION['email']);
    unset($_SESSION['pass']);
}

$init = new Index();
echo $init->get_body();
