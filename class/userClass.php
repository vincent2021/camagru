<?php
Class userClass {

    public function userLogin ($email, $passwd) {
        $bdd = getDB();
        $passwd = hash('whirlpool', $passwd);
        $req = $bdd->prepare('SELECT full_name FROM users
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
            return ("Welcome ".$req->fetch()[0]);
        } else {
            return ("Login failed.");
        }
    }

    public function userSignup ($name, $email, $passwd) {
        $bdd = getDB();
        $passwd = hash('whirlpool', $passwd);
        $req = $bdd->prepare('INSERT INTO users(full_name, email, passwd, created_at)
        VALUES(:full_name, :email, :passwd, :created_at)');
        try {
            $req->execute(array(
            'full_name' => $name,
            'email' => $email,
            'passwd' => $passwd,
            'created_at' => time(),
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
}

