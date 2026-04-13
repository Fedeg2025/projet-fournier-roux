
-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : lun. 13 avr. 2026 à 18:04
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";
SET FOREIGN_KEY_CHECKS = 0;


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `fournier_roux_db`
--

--
-- Tronquer la table avant d'insérer `appartient`
--

TRUNCATE TABLE `appartient`;
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

--
-- Tronquer la table avant d'insérer `articles`
--

TRUNCATE TABLE `articles`;
--
-- Déchargement des données de la table `articles`
--

INSERT INTO `articles` (`id_article`, `titre`, `contenu`, `date_publication`, `id_utilisateur`) VALUES
(15, 'Le Fournier roux est-il en danger ? : une espèce d’oiseau invasive menace son existence', 'L’Étourneau sansonnet est une espèce d’oiseau qui niche dans des cavités, originaire d’Eurasie et d’Afrique du Nord, et qui a envahi une grande partie de l’Amérique latine.\r\n\r\nDes scientifiques de l’Université nationale de La Plata étudient les comportements de l’Étourneau sansonnet, un oiseau invasif qui se propage rapidement en Amérique du Sud, en particulier en Argentine, causant de graves dommages à l’écosystème. Le pic et le Fournier roux de la région sont en concurrence pour les ressources.\r\n\r\nL’étourneau sansonnet est un passereau qui niche dans des cavités, originaire d’Eurasie et d’Afrique du Nord, et qui a envahi l’Océanie ainsi que l’Amérique du Nord, centrale et du Sud. Dans cette dernière région, l’invasion est relativement récente, puisque les premiers signalements remontent au début des années 1980 dans la ville de Montevideo.\r\n\r\n« Les espèces exotiques entrent en compétition avec les espèces autochtones pour les ressources. Le transport et l’introduction d’une espèce dans un nouvel environnement constituent toujours la première étape du processus d’invasion. Cependant, la dernière phase du processus, c’est-à-dire le fait que l’espèce s’établisse avec une population qui croît et se propage, dépend de plusieurs facteurs », a expliqué le docteur en sciences naturelles Adrián Jauregui, directeur du projet et membre du laboratoire d’écologie des oiseaux de l’Institut de limnologie « Dr. Raúl A. Ringuelet », rattaché à l’Université nationale de La Plata et au CONICET.', '2026-03-30 18:42:41', 5),
(18, 'Le Fournier roux grandit, se renouvélle et devient de plus en plus néotropical', 'Le Fournier roux grandit, se renouvèle et devient de plus en plus néo tropical\r\nPar Sergio A. Lambertucci\r\n\r\nLa commercialisation des publications scientifiques, dominée par de grandes maisons d’édition qui imposent des frais pour publier ou accéder aux articles, accentue les inégalités, notamment dans la région néo tropicale. En Amérique latine, les couts des revues internationales en accès libre sont souvent prohibitifs, d’autant plus que le financement de la recherche et des institutions académiques diminue, rendant la publication encore plus difficile, surtout pour les jeunes chercheurs.\r\n\r\nDans ce contexte, les revues d’associations comme le Fournier roux jouent un rôle essentiel : elles permettent de diffuser des travaux scientifiques d’intérêt régional sans frais pour les auteurs ni pour les lecteurs. Ces revues, de plus en plus rares, sont donc fondamentales et méritent d’être soutenues.\r\n\r\nAprès quatre années en tant que rédacteur en chef, une nouvelle étape commence. L’objectif a toujours été de renouveler la revue afin d’intégrer de nouvelles idées et perspectives, garantissant ainsi sa croissance continue.\r\n\r\nEnfin, ce projet repose sur un large groupe de collaborateurs — éditeurs, réviseurs, traducteurs et illustrateurs — dont le travail, souvent bénévole, a permis d’améliorer la qualité des publications et d’assurer le bon fonctionnement de la revue.', '2026-04-10 11:32:53', 5),
(19, 'Le Fournier roux, précurseur de l’adobe', 'Architectes incomparables, les Fournier roux construisent leurs nids de manière à ce qu’ils puissent durer presque 100 ans.\r\n\r\n\r\nLe Fournier roux commun (Furnarius rufus) est le seul oiseau qui construit son nid entièrement en boue, avec des notions d’architecture et des “calculs” qui le rendent résistant à l’eau et au passage du temps. C’est l’être humain qui s’est inspiré de sa méthode de construction pour créer l’adobe, puis bâtir ses habitations. Il est un symbole de persévérance et de travail, et il est endémique des régions les plus australes de l’Amérique du Sud.\r\n\r\nIl est l’oiseau national de l’Uruguay depuis 1928. Son image a été représentée sur une pièce de monnaie uruguayenne d’un demi-centavo austral, frappée en 1985, et à partir de 2017 sur le billet de mille pesos.\r\n\r\nFurnarius rufus signifie quelque chose comme « four rouge », en référence à la forme du nid qu’il construit et à la couleur de son plumage. Le Fournier roux se prépare à construire sa maison après la saison des pluies. Il utilise de la boue, de la paille et des crins de cheval, qu’il malaxe avec son bec pour former de petites boules qu’il dispose comme des briques. « Le nid est construit avec son partenaire et achevé en quelques jours. À l’intérieur, ils placent un lit de petites plumes où ils déposent ensuite leurs œufs », explique le biologiste Roberto Salinas à Catamarca/12.\r\n\r\nLa structure est si solide, une fois sèche et durcie, qu’elle peut résister à des conditions climatiques difficiles et rester en bon état pendant des années. Cependant, selon certaines études, cet oiseau n’utilise pas le même nid à chaque ponte. C’est pourquoi on peut parfois observer des constructions superposées, comme un véritable immeuble. Chaque nid peut peser jusqu’à 5 kilos.\r\n\r\nSes nids sont ensuite occupés par d’autres oiseaux, et même par des belettes qui apprécient ces refuges pour élever leurs petits et se protéger des prédateurs.\r\n\r\n« Il s’agit d’un oiseau péridomestique. On peut les voir nicher sous les toits ou près des fenêtres des maisons, ce qui peut donner l’impression qu’ils sont dociles. En réalité, ils vivent simplement à proximité de l’homme. Si quelqu’un les capture et les met en cage, ils meurent ou se blessent en se heurtant aux barreaux. Ce n’est pas une espèce domestiquable », explique le biologiste Roberto Salinas.\r\n\r\nLe Fournier roux est monogame et peut vivre toute sa vie avec le même partenaire. Ensemble, ils construisent le nid, élèvent les petits et couvent les œufs sans distinction de rôles.\r\n\r\nLa principale menace du Fournier roux est naturelle : les tordos (vachers). Ces oiseaux observent attentivement leur comportement afin de leur voler leur nid. Lorsque le Fournier roux a pondu ses œufs, le tordo attend qu’il quitte son nid pour y entrer et y déposer les siens. Parfois, il laisse quelques œufs déjà présents, mais le plus souvent il les éjecte pour les remplacer par les siens.\r\n\r\nUne fois les petits tordos éclos, le Fournier roux travaille sans relâche pour satisfaire leurs besoins alimentaires, bien plus importants. Quand ils sont prêts à voler, leurs vrais parents viennent les chercher en les appelant avec un chant spécifique, et ils quittent alors le couple de Fournier roux qui les a élevés.\r\n\r\nLe Fournier roux a bénéficié de la présence humaine, devenant un élément central de nombreuses légendes et chansons du folklore sud-américain. De plus, les agriculteurs l’apprécient, car il protège les cultures contre les insectes nuisibles.', '2026-04-10 11:47:35', 5),
(20, 'Le Fournier roux qui coexiste avec la figure de José Gervasio Artigas', 'Lors d’un discours officiel, le chef de la police a souligné un message inspiré de la nature : l’importance de pouvoir « construire notre foyer en paix ».\r\n\r\nDans le monument au héros, situé précisément sur la place Artigas de Montevideo, sur le chapeau que tient dans sa main droite le Général, un Fournier roux a construit son nid. Coïncidence ou confirmation visuelle de cette idée évoquée dans son discours ?\r\n\r\n« Enfin, souligner un message que nous donne la nature : que nous puissions tous construire notre foyer en paix », a-t-il ainsi conclu son intervention lors d’un nouvel anniversaire de la mort de José Gervasio Artigas.\r\n\r\nLe chef de police, Insp. Gén. (r) Washington Curbelo Martínez. Bien qu’il ait présenté cette phrase comme improvisée, elle figurait déjà dans son discours. Reste à savoir s’il s’agissait d’une coïncidence ou s’il avait remarqué auparavant ce nid construit par un Fournier roux sur le chapeau d’Artigas — une image qui illustre parfaitement cette idée de vivre et construire en paix.\r\n\r\nIl y a peu de temps, la présidente argentine Cristina Fernández de Kirchner a déclaré qu’Artigas avait voulu être argentin mais qu’on ne l’avait pas laissé. À cela, l’ancien président uruguayen José Mujica a répondu : « C’est encore une ruse des voisins argentins, comme toujours, essayant de s’approprier notre belle histoire en tant qu’Uruguayens. Cela ne leur suffit pas de vouloir nous voler Carlos Gardel et le dulce de leche, maintenant ils veulent aussi nos héros. »\r\n\r\nSavez-vous de quel pays le Fournier roux est l’oiseau national ? De l’Uruguay.', '2026-04-10 12:04:12', 5),
(23, 'Le Fournier roux : un oiseau météorologue ?', 'Club de science\r\n\r\nExplorateurs de la nature\r\n\r\nParticipants:\r\n\r\nJulieta Guridi, Yamila Freitas et Faustina Rodríguez\r\n\r\nEncadrante\r\nCarla Acuña\r\n\r\nInstitution\r\n\r\nÉcole n° 9 Général Aparicio Saravia, Tupambaé, CERRO LARGO\r\n\r\nNotre recherche a commencé en juillet 2022 ; les Fournier roux construisaient leurs nids au sol ou dans des zones très basses. La population de notre région était préoccupée, car elle entretient la croyance suivante : si le Fournier roux construit son nid en zones basses, il y aura sècheresse, et en zones élevées, les pluies seront abondantes. C’est pour cette raison qu’on l’appelle « l’oiseau météorologue ».\r\n\r\nAinsi est née la question : est-il vrai que le Fournier roux peut prédire le temps selon l’endroit où il construit son nid, ou existe-t-il d’autres causes ? On pense que cela pourrait être possible parce qu’il construit ses nids en zones basses en raison du manque d’eau, et que le vent facilite la construction au sol.\r\n\r\nNotre objectif est d’étudier s’il est vrai que ces oiseaux construisent leurs nids en fonction des conditions météorologiques futures. Au cours de la recherche, des informations ont été recueillies sur les connaissances de la population et des spécialistes des oiseaux ont été consultés.\r\n\r\nAprès analyse des données obtenues, on peut conclure que, bien qu’il existe une certaine coïncidence, notre pays a connu une sècheresse. Cela ne constitue pas une preuve suffisante pour affirmer que le Fournier roux peut prédire le temps ; davantage de données et plusieurs années d’observation sont nécessaires.\r\n\r\nLa recherche d’informations n’a pas été concluante : il existe encore un manque de connaissances concernant les raisons pour lesquelles le Fournier roux choisit l’emplacement de son nid.', '2026-04-10 12:24:33', 5);

