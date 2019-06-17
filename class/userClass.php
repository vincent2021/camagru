<?php
require_once 'config/database.php';

Class userClass {

    public function __construct()  {
        $this->bdd = getDB();
    }

    public function userLogin ($email, $passwd) {
        $req = $this->bdd->prepare('SELECT id, full_name FROM users
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
            $_SESSION['uid'] = $data[0];
            $_SESSION['name'] = $data[1];
            return (True);
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
        $req = $this->bdd->prepare('SELECT full_name, email FROM users WHERE (id=:id)');
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

    public function userChangePasswd($uid) {
        
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
}

