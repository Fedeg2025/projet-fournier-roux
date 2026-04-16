-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : jeu. 16 avr. 2026 à 08:37
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `fournier_roux_db`
--

-- --------------------------------------------------------

--
-- Structure de la table `appartient`
--

CREATE TABLE `appartient` (
  `id_article` int(11) NOT NULL,
  `id_categorie` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `appartient`
--

INSERT INTO `appartient` (`id_article`, `id_categorie`) VALUES
(15, 1),
(15, 5),
(18, 1),
(18, 4),
(18, 5),
(18, 6),
(19, 1),
(19, 3),
(19, 5),
(19, 6),
(20, 1),
(20, 2),
(20, 3),
(23, 1),
(23, 4),
(23, 5),
(23, 6);

-- --------------------------------------------------------

--
-- Structure de la table `articles`
--

CREATE TABLE `articles` (
  `id_article` int(11) NOT NULL AUTO_INCREMENT,
  `titre` varchar(255) NOT NULL,
  `contenu` text NOT NULL,
  `date_publication` datetime NOT NULL DEFAULT current_timestamp(),
  `id_utilisateur` int(11) NOT NULL,
  PRIMARY KEY (`id_article`),
  KEY `id_utilisateur` (`id_utilisateur`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
--
-- Structure de la table `media`
--

CREATE TABLE `media` (
  `id_media` int(11) NOT NULL AUTO_INCREMENT,
  `nom_fichier` varchar(255) NOT NULL,
  `date_upload` datetime DEFAULT current_timestamp(),
  `type_media` varchar(50) DEFAULT 'image',
  PRIMARY KEY (`id_media`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `media` (`id_media`, `nom_fichier`, `date_upload`, `type_media`) VALUES
(1, '69e08c45748ea_art1.webp', '2026-03-30 18:42:41', 'image/webp'),
(2, '69e08c35b9105_art2.webp', '2026-04-10 11:32:53', 'image/webp'),
(3, '69e08c0102576_img5.webp', '2026-04-10 11:47:35', 'image/webp'),
(4, '69e08bc34c3ab_art4.webp', '2026-04-10 12:04:12', 'image/webp'),
(5, '69e08c2108718_articulo3.webp', '2026-04-10 12:24:33', 'image/webp'),
(25, 'article_69e14ecf15a83.54544840_Capture_d’écran.png', '2026-04-16 23:04:15', 'image'),
(26, 'article_69e14ecf237a5.66882719_modifinal.png', '2026-04-16 23:04:15', 'image'),
(27, 'article_69e14ecf2c279.00670094_Capture_d’écran.png', '2026-04-16 23:04:15', 'image'),
(28, 'article_69e14ecf3f149.46146053_Capture_d’écran.png', '2026-04-16 23:04:15', 'image'),
(29, 'article_69e14fdb86e7b8.87636310_basededonnes.png', '2026-04-16 23:08:43', 'image'),
(30, 'article_69e14fdb879307.10314715_Capture_d’écran.png', '2026-04-16 23:08:43', 'image');

-- --------------------------------------------------------
--
-- Structure de la table `contient`
--

CREATE TABLE `contient` (
  `id_article` int(11) NOT NULL,
  `id_media` int(11) NOT NULL,
  `ordre` int(11) DEFAULT 1,
  `image_principale` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`id_article`, `id_media`),
  KEY `id_media` (`id_media`),
  CONSTRAINT `contient_ibfk_1` FOREIGN KEY (`id_article`) REFERENCES `articles` (`id_article`) ON DELETE CASCADE,
  CONSTRAINT `contient_ibfk_2` FOREIGN KEY (`id_media`) REFERENCES `media` (`id_media`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `articles`
--

INSERT INTO `articles` (`id_article`, `titre`, `contenu`, `date_publication`, `id_utilisateur`) VALUES
(15, 'Le Fournier roux est-il en danger ? : une espèce d’oiseau invasive menace son existence', 'L’Étourneau sansonnet est une espèce d’oiseau qui niche dans des cavités, originaire d’Eurasie et d’Afrique du Nord, et qui a envahi une grande partie de l’Amérique latine.\r\n\r\nDes scientifiques de l’Université nationale de La Plata étudient les comportements de l’Étourneau sansonnet, un oiseau invasif qui se propage rapidement en Amérique du Sud, en particulier en Argentine, causant de graves dommages à l’écosystème. Le pic et le Fournier roux de la région sont en concurrence pour les ressources.\r\n\r\nL’étourneau sansonnet est un passereau qui niche dans des cavités, originaire d’Eurasie et d’Afrique du Nord, et qui a envahi l’Océanie ainsi que l’Amérique du Nord, centrale et du Sud. Dans cette dernière région, l’invasion est relativement récente, puisque les premiers signalements remontent au début des années 1980 dans la ville de Montevideo.\r\n\r\n« Les espèces exotiques entrent en compétition avec les espèces autochtones pour les ressources. Le transport et l’introduction d’une espèce dans un nouvel environnement constituent toujours la première étape du processus d’invasion. Cependant, la dernière phase du processus, c’est-à-dire le fait que l’espèce s’établisse avec une population qui croît et se propage, dépend de plusieurs facteurs », a expliqué le docteur en sciences naturelles Adrián Jauregui, directeur du projet et membre du laboratoire d’écologie des oiseaux de l’Institut de limnologie « Dr. Raúl A. Ringuelet », rattaché à l’Université nationale de La Plata et au CONICET.', '2026-03-30 18:42:41', 5),
(18, 'Le Fournier roux grandit, se renouvélle et devient de plus en plus néotropical', 'Le Fournier roux grandit, se renouvèle et devient de plus en plus néo tropical\r\nPar Sergio A. Lambertucci\r\n\r\nLa commercialisation des publications scientifiques, dominée par de grandes maisons d’édition qui imposent des frais pour publier ou accéder aux articles, accentue les inégalités, notamment dans la région néo tropicale. En Amérique latine, les couts des revues internationales en accès libre sont souvent prohibitifs, d’autant plus que le financement de la recherche et des institutions académiques diminue, rendant la publication encore plus difficile, surtout pour les jeunes chercheurs.\r\n\r\nDans ce contexte, les revues d’associations comme le Fournier roux jouent un rôle essentiel : elles permettent de diffuser des travaux scientifiques d’intérêt régional sans frais pour les auteurs ni pour les lecteurs. Ces revues, de plus en plus rares, sont donc fondamentales et méritent d’être soutenues.\r\n\r\nAprès quatre années en tant que rédacteur en chef, une nouvelle étape commence. L’objectif a toujours été de renouveler la revue afin d’intégrer de nouvelles idées et perspectives, garantissant ainsi sa croissance continue.\r\n\r\nEnfin, ce projet repose sur un large groupe de collaborateurs — éditeurs, réviseurs, traducteurs et illustrateurs — dont le travail, souvent bénévole, a permis d’améliorer la qualité des publications et d’assurer le bon fonctionnement de la revue.', '2026-04-10 11:32:53', 5),
(19, 'Le Fournier roux, précurseur de l’adobe', 'Architectes incomparables, les Fournier roux construisent leurs nids de manière à ce qu’ils puissent durer presque 100 ans.\r\n\r\n\r\nLe Fournier roux commun (Furnarius rufus) est le seul oiseau qui construit son nid entièrement en boue, avec des notions d’architecture et des “calculs” qui le rendent résistant à l’eau et au passage du temps. C’est l’être humain qui s’est inspiré de sa méthode de construction pour créer l’adobe, puis bâtir ses habitations. Il est un symbole de persévérance et de travail, et il est endémique des régions les plus australes de l’Amérique du Sud.\r\n\r\nIl est l’oiseau national de l’Uruguay depuis 1928. Son image a été représentée sur une pièce de monnaie uruguayenne d’un demi-centavo austral, frappée en 1985, et à partir de 2017 sur le billet de mille pesos.\r\n\r\nFurnarius rufus signifie quelque chose comme « four rouge », en référence à la forme du nid qu’il construit et à la couleur de son plumage. Le Fournier roux se prépare à construire sa maison après la saison des pluies. Il utilise de la boue, de la paille et des crins de cheval, qu’il malaxe avec son bec pour former de petites boules qu’il dispose comme des briques. « Le nid est construit avec son partenaire et achevé en quelques jours. À l’intérieur, ils placent un lit de petites plumes où ils déposent ensuite leurs œufs », explique le biologiste Roberto Salinas à Catamarca/12.\r\n\r\nLa structure est si solide, une fois sèche et durcie, qu’elle peut résister à des conditions climatiques difficiles et rester en bon état pendant des années. Cependant, selon certaines études, cet oiseau n’utilise pas le même nid à chaque ponte. C’est pourquoi on peut parfois observer des constructions superposées, comme un véritable immeuble. Chaque nid peut peser jusqu’à 5 kilos.\r\n\r\nSes nids sont ensuite occupés par d’autres oiseaux, et même par des belettes qui apprécient ces refuges pour élever leurs petits et se protéger des prédateurs.\r\n\r\n« Il s’agit d’un oiseau péridomestique. On peut les voir nicher sous les toits ou près des fenêtres des maisons, ce qui peut donner l’impression qu’ils sont dociles. En réalité, ils vivent simplement à proximité de l’homme. Si quelqu’un les capture et les met en cage, ils meurent ou se blessent en se heurtant aux barreaux. Ce n’est pas une espèce domestiquable », explique le biologiste Roberto Salinas.\r\n\r\nLe Fournier roux est monogame et peut vivre toute sa vie avec le même partenaire. Ensemble, ils construisent le nid, élèvent les petits et couvent les œufs sans distinction de rôles.\r\n\r\nLa principale menace du Fournier roux est naturelle : les tordos (vachers). Ces oiseaux observent attentivement leur comportement afin de leur voler leur nid. Lorsque le Fournier roux a pondu ses œufs, le tordo attend qu’il quitte son nid pour y entrer et y déposer les siens. Parfois, il laisse quelques œufs déjà présents, mais le plus souvent il les éjecte pour les remplacer par les siens.\r\n\r\nUne fois les petits tordos éclos, le Fournier roux travaille sans relâche pour satisfaire leurs besoins alimentaires, bien plus importants. Quand ils sont prêts à voler, leurs vrais parents viennent les chercher en les appelant avec un chant spécifique, et ils quittent alors le couple de Fournier roux qui les a élevés.\r\n\r\nLe Fournier roux a bénéficié de la présence humaine, devenant un élément central de nombreuses légendes et chansons du folklore sud-américain. De plus, les agriculteurs l’apprécient, car il protège les cultures contre les insectes nuisibles.', '2026-04-10 11:47:35', 5),
(20, 'Le Fournier roux qui coexiste avec la figure de José Gervasio Artigas', 'Lors d’un discours officiel, le chef de la police a souligné un message inspiré de la nature : l’importance de pouvoir « construire notre foyer en paix ».\r\n\r\nDans le monument au héros, situé précisément sur la place Artigas de Montevideo, sur le chapeau que tient dans sa main droite le Général, un Fournier roux a construit son nid. Coïncidence ou confirmation visuelle de cette idée évoquée dans son discours ?\r\n\r\n« Enfin, souligner un message que nous donne la nature : que nous puissions tous construire notre foyer en paix », a-t-il ainsi conclu son intervention lors d’un nouvel anniversaire de la mort de José Gervasio Artigas.\r\n\r\nLe chef de police, Insp. Gén. (r) Washington Curbelo Martínez. Bien qu’il ait présenté cette phrase comme improvisée, elle figurait déjà dans son discours. Reste à savoir s’il s’agissait d’une coïncidence ou s’il avait remarqué auparavant ce nid construit par un Fournier roux sur le chapeau d’Artigas — une image qui illustre parfaitement cette idée de vivre et construire en paix.\r\n\r\nIl y a peu de temps, la présidente argentine Cristina Fernández de Kirchner a déclaré qu’Artigas avait voulu être argentin mais qu’on ne l’avait pas laissé. À cela, l’ancien président uruguayen José Mujica a répondu : « C’est encore une ruse des voisins argentins, comme toujours, essayant de s’approprier notre belle histoire en tant qu’Uruguayens. Cela ne leur suffit pas de vouloir nous voler Carlos Gardel et le dulce de leche, maintenant ils veulent aussi nos héros. »\r\n\r\nSavez-vous de quel pays le Fournier roux est l’oiseau national ? De l’Uruguay.', '2026-04-10 12:04:12', 5),
(23, 'Le Fournier roux : un oiseau météorologue ?', 'Club de science\r\n\r\nExplorateurs de la nature\r\n\r\nParticipants:\r\n\r\nJulieta Guridi, Yamila Freitas et Faustina Rodríguez\r\n\r\nEncadrante\r\nCarla Acuña\r\n\r\nInstitution\r\n\r\nÉcole n° 9 Général Aparicio Saravia, Tupambaé, CERRO LARGO\r\n\r\nNotre recherche a commencé en juillet 2022 ; les Fournier roux construisaient leurs nids au sol ou dans des zones très basses. La population de notre région était préoccupée, car elle entretient la croyance suivante : si le Fournier roux construit son nid en zones basses, il y aura sècheresse, et en zones élevées, les pluies seront abondantes. C’est pour cette raison qu’on l’appelle « l’oiseau météorologue ».\r\n\r\nAinsi est née la question : est-il vrai que le Fournier roux peut prédire le temps selon l’endroit où il construit son nid, ou existe-t-il d’autres causes ? On pense que cela pourrait être possible parce qu’il construit ses nids en zones basses en raison du manque d’eau, et que le vent facilite la construction au sol.\r\n\r\nNotre objectif est d’étudier s’il est vrai que ces oiseaux construisent leurs nids en fonction des conditions météorologiques futures. Au cours de la recherche, des informations ont été recueillies sur les connaissances de la population et des spécialistes des oiseaux ont été consultés.\r\n\r\nAprès analyse des données obtenues, on peut conclure que, bien qu’il existe une certaine coïncidence, notre pays a connu une sècheresse. Cela ne constitue pas une preuve suffisante pour affirmer que le Fournier roux peut prédire le temps ; davantage de données et plusieurs années d’observation sont nécessaires.\r\n\r\nLa recherche d’informations n’a pas été concluante : il existe encore un manque de connaissances concernant les raisons pour lesquelles le Fournier roux choisit l’emplacement de son nid.', '2026-04-10 12:24:33', 5);

-- --------------------------------------------------------

INSERT INTO `contient` (`id_article`, `id_media`, `ordre`, `image_principale`) VALUES
(15, 1, 1, 1),
(18, 2, 1, 1),
(19, 3, 1, 1),
(20, 4, 1, 1),
(23, 5, 1, 1);

--
-- Structure de la table `categorie`
--

CREATE TABLE `categorie` (
  `id_categorie` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `categorie`
--

INSERT INTO `categorie` (`id_categorie`, `nom`) VALUES
(1, 'Actualités'),
(2, 'Événements'),
(3, 'Culture'),
(4, 'Science'),
(5, 'Ornithologie'),
(6, 'Nature');

-- --------------------------------------------------------

--
-- Structure de la table `messages`
--

CREATE TABLE `messages` (
  `id_message` int(11) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `date_envoi` datetime NOT NULL DEFAULT current_timestamp(),
  `civilite` enum('M','Mme','Autre') NOT NULL,
  `objet` varchar(255) NOT NULL,
  `id_utilisateur` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

CREATE TABLE `utilisateurs` (
  `id_utilisateur` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mot_de_passe` varchar(255) NOT NULL,
  `role` enum('admin','utilisateur') NOT NULL,
  `prenom` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id_utilisateur`, `nom`, `email`, `mot_de_passe`, `role`, `prenom`) VALUES
(5, 'Garcia Herwig', 'fgh.surf32@gmail.com', '$2y$10$PecIsHfzAoRv5RkTyutEA.iizv.ag7ereUzWts24jQ8VrCxsD82nm', 'admin', 'Federico'),
(8, 'Derian', 'claire.derian@gmail.com', '$2y$10$MLfbhvdI3trYiDv1JV.tqOe31dVDTUI3.1RtVNsJ99YpIdblNv2Ky', 'utilisateur', 'Claire Raymonde'),
(13, 'Garcia herwig', 'fgh.surf@gmail.com', '$2y$10$br60tHml9DS3L7L/dOM1ve4o0Qkmgo4PTlBHY3nCcpAgekFXySeca', 'utilisateur', 'Pepe'),
(14, 'Admin', 'admin@test.com', '$2y$10$qfb9qRFIXltvPX6aHY0T0OfPUUu/OJc6MF09InE8ssl0GVIWWVvgG', 'admin', 'Super'),
(15, 'juancito', 'fgh.surf31@gmail.com', '$2y$10$4VyHnI3ntj8bpOdtpVxiluhfZQGM3wdNl4DgGdKx0P2.6yGbyc09.', 'utilisateur', 'Gutierrez');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `appartient`
--
ALTER TABLE `appartient`
  ADD PRIMARY KEY (`id_article`,`id_categorie`),
  ADD KEY `id_categorie` (`id_categorie`);

--
-- Index pour la table `categorie`
--
ALTER TABLE `categorie`
  ADD PRIMARY KEY (`id_categorie`);

--
-- Index pour la table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id_message`),
  ADD KEY `fk_messages_utilisateur` (`id_utilisateur`);

--
-- Index pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD PRIMARY KEY (`id_utilisateur`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `categorie`
--
ALTER TABLE `categorie`
  MODIFY `id_categorie` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `messages`
--
ALTER TABLE `messages`
  MODIFY `id_message` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  MODIFY `id_utilisateur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `appartient`
--
ALTER TABLE `appartient`
  ADD CONSTRAINT `appartient_ibfk_1` FOREIGN KEY (`id_article`) REFERENCES `articles` (`id_article`),
  ADD CONSTRAINT `appartient_ibfk_2` FOREIGN KEY (`id_categorie`) REFERENCES `categorie` (`id_categorie`);

--
-- Contraintes pour la table `articles`
--
ALTER TABLE `articles`
  ADD CONSTRAINT `articles_ibfk_1` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateurs` (`id_utilisateur`);

--
-- Contraintes pour la table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `fk_messages_utilisateur` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateurs` (`id_utilisateur`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