--
-- Tronquer la table avant d'insérer `categorie`
--

TRUNCATE TABLE `categorie`;
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

--
-- Tronquer la table avant d'insérer `contient`
--

TRUNCATE TABLE `contient`;
--
-- Déchargement des données de la table `contient`
--

INSERT INTO `contient` (`id_article`, `id_media`) VALUES
(15, 13),
(15, 16),
(15, 17),
(18, 18),
(19, 19),
(20, 20),
(23, 24);

--
-- Tronquer la table avant d'insérer `media`
--

TRUNCATE TABLE `media`;
--
-- Déchargement des données de la table `media`
--

INSERT INTO `media` (`id_media`, `nom_fichier`, `date_upload`, `type_media`) VALUES
(13, '69caa8011723f_img3.webp', '2026-03-30 18:42:41', 'image'),
(16, '69d8c1c1d3cb3_art2.webp', '2026-04-10 11:24:17', 'image'),
(17, '69d8c1ddcfe5d_art2.webp', '2026-04-10 11:24:45', 'image'),
(18, '69d8c3d5947af_art2.webp', '2026-04-10 11:33:09', 'image'),
(19, '69d8c74ae2981_art3.webp', '2026-04-10 11:47:54', 'image'),
(20, '69d8cb93524f9_art4.webp', '2026-04-10 12:06:11', 'image'),
(21, '69d8cd8c0fe75_art3.webp', '2026-04-10 12:14:36', 'image'),
(22, '69d8cd9c75d88_art3.webp', '2026-04-10 12:14:52', 'image'),
(23, '69d8ce299dd44_art3.1.webp', '2026-04-10 12:17:13', 'image'),
(24, '69d8cfe18f4b2_articulo3.webp', '2026-04-10 12:24:33', 'image');

