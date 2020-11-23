-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Hôte : db
-- Généré le : lun. 23 nov. 2020 à 21:36
-- Version du serveur :  10.5.6-MariaDB-1:10.5.6+maria~focal
-- Version de PHP : 7.4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `blog`
--

-- --------------------------------------------------------

--
-- Structure de la table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `message` varchar(400) NOT NULL,
  `valid` tinyint(1) NOT NULL,
  `posts_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `modified_date` timestamp NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `comments`
--

INSERT INTO `comments` (`id`, `message`, `valid`, `posts_id`, `user_id`, `created_date`, `modified_date`) VALUES
(1, 'Trop bien ce post', 1, 1, 3, '2020-11-04 17:55:21', '0000-00-00 00:00:00'),
(2, 'Mais moi aussi je le trouve trop bien', 1, 1, 4, '2020-11-04 17:55:21', '0000-00-00 00:00:00'),
(3, 'Interressant...', 1, 2, 3, '2020-11-04 17:55:21', '0000-00-00 00:00:00'),
(4, 'C\'est par où la sortie?', 1, 2, 4, '2020-11-04 17:55:21', '0000-00-00 00:00:00'),
(5, 'Pas content', 0, 2, 4, '2020-11-04 17:55:21', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Structure de la table `gender`
--

CREATE TABLE `gender` (
  `id` int(11) NOT NULL,
  `name` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `gender`
--

INSERT INTO `gender` (`id`, `name`) VALUES
(1, 'female'),
(2, 'male'),
(3, 'other'),
(4, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `lead_paragraph` varchar(200) NOT NULL,
  `content` varchar(400) NOT NULL,
  `created_date` datetime NOT NULL,
  `modified_date` datetime DEFAULT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `posts`
--

INSERT INTO `posts` (`id`, `title`, `lead_paragraph`, `content`, `created_date`, `modified_date`, `user_id`) VALUES
(1, 'Mon premier post', 'Il était une fois...', 'Et voilà! Il s\'agit de mon premier article. Il serait impensable de ne pas insérer un loremipsum! Q\'en pensez-vous?', '2020-11-01 18:13:13', '2020-11-03 18:13:13', 3),
(2, 'Deuxième post', 'bla bla...', 'test', '2020-11-02 18:13:13', '2020-11-04 18:13:13', 3);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `admin` tinyint(1) NOT NULL,
  `first_name` varchar(200) NOT NULL,
  `last_name` varchar(200) NOT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(100) NOT NULL,
  `street` varchar(200) DEFAULT NULL,
  `address` varchar(200) DEFAULT NULL,
  `postal_code` int(11) DEFAULT NULL,
  `town` varchar(255) DEFAULT NULL,
  `logo` varchar(200) DEFAULT NULL,
  `description` varchar(400) DEFAULT NULL,
  `gender_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `admin`, `first_name`, `last_name`, `phone`, `email`, `password`, `street`, `address`, `postal_code`, `town`, `logo`, `description`, `gender_id`) VALUES
