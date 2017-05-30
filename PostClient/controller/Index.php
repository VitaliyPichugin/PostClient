<?php

class Index extends AController
{
    public function __construct(){}

    public function get_body()
    {
        $db = new Model(HOST, USER, PASS, DB);

        if ($_POST['login']) {
            $_SESSION['email'] = $_POST['email'];
            $_SESSION['pass'] = $_POST['pass'];

            if ($db->save_user($_POST['email'], trim(md5($_POST['pass'])))) {
                $_SESSION['new_user'] = true;
            } else {
                if ($db->login($_POST['email'], trim(md5($_POST['pass'])))) {
                    $_SESSION['login_error'] = false;
                    $_SESSION['new_user'] = false;
                } else {
                    $_SESSION['login_error'] = true;
                }
            }
        }

        if ($_SESSION['email']) {
            $messages = $db->get_messages($_SESSION['email']);
        }

        if ($_SESSION['email'] && $_POST['mail_to'] && $_POST['sub'] && $_POST['msg']) {

            $headers = 'From: От кого письмо <' . $_SESSION['email'] . "\r\n" .
                'Reply-To: ' . $_SESSION['email'] . "\r\n" .
                'MIME-Version: 1.0' . "\r\n" .
                'Content-type: text/html; charset=utf-8' . "\r\n" .
                'X-Mailer: PHP/' . phpversion();

            if (mail($_POST['mail_to'], $_POST['sub'], $_POST['msg'], $headers)) {
                $db->save_mail($_SESSION['email'], $_POST['mail_to'], $_POST['sub'], $_POST['msg']);
            }
        }

        if ($_POST['del_msg'] && !empty($_POST['message'])) {
            $id = $_POST['message'];
            $res = implode(',', $id);
            $db->remove_mail($res);
            header("Location: /");
        }

        return $this->render('index', array('title' => 'Post Client', 'messages' => $messages));

    }
}