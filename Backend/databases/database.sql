-- database.sql - Script de création des tables pour le projet AutoMarket

--
-- Structure de la table `users`
--
-- Cette table stocke les informations des utilisateurs, y compris les administrateurs.
CREATE TABLE `users` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `firstname` VARCHAR(255) NOT NULL,
  `lastname` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `role` ENUM('admin', 'user') NOT NULL DEFAULT 'user',
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Structure de la table `categories`
--
-- Cette table stocke les différentes catégories de véhicules (ex: Berline, SUV, Électrique).
CREATE TABLE `categories` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Structure de la table `vehicles`
--
-- Cette table stocke les informations détaillées de chaque véhicule.
CREATE TABLE `vehicles` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `brand` VARCHAR(255) NOT NULL,
  `model` VARCHAR(255) NOT NULL,
  `year` INT(4) NOT NULL,
  `price` DECIMAL(10, 2) NOT NULL,
  `description` TEXT NOT NULL,
  `kilometers` INT(11) NOT NULL,
  `fuel` VARCHAR(50) NOT NULL,
  `category_id` INT(11) NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`category_id`) REFERENCES `categories`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Ajout d'un utilisateur admin par défaut
--
-- Mot de passe par défaut : 'admin123' (le mot de passe haché est 'mdp-securise')
-- Vous devriez générer un vrai mot de passe haché pour la production.
-- INSERT INTO `users` (`firstname`, `lastname`, `email`, `password`, `role`) VALUES
-- ('Admin', 'AutoMarket', 'admin@automarket.com', '$2y$10$tJ9F0j6u7nJ2kR3wM5hP8u.zO7xT5qY4fD2gV0gA0yT6vC8xI2uS3v', 'admin');

