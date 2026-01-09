--
-- Hôte : 127.0.0.1:3306

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";
--
-- Base de données : `gastronomie_blog`
--

-- --------------------------------------------------------
--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lastname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `firstname` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `updated_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO 
      `user`(`lastname`, `firstname`, `email`, `role`, `password`, `created_at`, `updated_at`)
VALUES(
  
        "Doe",
        "John",
        "doej@gmail.com",
        "admin",
        "$2y$10$B7e9Vf30Su7dMDrrKn8.TuUPLI2XJtPkvPLllbPaORN2hzYMQPQp.",
        "2022-07-26 18:30:23",
        "2022-07-27 18:30:33"
    
      ),
      (
        "Barrer",
        "Malik",
        "barema@gmail.com",
        "utilisateur",
        "$2y$10$B7e9Vf30Su7dMDrrKn8.TuUPLI2XJtPkvPLllbPaORN2hzYMkjhg.",
        "2022-08-26 18:30:23",
        "2022-08-28 18:30:33"
    
      ),
            (
        "Rombo",
        "Sergai",
        "r.sergai@gmx.com",
        "utilisateur",
        "$2y$10$B7e9Vf30Su7dMDrrKn8.TuUPLI2XJtPkvPLllbPaORN2hzYMQPQp.",
        "2022-07-24 18:00:23",
        "2022-07-25 18:45:33"
    
      );

      SELECT * FROM recipe;
INSERT INTO `recipe`(user_id, category_id, title, description, duration, file_path_img, steps, ingredients, created_at, updated_at)
VALUES(
  1,
  2,
"Crème brulée",
"c'est un desser",
"35",
"public/assets/img/img_recipe/creme de lait.jpg",
"pour 3 personnes",
"des oeufs",
"2022-07-24 18:00:23",
"2022-07-25 18:45:33"


),
(
  2,
  3,
"Crème brulée",
"c'est un desser",
"35",
"public/assets/img/img_recipe/creme de lait.jpg",
"pour 3 personnes",
"des oeufs",
"2022-07-24 18:00:23",
"2022-07-25 18:45:33"


),
(
  4,
  2,
"Crème brulée",
"c'est un desser",
"35",
"public/assets/img/img_recipe/creme de lait.jpg",
"pour 3 personnes",
"des oeufs",
"2022-07-24 18:00:23",
"2022-07-25 18:45:33"


);
DROP TABLE IF EXISTS `category`;
CREATE TABLE IF NOT EXISTS `category`(
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  `recipe_id` int(11) NOT NULL
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;  
SELECT * FROM `category`;
INSERT INTO `category`(`name`)
VALUES
  ("Apéritif"),
  ("Entrée"),
  ("Plat"),
  ("Dessert");

  --------
--
-- Structure de la table `recipe_category`
--
SELECT * FROM recipe_category;
INSERT INTO
        recipe_category(recipe_id, category_id)
VALUES
(26, 1),
(28, 2),
(33, 2),
(27, 3),
(34, 2);


--------
--
-- Select recipe de category_id 2
--

SELECT * FROM recipe
JOIN recipe_category
WHERE recipe_category.category_id = 2;

-- ---------------------------------------------------------------------
--
-- Structure de la table `ingredient`
--

DROP TABLE IF EXISTS `ingredient`;
CREATE TABLE IF NOT EXISTS `ingredient` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `unity` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci; 

-- ---------------------------------------------------------------------------
--
-- Structure de la table `category`
--
DROP TABLE IF EXISTS `category`;
CREATE TABLE IF NOT EXISTS `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



-- ---------------------------------------------------------------------------
--
-- Structure de la table `recipe`
--

DROP TABLE IF EXISTS `recipe`;
CREATE TABLE IF NOT EXISTS `recipe` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `title` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `duration` int(11) NOT NULL,
  `file_path_img` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `update_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`id`),
  KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- --------------------------------------------------------------------------------
--
-- Structure de la table `recipe_category`
--

DROP TABLE IF EXISTS `recipe_category`;
CREATE TABLE IF NOT EXISTS `recipe_category` (
  `recipe_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  PRIMARY KEY (`recipe_id`, `category_id`),
  KEY (`recipe_id`),
  KEY (`category_id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;




-- --------------------------------------------------------------------------------
--
-- Structure de la table `ingredient_recipe`
--

DROP TABLE IF EXISTS `recipe_ingredient`;
CREATE TABLE IF NOT EXISTS `ingredient_recipe` (
  `ingredient_id` int(11) NOT NULL,
  `recipe_id` int(11) NOT NULL,
  PRIMARY KEY (`ingredient_id`,`recipe_id`),
  KEY (`ingredient_id`),
  KEY (`recipe_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
--
-- Structure de la table `comment`
--

DROP TABLE IF EXISTS `comment`;
CREATE TABLE IF NOT EXISTS `comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `recipe_id` int(11) NOT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `updated_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`id`),
  KEY (`user_id`),
  KEY (`recipe_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
--
-- Structure de la table `step`
--

DROP TABLE IF EXISTS `step`;
CREATE TABLE IF NOT EXISTS `step` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `recipe_id` int(11) NOT NULL,
  `order_step` int(11) NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY (`recipe_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Contraintes pour la table `comment`
--
ALTER TABLE `comment`
  ADD FOREIGN KEY (`recipe_id`) REFERENCES `recipe` (`id`),
  ADD FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `ingredient_recipe`
--
ALTER TABLE `recipe_ingredient`
  ADD FOREIGN KEY (`recipe_id`) REFERENCES `recipe` (`id`) ON DELETE CASCADE,
  ADD FOREIGN KEY (`ingredient_id`) REFERENCES `ingredient` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `recipe`
--
ALTER TABLE `recipe`
  ADD FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `step`
--
ALTER TABLE `step`
  ADD FOREIGN KEY (`recipe_id`) REFERENCES `recipe` (`id`);
COMMIT;

