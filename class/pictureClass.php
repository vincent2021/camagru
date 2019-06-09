<?php
require_once 'config/database.php';

Class pictureClass {

    public function savePicture($img_src) {
        $bdd = getDB();
        $req = $bdd->prepare('INSERT INTO pictures(user_id, path, created_at)
        VALUES(:uid, :path, :created_at)');
        try {
            $req->execute(array(
            'uid' => $_SESSION['uid'],
            'path' => $img_src,
            'created_at' => time(),
            ));
        } catch (PDOException $e) {
            return ("An error occured: ".$e);
        }
        return ("PicDB OK");
    }
}

?>