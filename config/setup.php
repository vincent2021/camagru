<?php
require_once 'database.php';
$bdd = getDB();
$bdd->exec('CREATE TABLE `pictures`
(
  `id` int PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `path` varchar(255) NOT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE `users`
(
  `id` int PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(255) UNIQUE  NOT NULL,
  `passwd` varchar(255) NOT NULL,
  `ckey` varchar(32),
  `rkey` varchar(32),
  `status` int NOT NULL DEFAULT "0",
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE `comments`
(
  `id` int PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `pic_id` int NOT NULL,
  `comment_txt` varchar(255),
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE `likes`
(
  `id` int PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `pic_id` int NOT NULL,
  `status` int,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
);

ALTER TABLE `pictures` ADD FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
ALTER TABLE `comments` ADD FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
ALTER TABLE `comments` ADD FOREIGN KEY (`pic_id`) REFERENCES `pictures` (`id`);
ALTER TABLE `likes` ADD FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
ALTER TABLE `likes` ADD FOREIGN KEY (`pic_id`) REFERENCES `pictures` (`id`);
');
echo "BDD Created<br>";
?>