-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Hôte : mariadb
-- Généré le : mer. 16 déc. 2020 à 08:53
-- Version du serveur :  10.5.8-MariaDB-1:10.5.8+maria~focal
-- Version de PHP : 7.4.13

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
(23, 'Bonjour à tous! Effectivement ils sont gris.', 1, 17, 36, '2020-12-16 08:17:52', '2020-12-16 08:26:13'),
(24, 'C\'est très interressant!', 1, 16, 36, '2020-12-16 08:27:09', '2020-12-16 08:28:26'),
(25, 'J\'aime particulièrement cet article. Et vous?', 1, 14, 36, '2020-12-16 08:27:52', '2020-12-16 08:28:35'),
(26, 'Ah Vergy!', 1, 15, 36, '2020-12-16 08:31:26', '2020-12-16 08:32:00'),
(27, 'Super!', 1, 11, 36, '2020-12-16 08:31:46', '2020-12-16 08:32:08'),
(28, 'Plutôt blond, non?', 1, 17, 37, '2020-12-16 08:33:21', '2020-12-16 08:48:42'),
(29, 'Je trouve aussi.', 1, 16, 37, '2020-12-16 08:43:53', '2020-12-16 08:44:06'),
(31, 'Moyennement.', 1, 14, 37, '2020-12-16 08:45:21', '2020-12-16 08:45:54'),
(32, 'Il voit loin ;-)', 1, 13, 37, '2020-12-16 08:46:59', '2020-12-16 08:47:13');

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
  `content` varchar(4000) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `modified_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `posts`
--

INSERT INTO `posts` (`id`, `title`, `lead_paragraph`, `content`, `created_date`, `modified_date`, `user_id`) VALUES
(6, 'Rapporter du revenu', 'L’étranger qui arrive', 'Rapporter du revenu est la raison qui décide de tout dans cette petite ville qui vous semblait si jolie. L’étranger qui arrive, séduit par la beauté des fraîches et profondes vallées qui l’entourent, s’imagine d’abord que ses habitants sont sensibles au beau ; ils ne parlent que trop souvent de la beauté de leur pays : on ne peut pas nier qu’ils n’en fassent grand cas ; mais c’est parce qu’elle attire quelques étrangers dont l’argent enrichit les aubergistes, ce qui, par le mécanisme de l’octroi, rapporte du revenu à la ville.\r\n\r\nCe ne fut que dans la nuit du samedi au dimanche, après trois jours de pourparlers, que l’orgueil de l’abbé Maslon plia devant la peur du maire qui se changeait en courage. Il fallut écrire une lettre mielleuse à l’abbé Chélan, pour le prier d’assister à la cérémonie de la relique de Bray-le-Haut, si toutefois son grand âge et ses infirmités le lui permettaient. M. Chélan demanda et obtint une lettre d’invitation pour Julien qui devait l’accompagner en qualité de sous-diacre.\r\n\r\nCette magnificence mélancolique, dégradée par la vue des briques nues et du plâtre encore tout blanc, toucha Julien. Il s’arrêta en silence. À l’autre extrémité de la salle, près de l’unique fenêtre par laquelle le jour pénétrait, il vit un miroir mobile en acajou. Un jeune homme, en robe violette et en surplis de dentelle, mais la tête nue, était arrêté à trois pas de la glace. Ce meuble semblait étrange en un tel lieu, et, sans doute, y avait été apporté de la ville. Julien trouva que le jeune homme avait l’air irrité ; de la main droite il donnait gravement des bénédictions du côté du miroir.', '2020-12-16 07:56:05', '2020-12-16 07:56:05', 27),
(7, 'Projets de mariage', 'De longues confidences', 'Fouqué avait eu des projets de mariage, des amours malheureuses ; de longues confidences à ce sujet avaient rempli les conversations des deux amis. Après avoir trouvé le bonheur trop tôt, Fouqué s’était aperçu qu’il n’était pas seul aimé. Tous ces récits avaient étonné Julien ; il avait appris bien des choses nouvelles. Sa vie solitaire toute d’imagination et de méfiance l’avait éloigné de tout ce qui pouvait l’éclairer.\r\n\r\nQui commandera la garde d’honneur ? M. de Rênal vit tout de suite combien il importait, dans l’intérêt des maisons sujettes à reculer, que M. de Moirod eût ce commandement. Cela pouvait faire titre pour la place de premier adjoint. Il n’y avait rien à dire à la dévotion de M. de Moirod, elle était au-dessus de toute comparaison, mais jamais il n’avait monté à cheval. C’était un homme de trente-six ans, timide de toutes les façons, et qui craignait également les chutes et le ridicule.\r\n\r\nM. de Rênal avait ordonné à Julien de loger chez lui. Personne ne soupçonna ce qui s’était passé. Le troisième jour après son arrivée, Julien vit monter jusque dans sa chambre un non moindre personnage que M. le sous-préfet de Maugiron. Ce ne fut qu’après deux grandes heures de bavardage insipide et de grandes jérémiades sur la méchanceté des hommes, sur le peu de probité des gens chargés de l’administration des deniers publics, sur les dangers de cette pauvre France, etc., etc., que Julien vit poindre enfin le sujet de la visite. On était déjà sur le palier de l’escalier, et le pauvre précepteur à demi disgracié reconduisait avec le respect convenable le futur préfet de quelque heureux département, quand il plut à celui-ci de s’occuper de la fortune de Julien, de louer sa modération en affaires d’intérêt, etc., etc. Enfin M. de Maugiron, le serrant dans ses bras de l’air le plus paterne, lui proposa de quitter M. de Rênal et d’entrer chez un fonctionnaire qui avait des enfants à éduquer, et qui, comme le roi Philippe, remercierait le ciel, non pas tant de les lui avoir donnés que de les avoir fait naître dans le voisinage de M. Julien. Leur précepteur jouirait de huit cents francs d’appointements payables non pas de mois en mois, ce qui n’est pas noble, dit M. de Maugiron, mais par quartier et toujours d’avance.', '2020-12-16 07:56:51', '2020-12-16 07:56:51', 27),
(8, 'Mr de Rênal', 'L\'administrateur', 'Il se trouvait tout aristocrate en ce moment, lui qui pendant longtemps avait été tellement choqué du sourire dédaigneux et de la supériorité hautaine qu’il découvrait au fond de toutes les politesses qu’on lui adressait chez M. de Rênal. Il ne put s’empêcher de sentir l’extrême différence. Oublions même, se disait-il en s’en allant, qu’il s’agit d’argent volé aux pauvres détenus, et encore qu’on empêche de chanter! Jamais M. de Rênal s’avisa-t-il de dire à ses hôtes le prix de chaque bouteille de vin qu’il leur présente ? Et ce M. Valenod, dans l’énumération de ses propriétés, qui revient sans cesse, il ne peut parler de sa maison, de son domaine, etc., si sa femme est présente, sans dire ta maison, ton domaine.\r\n\r\nJulien releva les yeux avec effort, et d’une voix que le battement de cœur rendait tremblante, il expliqua qu’il désirait parler à M. Pirard, le directeur du séminaire. Sans dire une parole, l’homme noir lui fit signe de le suivre. Ils montèrent deux étages par un large escalier à rampe de bois, dont les marches déjetées penchaient tout à fait du côté opposé au mur, et semblaient prêtes à tomber. Une petite porte, surmontée d’une grande croix de cimetière en bois blanc peint en noir, fut ouverte avec difficulté, et le portier le fit entrer dans une chambre sombre et basse, dont les murs blanchis à la chaux étaient garnis de deux grands tableaux noircis par le temps. Là, Julien fut laissé seul ; il était atterré, son cœur battait violemment ; il eût été heureux d’oser pleurer. Un silence de mort régnait dans toute la maison.\r\n\r\nHeureusement pour la réputation de M. de Rênal comme administrateur, un immense mur de soutènement était nécessaire à la promenade publique qui longe la colline à une centaine de pieds au-dessus du cours du Doubs. Elle doit à cette admirable position une des vues les plus pittoresques de France. Mais, à chaque printemps, les eaux de pluie sillonnaient la promenade, y creusaient des ravins et la rendaient impraticable. Cet inconvénient, senti par tous, mit M. de Rênal dans l’heureuse nécessité d’immortaliser son administration par un mur de vingt pieds de hauteur et de trente ou quarante toises de long.', '2020-12-16 07:58:12', '2020-12-16 07:58:12', 27),
(9, 'À Paris', 'Le père Sorel', 'Le père Sorel, car c’était lui, fut très surpris et encore plus content de la singulière proposition que M. de Rênal lui faisait pour son fils Julien. Il ne l’en écouta pas moins avec cet air de tristesse mécontente et de désintérêt dont sait si bien se revêtir la finesse des habitants de ces montagnes. Esclaves du temps de la domination espagnole, ils conservent encore ce trait de la physionomie du fellah de l’Égypte.\r\n\r\nCertaine de l’affection de Julien, peut-être sa vertu eût trouvé des forces contre lui. Tremblante de le perdre à jamais, sa passion l’égara jusqu’au point de reprendre la main de Julien, que, dans sa distraction, il avait laissée appuyée sur le dossier d’une chaise. Cette action réveilla ce jeune ambitieux : il eût voulu qu’elle eût pour témoins tous ces nobles si fiers qui, à table, lorsqu’il était au bas bout avec les enfants, le regardaient avec un sourire si protecteur. Cette femme ne peut plus me mépriser : dans ce cas, se dit-il, je dois être sensible à sa beauté ; je me dois à moi-même d’être son amant. Une telle idée ne lui fût pas venue avant les confidences naïves faites par son ami.\r\n\r\nLe clergé s’impatientait. Il attendait son chef dans le cloître sombre et gothique de l’ancienne abbaye. On avait réuni vingt-quatre curés pour figurer l’ancien chapitre de Bray-le-Haut, composé avant 1789 de vingt-quatre chanoines. Après avoir déploré pendant trois quarts d’heure la jeunesse de l’évêque, les curés pensèrent qu’il était convenable que M. le Doyen se retirât vers Monseigneur pour l’avertir que le roi allait arriver, et qu’il était instant de se rendre au chœur. Le grand âge de M. Chélan l’avait fait doyen ; malgré l’humeur qu’il témoignait à Julien, il lui fit signe de suivre. Julien portait fort bien son surplis. Au moyen de je ne sais quel procédé de toilette ecclésiastique, il avait rendu ses beaux cheveux bouclés très plats ; mais, par un oubli qui redoubla la colère de M. Chélan, sous les longs plis de sa soutane on pouvait apercevoir les éperons du garde d’honneur.', '2020-12-16 07:59:01', '2020-12-16 07:59:01', 27),
(10, 'Cette demande frappa le maire', 'Sorel n’est pas ravi', 'Cette demande frappa le maire. Puisque Sorel n’est pas ravi et comblé de ma proposition, comme naturellement il devrait l’être, il est clair, se dit-il, qu’on lui a fait des offres d’un autre côté ; et de qui peuvent-elles venir, si ce n’est du Valenod ? Ce fut en vain que M. de Rênal pressa Sorel de conclure sur-le-champ : l’astuce du vieux paysan s’y refusa opiniâtrement ; il voulait, disait-il, consulter son fils, comme si, en province, un père riche consultait un fils qui n’a rien, autrement que pour la forme.\r\n\r\nJe ne trouve, quant à moi, qu’une chose à reprendre au cours de la fidélité : on lit ce nom officiel en quinze ou vingt endroits, sur des plaques de marbre qui ont valu une croix de plus M. de Rênal ; ce que je reprocherais au Cours de la Fidélité, c’est la manière barbare dont l’autorité fait tailler et tondre jusqu’au vif ces vigoureux platanes. Au lieu de ressembler par leurs têtes basses, rondes et aplaties, à la plus vulgaire des plantes potagères ils ne demanderaient pas mieux que d’avoir ces formes magnifiques qu’on leur voit en Angleterre. Mais la volonté de M. le maire est despotique, et deux fois par an tous les arbres appartenant à la commune sont impitoyablement amputés. Les libéraux de l’endroit prétendent, mais ils exagèrent, que la main du jardinier officiel est devenue bien plus sévère depuis que M. le vicaire Maslon a pris l’habitude de s’emparer des produits de la tonte.\r\n\r\nFouqué avait eu des projets de mariage, des amours malheureuses ; de longues confidences à ce sujet avaient rempli les conversations des deux amis. Après avoir trouvé le bonheur trop tôt, Fouqué s’était aperçu qu’il n’était pas seul aimé. Tous ces récits avaient étonné Julien ; il avait appris bien des choses nouvelles. Sa vie solitaire toute d’imagination et de méfiance l’avait éloigné de tout ce qui pouvait l’éclairer.', '2020-12-16 07:59:43', '2020-12-16 07:59:43', 27),
(11, 'Les enfants l’adoraient', 'Il fut un bon précepteur', 'Les enfants l’adoraient, lui ne les aimait point ; sa pensée était ailleurs. Tout ce que ces marmots pouvaient faire ne l’impatientait jamais. Froid, juste, impassible, et cependant aimé, parce que son arrivée avait en quelque sorte chassé l’ennui de la maison, il fut un bon précepteur. Pour lui, il n’éprouvait que haine et horreur pour la haute société où il était admis, à la vérité au bas bout de la table, ce qui explique peut-être la haine et l’horreur. Il y eut certains dîners d’apparat, où il put à grande peine contenir sa haine pour tout ce qui l’environnait. Un jour de la Saint-Louis entre autres, M. Valenod tenait le dé chez M. de Rênal, Julien fut sur le point de se trahir ; il se sauva dans le jardin, sous prétexte de voir les enfants. Quels éloges de la probité ! s’écria-t-il ; on dirait que c’est la seule vertu ; et cependant quelle considération, quel respect bas pour un homme qui évidemment a doublé et triplé sa fortune, depuis qu’il administre le bien des pauvres ! je parierais qu’il gagne même sur les fonds destinés aux enfants trouvés, à ces pauvres dont la misère est encore plus sacrée que celle des autres ! Ah ! monstres ! monstres ! Et moi aussi, je suis une sorte d’enfant trouvé, haï de mon père, de mes frères, de toute ma famille.\r\n\r\non acquiert de droits aux respects de ses voisins. Les jardins de M. de Rênal, remplis de murs, sont encore admirés parce qu’il a acheté, au poids de l’or, certains petits morceaux de terrain qu’ils occupent. Par exemple, cette scie à bois, dont la position singulière sur la rive du Doubs vous a frappé en entrant à Verrières, et où vous avez remarqué le nom de Sorel, écrit en caractères gigantesques sur une planche qui domine le toit, elle occupait, il y a six ans, l’espace sur lequel on élève en ce moment le mur de la quatrième terrasse des jardins de M. de Rênal.\r\n\r\nM. de Rênal parlait politique avec colère : deux ou trois industriels de Verrières devenaient décidément plus riches que lui, et voulaient le contrarier dans les élections. Mme Derville l’écoutait, Julien irrité de ces discours approcha sa chaise de celle de Mme de Rênal. L’obscurité cachait tous les mouvements. Il osa placer sa main très près du joli bras que la robe laissait à découvert. Il fut troublé, sa pensée ne fut plus à lui, il approcha sa joue de ce joli bras, il osa y appliquer ses lèvres.', '2020-12-16 08:00:25', '2020-12-16 08:00:25', 27),
(12, 'Commandement', 'Qui commandera la garde d’honneur ?', 'Qui commandera la garde d’honneur ? M. de Rênal vit tout de suite combien il importait, dans l’intérêt des maisons sujettes à reculer, que M. de Moirod eût ce commandement. Cela pouvait faire titre pour la place de premier adjoint. Il n’y avait rien à dire à la dévotion de M. de Moirod, elle était au-dessus de toute comparaison, mais jamais il n’avait monté à cheval. C’était un homme de trente-six ans, timide de toutes les façons, et qui craignait également les chutes et le ridicule.\r\n\r\nPour arriver à la considération publique à Verrières, l’essentiel est de ne pas adopter, tout en bâtissant beaucoup de murs, quelque plan apporté d’Italie par ces maçons, qui au printemps traversent les gorges du Jura pour gagner Paris. Une telle innovation vaudrait à l’imprudent bâtisseur une éternelle réputation de mauvaise tête, et il serait à jamais perdu auprès des gens sages et modérés qui distribuent la considération en Franche-Comté.\r\n\r\nDans le flot de ce monde nouveau pour Julien, il crut découvrir un honnête homme ; il était géomètre, s’appelait Gros et passait pour jacobin. Julien, s’étant voué à ne jamais dire que des choses qui lui semblaient fausses à lui-même, fut obligé de s’en tenir au soupçon à l’égard de M. Gros. Il recevait de Vergy de gros paquets de thèmes. On lui conseillait de voir souvent son père, il se conformait à cette triste nécessité. En un mot, il raccommodait assez bien sa réputation, lorsqu’un matin il fut bien surpris de se sentir réveiller par deux mains qui lui fermaient les yeux.', '2020-12-16 08:01:03', '2020-12-16 08:01:03', 27),
(13, 'Julien releva les yeux', 'Sans dire une parole', 'Julien releva les yeux avec effort, et d’une voix que le battement de cœur rendait tremblante, il expliqua qu’il désirait parler à M. Pirard, le directeur du séminaire. Sans dire une parole, l’homme noir lui fit signe de le suivre. Ils montèrent deux étages par un large escalier à rampe de bois, dont les marches déjetées penchaient tout à fait du côté opposé au mur, et semblaient prêtes à tomber. Une petite porte, surmontée d’une grande croix de cimetière en bois blanc peint en noir, fut ouverte avec difficulté, et le portier le fit entrer dans une chambre sombre et basse, dont les murs blanchis à la chaux étaient garnis de deux grands tableaux noircis par le temps. Là, Julien fut laissé seul ; il était atterré, son cœur battait violemment ; il eût été heureux d’oser pleurer. Un silence de mort régnait dans toute la maison.\r\n\r\nQui commandera la garde d’honneur ? M. de Rênal vit tout de suite combien il importait, dans l’intérêt des maisons sujettes à reculer, que M. de Moirod eût ce commandement. Cela pouvait faire titre pour la place de premier adjoint. Il n’y avait rien à dire à la dévotion de M. de Moirod, elle était au-dessus de toute comparaison, mais jamais il n’avait monté à cheval. C’était un homme de trente-six ans, timide de toutes les façons, et qui craignait également les chutes et le ridicule.\r\n\r\nAucune hypocrisie ne venait altérer la pureté de cette âme naïve, égarée par une passion qu’elle n’avait jamais éprouvée. Elle était trompée, mais à son insu, et cependant un instinct de vertu était effrayé. Tels étaient les combats qui l’agitaient quand Julien parut au jardin. Elle l’entendit parler, presque au même instant elle le vit s’asseoir à ses côtés. Son âme fut comme enlevée par ce bonheur charmant qui depuis quinze jours l’étonnait plus encore qu’il ne la séduisait. Tout était imprévu pour elle. Cependant après quelques instants, il suffit donc, se dit-elle, de la présence de', '2020-12-16 08:02:25', '2020-12-16 08:02:25', 27),
(14, 'Aucune hypocrisie', 'Serai-je toujours un enfant ?', 'Il n’y a qu’un sot, se dit-il, qui soit en colère contre les autres : une pierre tombe parce qu’elle est pesante. Serai-je toujours un enfant ? quand donc aurai-je contracté la bonne habitude de donner de mon âme à ces gens-là juste pour leur argent ? Si je veux être estimé et d’eux et de moi-même, il faut leur montrer que c’est ma pauvreté qui est en commerce avec leur richesse, mais que mon cœur est à mille lieues de leur insolence, et placé dans une sphère trop haute pour être atteint par leurs petites marques de dédain ou de faveur.\r\n\r\nCette magnificence mélancolique, dégradée par la vue des briques nues et du plâtre encore tout blanc, toucha Julien. Il s’arrêta en silence. À l’autre extrémité de la salle, près de l’unique fenêtre par laquelle le jour pénétrait, il vit un miroir mobile en acajou. Un jeune homme, en robe violette et en surplis de dentelle, mais la tête nue, était arrêté à trois pas de la glace. Ce meuble semblait étrange en un tel lieu, et, sans doute, y avait été apporté de la ville. Julien trouva que le jeune homme avait l’air irrité ; de la main droite il donnait gravement des bénédictions du côté du miroir.\r\n\r\nAucune hypocrisie ne venait altérer la pureté de cette âme naïve, égarée par une passion qu’elle n’avait jamais éprouvée. Elle était trompée, mais à son insu, et cependant un instinct de vertu était effrayé. Tels étaient les combats qui l’agitaient quand Julien parut au jardin. Elle l’entendit parler, presque au même instant elle le vit s’asseoir à ses côtés. Son âme fut comme enlevée par ce bonheur charmant qui depuis quinze jours l’étonnait plus encore qu’il ne la séduisait. Tout était imprévu pour elle. Cependant après quelques instants, il suffit donc, se dit-elle, de la présence de', '2020-12-16 08:03:30', '2020-12-16 08:03:30', 27),
(15, 'De retour à Vergy', 'Nuit close', 'De retour à Vergy, Julien ne descendit au jardin que lorsqu’il fut nuit close. Son âme était fatiguée de ce grand nombre d’émotions puissantes qui l’avaient agitée dans cette journée. Que leur dirai-je ? pensait-il avec inquiétude, en songeant aux dames. Il était loin de voir que son âme était précisément au niveau des petites circonstances qui occupent ordinairement tout l’intérêt des femmes. Souvent Julien était inintelligible pour Mme Derville et même pour son amie, et à son tour ne comprenait qu’à demi tout ce qu’elles lui disaient. Tel était l’effet de la force, et si j’ose parler ainsi de la grandeur des mouvements de passion qui bouleversaient l’âme de ce jeune ambitieux. Chez cet être singulier, c’était presque tous les jours tempête.\r\n\r\nOù veut-il en venir, se disait Julien ? Il voyait avec étonnement que, pendant des heures entières, l’abbé Chas lui parlait des ornements possédés par la cathédrale. Elle avait dix-sept chasubles galonnées, outre les ornements de deuil. On espérait beaucoup de la vieille présidente de Rubempré ; cette dame, âgée de quatre-vingt-dix ans, conservait, depuis soixante-dix au moins, ses robes de noce en superbes étoffes de Lyon, brochées d’or. Figurez-vous, mon ami, disait l’abbé Chas en s’arrêtant tout court et ouvrant de grands yeux, que ces étoffes se tiennent droites tant il y a d’or. On croit généralement dans Besançon que, par le testament de la présidente, le trésor de la cathédrale sera augmenté de plus de dix chasubles, sans compter quatre ou cinq chapes pour les grandes fêtes. Je vais plus loin, ajoutait l’abbé Chas en baissant la voix, j’ai des raisons pour penser que la présidente nous laissera huit magnifiques flambeaux d’argent doré, que l’on suppose avoir été achetés en Italie, par le duc de Bourgogne Charles le Téméraire, dont un de ses ancêtres fut le ministre favori.\r\n\r\nDe là le succès du petit paysan Julien. Elle trouva des jouissances douces, et toutes brillantes du charme de la nouveauté, dans la sympathie de cette âme noble et fière. Mme de Rênal lui eut bientôt pardonné son ignorance extrême qui était une grâce de plus, et la rudesse de ses façons qu’elle parvint à corriger. Elle trouva qu’il valait la peine de l’écouter, même quand on parlait des choses les plus communes, même quand il s’agissait d’un pauvre chien écrasé, comme il traversait la rue, par la charrette d’un paysan allant au trot. Le spectacle de cette douleur donnait son gros rire à son mari, tandis qu’elle voyait se contracter les beaux sourcils noirs et si bien arqués de Julien. La générosité, la noblesse d’âme, l’humanité lui semblèrent peu à peu n’exister que chez ce jeune abbé. Elle eut pour lui seul toute la sympathie et même l’admiration que ces vertus excitent chez les âmes bien nées.', '2020-12-16 08:04:15', '2020-12-16 08:04:15', 27),
(16, 'Verrières', 'Franche-Comté', 'Pour arriver à la considération publique à Verrières, l’essentiel est de ne pas adopter, tout en bâtissant beaucoup de murs, quelque plan apporté d’Italie par ces maçons, qui au printemps traversent les gorges du Jura pour gagner Paris. Une telle innovation vaudrait à l’imprudent bâtisseur une éternelle réputation de mauvaise tête, et il serait à jamais perdu auprès des gens sages et modérés qui distribuent la considération en Franche-Comté.\r\n\r\nJulien s’approcha d’elle avec empressement ; il admirait ces bras si beaux qu’un châle jeté à la hâte laissait apercevoir. La fraîcheur de l’air du matin semblait augmenter encore l’éclat d’un teint que l’agitation de la nuit ne rendait que plus sensible à toutes les impressions. Cette beauté modeste et touchante, et cependant pleine de pensées que l’on ne trouve point dans les classes inférieures, semblait révéler à Julien une faculté de son âme qu’il n’avait jamais sentie. Tout entier à l’admiration des charmes que surprenait son regard avide, Julien ne songeait nullement à l’accueil amical qu’il s’attendait à recevoir. Il fut d’autant plus étonné de la froideur glaciale qu’on cherchait à lui montrer, et à travers laquelle il crut même distinguer l’intention de le remettre à sa place.\r\n\r\nCertaine de l’affection de Julien, peut-être sa vertu eût trouvé des forces contre lui. Tremblante de le perdre à jamais, sa passion l’égara jusqu’au point de reprendre la main de Julien, que, dans sa distraction, il avait laissée appuyée sur le dossier d’une chaise. Cette action réveilla ce jeune ambitieux : il eût voulu qu’elle eût pour témoins tous ces nobles si fiers qui, à table, lorsqu’il était au bas bout avec les enfants, le regardaient avec un sourire si protecteur. Cette femme ne peut plus me mépriser : dans ce cas, se dit-il, je dois être sensible à sa beauté ; je me dois à moi-même d’être son amant. Une telle idée ne lui fût pas venue avant les confidences naïves faites par son ami.', '2020-12-16 08:04:50', '2020-12-16 08:04:50', 27),
(17, 'Ses cheveux sont grisonnants', 'Vêtu de gris', 'À son aspect tous les chapeaux se lèvent rapidement. Ses cheveux sont grisonnants, et il est vêtu de gris. Il est chevalier de plusieurs ordres, il a un grand front, un nez aquilin, et au total sa figure ne manque pas d’une certaine régularité : on trouve même, au premier aspect, qu’elle réunit à la dignité du maire de village cette sorte d’agrément qui peut encore se rencontrer avec quarante-huit ou cinquante ans. Mais bientôt le voyageur parisien est choqué d’un certain air de contentement de soi et de suffisance mêlé à je ne sais quoi de borné et de peu inventif. On sent enfin que le talent de cet homme-là se borne à se faire payer bien exactement ce qu’on lui doit, et à payer lui-même le plus tard possible quand il doit.\r\n\r\nQuelques jours avant la Saint-Louis, Julien, se promenant seul et disant son bréviaire dans un petit bois, qu’on appelle le Belvédère, et qui domine le Cours de la Fidélité, avait cherché en vain à éviter ses deux frères, qu’il voyait venir de loin par un sentier solitaire. La jalousie de ces ouvriers grossiers avait été tellement provoquée par le bel habit noir, par l’air extrêmement propre de leur frère, par le mépris sincère qu’il avait pour eux, qu’ils l’avaient battu au point de le laisser évanoui et tout sanglant. Mme de Rênal, se promenant avec M. Valenod et le sous-préfet, arriva par hasard dans le petit bois ; elle vit Julien étendu sur la terre et le crut mort. Son saisissement fut tel, qu’il donna de la jalousie à M. Valenod.\r\n\r\nUne scie à eau se compose d’un hangar au bord d’un ruisseau. Le toit est soutenu par une charpente qui porte sur quatre gros piliers en bois. À huit ou dix pieds d’élévation, au milieu du hangar, on voit une scie qui monte et descend, tandis qu’un mécanisme fort simple pousse contre cette scie une pièce de bois. C’est une roue mise en mouvement par le ruisseau qui fait aller ce double mécanisme ; celui de la scie qui monte et descend, et celui qui pousse doucement la pièce de bois vers la scie, qui la débite en planches.', '2020-12-16 08:05:25', '2020-12-16 08:05:25', 27);

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
  `valid` int(11) NOT NULL DEFAULT 0,
  `valid_by_mail` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `admin`, `first_name`, `last_name`, `email`, `password`, `pseudo`, `gender_id`, `valid`, `valid_by_mail`) VALUES
(27, 1, 'Matthias', 'LEROUX', 'matthiasleroux@laposte.net', '$2y$12$18CDf9z/HelChnJZ3CwoLeb15z2UfNULBWjUQa0CwM.4r7F8fqlwW', 'Tokashi381', 3, 1, 0),
(36, 0, 'Eddie', 'Ruiz', 'eddie.ruiz@example.com', '$2y$12$JJdheZwfxsMYgvlghtfudOZ59g7dyn0o.zf3dR6l4MJW9HQpO.6Ya', 'Eddie45', 3, 1, 0),
(37, 0, 'Billie', 'Miller', 'billie.miller@example.com', '$2y$12$rklBjR4olizw191UFu3.6ewPjYP/wq/gccsto3UR0/wFJInqYfBUi', 'Billie56', 2, 1, 0);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT pour la table `gender`
--
ALTER TABLE `gender`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

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