(3, 1, 'Matthias', 'LEROUX', '0603550664', 'm@m.fr', 'test', 'allée des muriers', '3', 38230, 'TIGNIEU', ' ', 'test', 1),
(4, 0, 'John', 'DOE', '0632548562', 'john.doe@gmail.com', 'test', 'rue des acacias', '12', 75000, 'PARIS', ' ', 'test', 1),
(5, 0, 'Jean', 'dupont', NULL, 'cendar78@msn.com', 'test', NULL, NULL, NULL, NULL, NULL, NULL, 1),
(6, 0, 'Louis', 'LEROUX', NULL, 'louis.leroux@laboitemail.fr', 'louis2011', NULL, NULL, NULL, NULL, NULL, NULL, 2),
(7, 1, 'Marty', 'McFly', NULL, 'marty@futur.com', '$2y$12$E0fWSrgMtDCbcDxwhMvdXuLI7/lIUeUpZWI9UxdidYl/6cP10hzQS', NULL, NULL, NULL, NULL, NULL, NULL, 2),
(8, 0, 'Jean', 'Rosé', NULL, 'jean.rose@mail.fr', '$2y$12$bOS.z93o7HC37o3XQvWG1.O.qpitGZ23IbF9pJZCKbH1dUUd6wDkO', NULL, NULL, NULL, NULL, NULL, NULL, 3),
(9, 0, 'Mad', 'Max', '', 'mad@max.fr', '$2y$12$SkAhiI8SnbQ7rpFb8seK6unbICxndabcu68iuge7SM2l7M6d.BWOO', '', '', NULL, '', '', '', 1),
(10, 0, 'Robo', 'Cop', NULL, 'robocop@corp.fr', '$2y$12$j2acxjRVTygope5qQO7hUeHSce4DcCpfQDV0F7qUi8Rs7hb3zVLzm', NULL, NULL, NULL, NULL, NULL, NULL, 4),
(11, 0, 'Bat', 'Man', NULL, 'batman@gotham.com', '$2y$12$K8TqgV8xqTbsSIif/mGOc.nnyBsKzn2gtuFnSXyWQA9z.dHtGPzKy', NULL, NULL, NULL, NULL, NULL, NULL, 4),
(12, 0, 'to', 'to', NULL, 'toto@gmail.from', '$2y$12$EBvGP1B0ADCprT3VqIDmB.uW6Le7hpDdLyeraYsez1XeW8hkPkkru', NULL, NULL, NULL, NULL, NULL, NULL, 4),
(13, 0, 'François', 'Mitterand', NULL, 'francois@social.fr', '$2y$12$hqZxSvr1raFgPCqCkqos1OwW4zhCrqG3dpwyY.4BY0dfQou5Qu4Z6', NULL, NULL, NULL, NULL, NULL, NULL, 4),
(14, 1, 'hacker', 'jack', NULL, 'jack@lepirate.fr', '$2y$12$2V7KjrEFpLbu.WBSV5bIbeg9t0pFD6T6YQnCwGxJFK3.WG48IVD06', NULL, NULL, NULL, NULL, NULL, NULL, 4),
(15, 0, 'elon', 'musk', NULL, 'elon@tesla.fr', '$2y$12$oTHeY//mlrkuDT6jA.Pe2O2utycnQhWbNCaAJJCQ0oH8CqF1Xj81S', NULL, NULL, NULL, NULL, NULL, NULL, 4),
(16, 0, 'donald', 'trump', NULL, 'donald@disney.fr', '$2y$12$jm/QmOjIqN/BBwAU50ps1.S.5y7qmMSQ9wXSZ5ZUfSwCT8Os30eli', NULL, NULL, NULL, NULL, NULL, NULL, 4),
(17, 0, 'Iron', 'man', NULL, 'iron@marvel.com', '$2y$12$mPSLqxHiulinYRp87xzJe.M.EXKRvU0J0pnphqqEN1NQfjS8CDAey', NULL, NULL, NULL, NULL, NULL, NULL, 4),
(18, 0, 'Jean', 'jack', NULL, 'jeanjack@laposte.net', '$2y$12$gnH79yCfgs7JC7KlhXPQ5..EWiSRsGuohIKlgmljC5RuW3pwu3Lfm', NULL, NULL, NULL, NULL, NULL, NULL, 4),
(19, 0, 'hacker', 'jack', NULL, 'ab@ddd.fr', '$2y$12$rzikly7Erw4OjhGTao1pUOf4F.xtNAmxHX5.P4QHNUJUQCKaIR17q', NULL, NULL, NULL, NULL, NULL, NULL, 4),
(20, 0, 'Matthias', 'jack', NULL, 'dqsdqd@qdssqd.com', '$2y$12$C/.vRfP6nUHmVvlPFhDBpuk9GSiqaECO7siNNo4NE5mMvZeeTn50G', NULL, NULL, NULL, NULL, NULL, NULL, 4),
(21, 0, 'Matthias', 'dupont', NULL, 'sqsqs@qsqsq.fr', '$2y$12$7DdGkdRIVBqB4/S2vU9aS.YNCIYIQwLqpnfZsKOXf16AUWy8UBgCC', NULL, NULL, NULL, NULL, NULL, NULL, 4),
(22, 0, 'qd', 'qdqsd', NULL, 'dqsddff@qsfqffdsqqsfq.fr', '$2y$12$Ypm0GWG8Vp3yrvOAVMrKzugOTswIrQ2pOw9YlbH5AO3hk9eeEA0qK', NULL, NULL, NULL, NULL, NULL, NULL, 4),
(23, 0, 'test', 'terst', NULL, 'dsfsdfsdf@sdfsdfdsf.com', '$2y$12$u8tSCK7ZGL1.DxsuIfggAuJkSXH72WK74L/52LMZXkiHq0TkNv1Aq', NULL, NULL, NULL, NULL, NULL, NULL, 4),
(24, 0, 'test', 'test', NULL, 'dfsgtsr@gtgg.fr', '$2y$12$uASe9IptvK/0Tnn4uo745OJ11d87IcrCpzcAhkHousmK2mC0yWYv6', NULL, NULL, NULL, NULL, NULL, NULL, 4),
(25, 0, 'frffrsdf', 'sqfsqf', NULL, 'qff@fqfqfq.fr', '$2y$12$P052uY5G00whEBcxlDZ/zuq.rsAkMn.S6BFOYbUwknlKnPSgN99uK', NULL, NULL, NULL, NULL, NULL, NULL, 4);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_comments_fk` (`user_id`),
  ADD KEY `posts_comments_fk` (`posts_id`);

--
-- Index pour la table `gender`
--
ALTER TABLE `gender`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_posts_fk` (`user_id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `gender_user_fk` (`gender_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `gender`
--
ALTER TABLE `gender`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `posts_comments_fk` FOREIGN KEY (`posts_id`) REFERENCES `posts` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `user_comments_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `user_posts_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `gender_user_fk` FOREIGN KEY (`gender_id`) REFERENCES `gender` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
