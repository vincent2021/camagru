<?php
require_once 'config/database.php';

Class userClass {

    public function userLogin ($email, $passwd) {
        $bdd = getDB();
        $passwd = hash('whirlpool', $passwd);
        $req = $bdd->prepare('SELECT id, full_name FROM users
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
        $bdd = getDB();
        $passwd = hash('whirlpool', $passwd);
        $req = $bdd->prepare('INSERT INTO users(full_name, email, passwd)
        VALUES(:full_name, :email, :passwd)');
        try {
            $req->execute(array(
            'full_name' => $name,
            'email' => $email,
            'passwd' => $passwd,
            ));
        } catch (PDOException $e) {
            if ($e->errorInfo[1] == 1062) {
                return ("This account already exits, please <a href=login.php>login</a>.");
            } else {
                return ("An error occured.");
            }
        }
        return ("Account successfully created, please <a href=login.php>login</a>");
    }

    public function userDetail ($uid) {
        $bdd = getDB();
        $req = $bdd->prepare('SELECT full_name, email FROM users WHERE (id=:id)');
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
}

