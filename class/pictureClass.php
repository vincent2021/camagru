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

    public function getPictureComment() {
        $req = $this->bdd->prepare('SELECT `comment_txt` FROM `comments` WHERE `pic_id`= ?');
        try {
            $req->execute(array($this->getPictureId()));
            while ($req->fetch()) {
                $comments[] = $req->fetch()['comment_txt'];
            }
            return ($comments);
        } catch (PDOException $e) {
            return ("An error occured: ".$e);
        }
    }

    public function savePicture() {
        if (file_exists($this->tmp_dir.$this->img_name)) { 
            $req = $this->bdd->prepare('INSERT INTO pictures(user_id, path, created_at)
            VALUES(:uid, :path, :created_at)');
            try {
                $req->execute(array(
                'uid' => $_SESSION['uid'],
                'path' => $this->img_link,
                'created_at' => time(),
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