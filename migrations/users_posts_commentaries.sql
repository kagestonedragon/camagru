CREATE TABLE IF NOT EXISTS `users_posts_commentaries` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `user_id` INT NOT NULL,
    `post_id` INT NOT NULL,
    `commentary_id` INT NOT NULL
);