--
-- Tronquer la table avant d'insérer `messages`
--

TRUNCATE TABLE `messages`;
--
-- Tronquer la table avant d'insérer `utilisateurs`
--

TRUNCATE TABLE `utilisateurs`;
--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id_utilisateur`, `nom`, `email`, `mot_de_passe`, `role`, `prenom`) VALUES
(5, 'Garcia', 'fgh.surf32@gmail.com', '$2y$10$PecIsHfzAoRv5RkTyutEA.iizv.ag7ereUzWts24jQ8VrCxsD82nm', 'admin', 'Federico'),
(8, 'Derian', 'claire.derian@gmail.com', '$2y$10$MLfbhvdI3trYiDv1JV.tqOe31dVDTUI3.1RtVNsJ99YpIdblNv2Ky', 'utilisateur', 'Claire Raymonde'),
(13, 'Garcia herwig', 'fgh.surf@gmail.com', '$2y$10$br60tHml9DS3L7L/dOM1ve4o0Qkmgo4PTlBHY3nCcpAgekFXySeca', 'utilisateur', 'Pepe'),
(14, 'Admin', 'admin@test.com', '$2y$10$qfb9qRFIXltvPX6aHY0T0OfPUUu/OJc6MF09InE8ssl0GVIWWVvgG', 'admin', 'Super');
SET FOREIGN_KEY_CHECKS = 1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
