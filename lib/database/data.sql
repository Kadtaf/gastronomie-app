SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- --------------------------------------------------------
-- TABLE user
-- --------------------------------------------------------

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `lastname` VARCHAR(255) NOT NULL,
  `firstname` VARCHAR(64) NOT NULL,
  `email` VARCHAR(255) NOT NULL UNIQUE,
  `role` VARCHAR(64) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `remember_token` VARCHAR(255) NULL,
  `created_at` DATETIME NOT NULL,
  `updated_at` DATETIME NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `user` (lastname, firstname, email, role, password, created_at, updated_at)
VALUES
("Doe", "John", "doej@gmail.com", "admin",
 "$2y$10$B7e9Vf30Su7dMDrrKn8.TuUPLI2XJtPkvPLllbPaORN2hzYMQPQp.",
 "2022-07-26 18:30:23", "2022-07-27 18:30:33"),

("Barrer", "Malik", "barema@gmail.com", "user",
 "$2y$10$B7e9Vf30Su7dMDrrKn8.TuUPLI2XJtPkvPLllbPaORN2hzYMkjhg.",
 "2022-08-26 18:30:23", "2022-08-28 18:30:33"),

("Rombo", "Sergai", "r.sergai@gmx.com", "user",
 "$2y$10$B7e9Vf30Su7dMDrrKn8.TuUPLI2XJtPkvPLllbPaORN2hzYMQPQp.",
 "2022-07-24 18:00:23", "2022-07-25 18:45:33");

-- --------------------------------------------------------
-- TABLE category
-- --------------------------------------------------------

DROP TABLE IF EXISTS `category`;
CREATE TABLE `category` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(128) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `category` (name) VALUES
("Apéritif"),
("Entrée"),
("Plat"),
("Dessert");

-- --------------------------------------------------------
-- TABLE recipe
-- --------------------------------------------------------

DROP TABLE IF EXISTS `recipe`;
CREATE TABLE `recipe` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `category_id` INT NOT NULL,
  `title` VARCHAR(128) NOT NULL,
  `description` LONGTEXT NOT NULL,
  `duration` INT NOT NULL,
  `file_path_img` VARCHAR(255) NOT NULL,
  `created_at` DATETIME NOT NULL,
  `updated_at` DATETIME NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  FOREIGN KEY (`category_id`) REFERENCES `category` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `recipe` (user_id, category_id, title, description, duration, file_path_img, created_at, updated_at)
VALUES
(1, 4, "Crème brûlée", "Un dessert classique et délicieux", 35, "public/assets/img/img_recipe/creme.jpg", "2022-07-24 18:00:23", "2022-07-25 18:45:33"),
(2, 4, "Fondant au chocolat", "Un dessert fondant et gourmand", 25, "public/assets/img/img_recipe/fondant.jpg", "2022-07-24 18:00:23", "2022-07-25 18:45:33"),
(3, 4, "Flan pâtissier", "Un dessert crémeux et savoureux", 40, "public/assets/img/img_recipe/flan.jpg", "2022-07-24 18:00:23", "2022-07-25 18:45:33");

-- --------------------------------------------------------
-- TABLE ingredient
-- --------------------------------------------------------

DROP TABLE IF EXISTS `ingredient`;
CREATE TABLE `ingredient` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(128) NOT NULL,
  `quantity` VARCHAR(255) NOT NULL,
  `unity` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- TABLE ingredient_recipe (pivot)
-- --------------------------------------------------------

DROP TABLE IF EXISTS `ingredient_recipe`;
CREATE TABLE `ingredient_recipe` (
  `ingredient_id` INT NOT NULL,
  `recipe_id` INT NOT NULL,
  PRIMARY KEY (`ingredient_id`, `recipe_id`),
  FOREIGN KEY (`ingredient_id`) REFERENCES `ingredient` (`id`) ON DELETE CASCADE,
  FOREIGN KEY (`recipe_id`) REFERENCES `recipe` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- TABLE step
-- --------------------------------------------------------

DROP TABLE IF EXISTS `step`;
CREATE TABLE `step` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `recipe_id` INT NOT NULL,
  `order_step` INT NOT NULL,
  `description` LONGTEXT NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`recipe_id`) REFERENCES `recipe` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- TABLE comment
-- --------------------------------------------------------

DROP TABLE IF EXISTS `comment`;
CREATE TABLE `comment` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `recipe_id` INT NOT NULL,
  `content` LONGTEXT NOT NULL,
  `created_at` DATETIME NOT NULL,
  `updated_at` DATETIME NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  FOREIGN KEY (`recipe_id`) REFERENCES `recipe` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

COMMIT;