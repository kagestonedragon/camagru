CREATE TABLE IF NOT EXISTS `notifications` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `user_id_1` INT NOT NULL,
    `user_id_2` INT NOT NULL,
    `post_id` INT NOT NULL,
    `type` INT NOT NULL,
    `new` BOOLEAN DEFAULT TRUE
);