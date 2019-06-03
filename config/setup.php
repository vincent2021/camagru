<?php
require_once 'database.php';

$bdd->exec('CREATE TABLE `pictures`
(
  `id` int PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `status` varchar(255),
  `created_at` varchar(255)
);

CREATE TABLE `users`
(
  `id` int PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `full_name` varchar(255),
  `email` varchar(255) UNIQUE,
  `passwd` varchar(255),
  `created_at` varchar(255)
);

CREATE TABLE `comments`
(
  `id` int PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `pic_id` int NOT NULL,
  `comment_txt` varchar(255)
);

CREATE TABLE `likes`
(
  `id` int PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `pic_id` int NOT NULL,
  `status` int
);

ALTER TABLE `pictures` ADD FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
ALTER TABLE `comments` ADD FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
ALTER TABLE `comments` ADD FOREIGN KEY (`pic_id`) REFERENCES `pictures` (`id`);
ALTER TABLE `likes` ADD FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
ALTER TABLE `likes` ADD FOREIGN KEY (`pic_id`) REFERENCES `pictures` (`id`);
');
echo "BDD Created<br>";
?>