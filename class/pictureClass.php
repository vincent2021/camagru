<?php
require_once 'config/database.php';
Class pictureClass {

    public $lib_dir = 'assets/library/';
    public $tmp_dir = 'assets/tmp/';
    public $img_name;
    public $img_link;
    public $bdd;

    public function __construct($img_name)  {
        $this->img_name = $img_name;
        $this->img_link = $this->lib_dir.$img_name;
        $this->bdd = getDB();
    }

    public function getPictureId() {
        $req = $this->bdd->prepare('SELECT `id` FROM `pictures` WHERE `path`= ?');
        try {
            $req->execute(array($this->img_link));
            return ($req->fetch()['id']);
        } catch (PDOException $e) {
            return ("An error occured: ".$e);
        }
    }

    public function getLikes() {
        $req = $this->bdd->prepare('SELECT COUNT(id) FROM `likes` WHERE `pic_id`= ?');
        try {
            $req->execute(array($this->getPictureId()));
            return ($req->fetch()[0]);
        } catch (PDOException $e) {
            return ("An error occured: ".$e);
        }
    }

    public function setLikes() {
        $pic_id = $this->getPictureId();
        $check = $this->bdd->prepare('SELECT COUNT(id) FROM likes WHERE pic_id=:picid AND user_id=:uid');
        try {
            $check->execute(array(
            'picid' => $pic_id,
            'uid' => $_SESSION['uid'],
            ));
            if ($check->fetch()[0] != 0) {
                return (False);
            }
        } catch (PDOException $e) {
            return ("An error occured: ".$e);
        }
        $req = $this->bdd->prepare('INSERT INTO likes(user_id, pic_id, status) VALUES(:uid, :pic_id, :status)');        
        try {
            $req->execute(array(
            'uid' => $_SESSION['uid'],
            'pic_id' => $pic_id,
            'status' => 1,
            ));
            return (True);
        } catch (PDOException $e) {
            return ("An error occured: ".$e);
        }
    }

    public function getPictureComment() {
        $req = $this->bdd->prepare('SELECT `comment_txt`, comments.created_at, `full_name` FROM `comments` LEFT JOIN `users` ON users.id = comments.user_id WHERE `pic_id`= ?');
        try {
            $req->execute(array($this->getPictureId()));
            while ($ret = $req->fetch(PDO::FETCH_ASSOC)) {
                $comments[] = $ret;
            }
            if (isset($comments)) {
                return ($comments);
            } else {
                return (False);
            }
        } catch (PDOException $e) {
            return (array(0 => "An error occured: ".$e));
        }
    }

    public function savePicture() {
        if (file_exists($this->tmp_dir.$this->img_name)) { 
            $req = $this->bdd->prepare('INSERT INTO pictures(user_id, path)
            VALUES(:uid, :path)');
            try {
                $req->execute(array(
                'uid' => $_SESSION['uid'],
                'path' => $this->img_link,
                ));
            } catch (PDOException $e) {
                return ("An error occured: ".$e);
            }
            if (rename($this->tmp_dir.$this->img_name, $this->img_link)) {
                return (True);
            }
        }
    }

    public function commentPicture($str) {
        $req = $this->bdd->prepare('INSERT INTO comments(user_id, pic_id, comment_txt)
        VALUES(:uid, :pic_id, :comment)');
        try {
            $req->execute(array(
            'uid' => $_SESSION['uid'],
            'pic_id' => $this->getPictureId(),
            'comment' => $str,
            ));
        } catch (PDOException $e) {
            return ("An error occured: ".$e);
        }
        return (True);
    }
}
?>