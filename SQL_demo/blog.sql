-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Hôte : db
-- Généré le : jeu. 03 déc. 2020 à 19:55
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
  `valid` tinyint(1) NOT NULL DEFAULT 0,
  `posts_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `modified_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `comments`
--

INSERT INTO `comments` (`id`, `message`, `valid`, `posts_id`, `user_id`, `created_date`, `modified_date`) VALUES
(1, 'C\'est un assez long message pour m\'assurer que la fonction slice de twig fonctionne correctement.', 1, 1, 27, '2020-11-29 19:31:13', '2020-12-02 20:47:43'),
(2, 'Mais moi aussi je le trouve trop bien', 1, 1, 4, '2020-11-29 15:56:09', '2020-11-29 15:56:09'),
(6, 'j,nb,b,hghjgf', 0, 3, 27, '2020-11-30 21:41:28', '2020-11-30 21:41:28'),
(7, 'j,nb,b,hghjgf', 0, 3, 27, '2020-11-30 21:41:55', '2020-11-30 21:41:55'),
(8, 'Bien', 0, 3, 27, '2020-11-30 21:42:11', '2020-11-30 21:42:11'),
(9, 'ok nice', 0, 3, 29, '2020-12-02 10:19:53', '2020-12-02 10:19:53'),
(10, 'nice', 0, 1, 29, '2020-12-02 10:20:18', '2020-12-02 10:20:18'),
(11, 'ok nice', 0, 3, 29, '2020-12-02 10:20:36', '2020-12-02 10:20:36'),
(12, 'Brice de Nice', 0, 1, 29, '2020-12-02 10:20:59', '2020-12-02 10:20:59'),
(13, 'reerfezr', 0, 3, 29, '2020-12-02 10:21:34', '2020-12-02 10:21:34'),
(14, 'erzrezr', 0, 3, 29, '2020-12-02 10:21:56', '2020-12-02 10:21:56');

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
(1, ''),
(2, 'Femme'),
(3, 'Homme'),
(4, 'Autre');

-- --------------------------------------------------------

