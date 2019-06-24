<?php
require_once 'config/database.php';

Class userClass {

    public function __construct()  {
        $this->bdd = getDB();
    }

    public function userLogin ($email, $passwd) {
        $req = $this->bdd->prepare('SELECT id, full_name, status FROM users
        WHERE (email=:email AND passwd=:passwd)');
        try {
            $req->execute(array(
            'email' => $email,
            'passwd' => $passwd,
            ));
        } catch (PDOException $e) {
            echo "Error".$e->getMessage();
        }
        if ($req->rowCount() == 1) {
            $data=$req->fetch();
            if ($data[2] == 0) {
                return (False);
            } else {
                $_SESSION['uid'] = $data[0];
                $_SESSION['name'] = $data[1];
                return (True);
            }
        } else {
            return (False);
        }
    }

    public function userSignup ($name, $email, $passwd) {
        $ckey = md5(microtime(True) * 100000);
        $req = $this->bdd->prepare('INSERT INTO users(full_name, email, passwd, ckey)
        VALUES(:full_name, :email, :passwd, :ckey)');
        try {
            $req->execute(array(
            'full_name' => $name,
            'email' => $email,
            'passwd' => $passwd,
            'ckey' => $ckey,
        ));
        $this->userMailConf($name, $email, $ckey);
        } catch (PDOException $e) {
            if ($e->errorInfo[1] == 1062) {
                return ("This account already exits, please <a href=login.php>login</a>.");
            } else {
                return ("An error occured:". $e);
            }
        }
        return ("Account successfully created, please confirm your email and <a href=login.php>login</a>");
    }

    public function userMailConf ($name, $email, $key) {
        $subject = 'Please activate your account';
        $header = 'From: contact@camagru.com';
        $header .= "\nContent-Type: text/html; charset=\"UTF-8\"";
        $msg = "Hi ".$name.",<br>You've just registred to Camagru.<br>
        To activate your account, please follow the link below or paste it in your favorite web browser:<br>
        http://localhost:8080/confirm.php?email=".$email."&key=".$key."<br>
        <br>
        --<br>
        This is an automatic e-mail. Please don't reply to it.";
        mail($email, $subject, $msg, $header);
    }

    public function confirmUser($email, $key) {
        $check = $this->bdd->prepare('SELECT `id` FROM users WHERE email=:email AND ckey=:ckey');
        try {
            $check->execute(array(
            'email' => $email,
            'ckey' => $key
            ));
            $uid = $check->fetch()['id'];
        } catch (PDOException $e) {
            return ("An error occured: ".$e);
        }
        try {
            $req = $this->bdd->prepare('UPDATE `users` SET `status` = 1 WHERE (id=:id)');
            $req->execute(array('id' => $uid));
        } catch (PDOException $e) {
            return ("An error occured: ".$e);
        }
        if($req->rowCount() == 1) {
            return (True);
        } else {
            return (False);
        }
    }

    public function userDetail($uid) {
        $req = $this->bdd->prepare('SELECT full_name, email, alert FROM users WHERE (id=:id)');
        try {
            $req->execute(array(
            'id' => $uid,
            ));
        } catch (PDOException $e) {
            echo "Error".$e->getMessage();
        }
        if ($req->rowCount() == 1) {
            $data=$req->fetch();
            return ($data);
        } else {
            return ("Error occured.");
        }
    }

    public function userChangePasswd($old_pw, $new_pw) {
        $uid = $_SESSION['uid'];
        $check = $this->bdd->prepare('SELECT `passwd` FROM `users` WHERE `id`=:uid');
        try {
            $check->execute(array(
            'uid' => $uid,
            ));
        } catch (PDOException $e) {
            return ("An error occured: ".$e);
        }
        if ($check->fetch()['passwd'] == $old_pw && $check->rowCount() == 1) {
            try {
                $req = $this->bdd->prepare('UPDATE `users` SET `passwd` =:new_pw WHERE `id`=:uid');
                $req->execute(
                    array('new_pw' => $new_pw,
                    'uid' => $uid,
                ));
            } catch (PDOException $e) {
                return ("An error occured: ".$e);
            }
            return ("Password succesfully changed.");
        }
        return ("Wrong password.");
    }

    public function userResetLink($email) {
        $rkey = md5(microtime(True) * 100000);
        $req = $this->bdd->prepare('UPDATE `users` 
        SET `rkey`=:rkey, `status`=:status 
        WHERE (`email`=:email)');
        try {
            $req->execute(array(
            'rkey' => $rkey,
            'status'=> 0,
            'email' => $email,
            ));
        } catch (PDOException $e) {
            return ("An error occured:". $e);
        }
        if ($req->rowCount() == 1) {
            $this->userMailReset($email, $rkey);
            return ("A link to reset your password has been sent to ".$email);
        } else {
            return ('The email '.$email.' does not exist, please signup.');
        }

    }

    public function userResetPasswd($old_pw, $new_pw, $key, $email) {
        $check = $this->bdd->prepare('SELECT `passwd` FROM `users` WHERE email=:email AND rkey=:rkey');
        try {
            $check->execute(array(
            'email' => $email,
            'rkey' => $key
            ));
        } catch (PDOException $e) {
            return ("An error occured: ".$e);
        }
        if ($check->fetch()['passwd'] == $old_pw && $check->rowCount() == 1) {
            try {
                $req = $this->bdd->prepare('UPDATE `users` SET `passwd` =:new_pw, `rkey`=:rkey, `status`=:status WHERE email=:email');
                $req->execute(
                    array('new_pw' => $new_pw,
                    'email' => $email,
                    'rkey' => NULL,
                    'status' => 1,
                ));
            } catch (PDOException $e) {
                return ("An error occured: ".$e);
            }
            return ("Password succesfully changed. Please login.");
        }
        return ("Wrong password or reset link.");
    }

    public function userMailReset ($email, $key) {
        $subject = 'Reset link for your password';
        $header = 'From: contact@camagru.com';
        $header .= "\nContent-Type: text/html; charset=\"UTF-8\"";
        $msg = "Hi,<br>To reset your password, please follow the link below or paste it in your favorite web browser:<br>
        http://localhost:8080/password.php?email=".$email."&key=".$key."<br>
        <br>
        --<br>
        This is an automatic e-mail. Please don't reply to it.";
        mail($email, $subject, $msg, $header);
    }

    public function userChangeName($new_name, $uid) {
        $req = $this->bdd->prepare('UPDATE `users` SET full_name=:new_name WHERE id=:uid');
        try {
            $req->execute(array(
                'new_name' => $new_name,
                'uid' => $uid,
            ));
        } catch (PDOException $e) {
            return ("An error occured: ".$e);
        }
        if($req->rowCount() == 1) {
            return ("Name has been updated");
        } else {
            return ("An error occured or you entered your previous record");
        }
    }

    public function userChangeEmail($new_email, $uid) {
        $req = $this->bdd->prepare('UPDATE `users` SET `email` = :new_email WHERE id=:uid');
        try {
            $req->execute(array('uid' => $uid,
                'new_email' =>$new_email,
            ));
        } catch (PDOException $e) {
            return ("An error occured: ".$e);
        }
        if($req->rowCount() == 1) {
            return ("Email has been updated");
        } else {
            return ("An error occured or you entered your previous record");
        }
    }

    public function userPasswdCheck($passwd) {
        if (strlen($passwd) < 6){
            return (False);
        }
        if (!preg_match("#[0-9]+#", $passwd) || !preg_match("#[a-zA-Z]+#", $passwd)) {
            return (False);
        }
        return (True);
    }
}