--
-- Structure de la table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `lead_paragraph` varchar(200) NOT NULL,
  `content` varchar(400) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `modified_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `posts`
--

INSERT INTO `posts` (`id`, `title`, `lead_paragraph`, `content`, `created_date`, `modified_date`, `user_id`) VALUES
(1, 'Mon premier post', 'Il était une fois...', 'Et voilà! Il s\'agit de mon premier article. Il serait impensable de ne pas insérer un loremipsum! Q\'en pensez-vous?\r\n\r\ntest1', '2020-11-01 18:13:13', '2020-11-30 20:11:10', 6),
(3, 'Test', 'pour voir', 'C\'est un test', '2020-11-30 20:23:29', '2020-11-30 20:23:29', 27);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `admin` tinyint(1) NOT NULL DEFAULT 0,
  `first_name` varchar(200) NOT NULL,
  `last_name` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(100) NOT NULL,
  `pseudo` varchar(200) DEFAULT NULL,
  `gender_id` int(11) DEFAULT 4,
  `valid` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `admin`, `first_name`, `last_name`, `email`, `password`, `pseudo`, `gender_id`, `valid`) VALUES
(3, 1, 'Matthias28', 'LEROUX32', 'm@mat.fr', 'test', 'allée des muriers', NULL, 0),
(4, 0, '1', 'DOE', 'john.doe@gmail.com', 'test', 'rue des acacias', NULL, 0),
(5, 0, 'Jean', 'dupont', 'cendar78@msn.com', 'test', NULL, NULL, 0),
(6, 1, 'Louis', 'LEROUX', 'louis.leroux@laboitemail.fr', 'louis2011', NULL, 2, 1),
(7, 1, 'Marty', 'McFly', 'marty@futur.com', '$2y$12$E0fWSrgMtDCbcDxwhMvdXuLI7/lIUeUpZWI9UxdidYl/6cP10hzQS', NULL, 2, 0),
(8, 0, 'Jean', 'Rosé', 'jean.rose@mail.fr', '$2y$12$bOS.z93o7HC37o3XQvWG1.O.qpitGZ23IbF9pJZCKbH1dUUd6wDkO', NULL, 3, 0),
(9, 0, 'Mad', 'Max', 'mad@max.fr', '$2y$12$SkAhiI8SnbQ7rpFb8seK6unbICxndabcu68iuge7SM2l7M6d.BWOO', '', 1, 0),
(10, 0, 'Robo', 'Cop', 'robocop@corp.fr', '$2y$12$j2acxjRVTygope5qQO7hUeHSce4DcCpfQDV0F7qUi8Rs7hb3zVLzm', NULL, 4, 0),
(11, 0, 'Bat', 'Man', 'batman@gotham.com', '$2y$12$K8TqgV8xqTbsSIif/mGOc.nnyBsKzn2gtuFnSXyWQA9z.dHtGPzKy', NULL, 4, 0),
(12, 1, 'to', 'to', 'toto@gmail.from', '$2y$12$EBvGP1B0ADCprT3VqIDmB.uW6Le7hpDdLyeraYsez1XeW8hkPkkru', NULL, 4, 0),
(13, 1, 'François', 'Mitterand', 'francois@social.fr', '$2y$12$hqZxSvr1raFgPCqCkqos1OwW4zhCrqG3dpwyY.4BY0dfQou5Qu4Z6', NULL, 4, 0),
(14, 1, 'hacker', 'jack', 'jack@lepirate.fr', '$2y$12$2V7KjrEFpLbu.WBSV5bIbeg9t0pFD6T6YQnCwGxJFK3.WG48IVD06', NULL, 4, 0),
(15, 0, 'elon', 'musk', 'elon@tesla.fr', '$2y$12$oTHeY//mlrkuDT6jA.Pe2O2utycnQhWbNCaAJJCQ0oH8CqF1Xj81S', NULL, 4, 0),
(16, 0, 'donald', 'trump', 'donald@disney.fr', '$2y$12$jm/QmOjIqN/BBwAU50ps1.S.5y7qmMSQ9wXSZ5ZUfSwCT8Os30eli', NULL, 4, 0),
(17, 0, 'Iron', 'man', 'iron@marvel.com', '$2y$12$mPSLqxHiulinYRp87xzJe.M.EXKRvU0J0pnphqqEN1NQfjS8CDAey', NULL, 4, 0),
(18, 0, 'Jean', 'jack', 'jeanjack@laposte.net', '$2y$12$gnH79yCfgs7JC7KlhXPQ5..EWiSRsGuohIKlgmljC5RuW3pwu3Lfm', NULL, 4, 0),
(19, 0, 'hacker', 'jack', 'ab@ddd.fr', '$2y$12$rzikly7Erw4OjhGTao1pUOf4F.xtNAmxHX5.P4QHNUJUQCKaIR17q', NULL, 4, 0),
(20, 0, 'Matthias', 'jack', 'dqsdqd@qdssqd.com', '$2y$12$C/.vRfP6nUHmVvlPFhDBpuk9GSiqaECO7siNNo4NE5mMvZeeTn50G', NULL, 4, 0),
(21, 0, 'Matthias', 'dupont', 'sqsqs@qsqsq.fr', '$2y$12$7DdGkdRIVBqB4/S2vU9aS.YNCIYIQwLqpnfZsKOXf16AUWy8UBgCC', NULL, 4, 1),
(22, 0, 'qd', 'qdqsd', 'dqsddff@qsfqffdsqqsfq.fr', '$2y$12$Ypm0GWG8Vp3yrvOAVMrKzugOTswIrQ2pOw9YlbH5AO3hk9eeEA0qK', NULL, 4, 0),
(23, 0, 'test', 'terst', 'dsfsdfsdf@sdfsdfdsf.com', '$2y$12$u8tSCK7ZGL1.DxsuIfggAuJkSXH72WK74L/52LMZXkiHq0TkNv1Aq', NULL, 4, 0),
(24, 0, 'test', 'test', 'dfsgtsr@gtgg.fr', '$2y$12$uASe9IptvK/0Tnn4uo745OJ11d87IcrCpzcAhkHousmK2mC0yWYv6', NULL, 4, 0),
(25, 0, 'frffrsdf', 'sqfsqf', 'qff@fqfqfq.fr', '$2y$12$P052uY5G00whEBcxlDZ/zuq.rsAkMn.S6BFOYbUwknlKnPSgN99uK', NULL, 4, 0),
(27, 1, 'Matthias', 'LEROUX', 'matthiasleroux@laposte.net', '$2y$12$sEUpELAswWIP/WUeqGUlN.bwXhDd7Nv983Ws/E2s7ILNKNct/Yntm', 'Tokashi38', 2, 1),
(28, 0, 'George', 'LUCAS', 'georgio@disney.com', '$2y$12$b5LAgLTu7DdBU4eigeWwW.7o4zuiwzWsin3KUCPXlecTPcqpgokNG', '', 3, 0),
(29, 0, 'John', 'Rambo', 'jrambo@adrienne.com', '$2y$12$XAX0s4rd/KVwWaRLg4cTbuYJySgT4Z/fQSKHgRirosUMr.IYPZ1Ey', NULL, 2, 0),
(30, 0, 'Matthias', 'jack', 'youpla@test.com', '$2y$12$yNQMG2Lh0IulxzF5JpUJVeKfbTM.kTwY3E6YNK3kOJMYRKsfRxKG.', NULL, 2, 0),
(31, 0, 'Matthias', 'dupont', 'kikou@tutu.fr', '$2y$12$c1vPrbNQzph2INKZzqvwfOYt/8hRgaA9GyYwKR1uxCPG76AUSY0C6', NULL, 4, 0),
(32, 0, 'Matthias', 'qsdsqd', 'test@test.com', '$2y$12$/Eie7kHi3mN5Lr/uwkPBveLLePxREgcnk1R7ZeLFJgtam.3BdEyFW', NULL, 3, 0),
(33, 0, 'test', 'dupont', 'azerty@g.fr', '$2y$12$bMy7128jgYeV7iLqyCTz3e/9kE83sjfmkoZZ3qcQb9B5MoDYRTmPu', NULL, 3, 0),
(34, 0, 'Darty', 'Boulanger', 'toka@test.com', '$2y$12$bwVbuoPD.mwTby5kHg5xWu3B34IxO1cV1FA4DYDLVl/pxB8B5PZue', 'Tokashi382', 2, 0);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT pour la table `gender`
--
ALTER TABLE `gender`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

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
