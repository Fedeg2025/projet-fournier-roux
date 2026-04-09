-- ==========================================
-- SEED DEMO COMPLETO - FOURNIER ROUX
-- ==========================================

SET FOREIGN_KEY_CHECKS = 0;

-- =========================
-- UTILISATEURS
-- =========================
INSERT INTO utilisateurs (id_utilisateur, nom, email, mot_de_passe, role, prenom) VALUES
(1, 'Admin', 'admin@fournier-roux.local', '$2y$10$ZIK.t2Otc3TajGzeiliL5e14BOdQminnJuTogypRNei1iecKh20C6', 'admin', 'Test'),
(2, 'Dupont', 'user1@example.com', '$2y$10$MPuR2axpGdCpVs45/sspXOdVeAAgGpctNoMLBcOkqemyV9JRX7RR2', 'utilisateur', 'Jean'),
(3, 'Martin', 'user2@example.com', '$2y$10$MHXr2oUOrG9TUsbokPlaKuotDKOFRVI.r9gc/xJ.9wgjuJzaMR2.C', 'utilisateur', 'Claire');

-- =========================
-- CATEGORIES
-- =========================
INSERT INTO categorie (id_categorie, nom) VALUES
(1, 'Actualités'),
(2, 'Nature'),
(3, 'Ornithologie');

-- =========================
-- ARTICLES
-- =========================
INSERT INTO articles (id_article, titre, contenu, date_publication, id_utilisateur) VALUES
(1, 'Le Fournier roux', 'Le Fournier roux est un oiseau remarquable connu pour son nid en argile.', NOW(), 1),
(2, 'Construction du nid', 'Le nid est construit avec de la boue et séché au soleil.', NOW(), 1),
(3, 'Habitat naturel', 'On le trouve principalement en Amérique du Sud.', NOW(), 2);

-- =========================
-- MEDIA
-- =========================
INSERT INTO media (id_media, nom_fichier, date_upload, type_media) VALUES
(1, '69c67ed125804_fournier.roux.stme.2p.jpg', NOW(), 'image'),
(2, '69c71c7bc3b38_designfournier.jpg', NOW(), 'image'),
(3, '69ca87f9c920a_img2.jpg', NOW(), 'image');

-- =========================
-- RELATIONS ARTICLE -> MEDIA
-- =========================
INSERT INTO contient (id_article, id_media) VALUES
(1, 1),
(2, 2),
(3, 3);

-- =========================
-- RELATIONS ARTICLE -> CATEGORIE
-- =========================
INSERT INTO appartient (id_article, id_categorie) VALUES
(1, 1),
(2, 3),
(3, 2);

-- =========================
-- MESSAGES DEMO
-- =========================
INSERT INTO messages (prenom, email, nom, message, civilite, objet, id_utilisateur) VALUES
('Jean', 'contact@example.com', 'Dupont', 'Bonjour, très beau site !', 'M', 'Contact', NULL),
('Claire', 'test@example.com', 'Martin', 'Merci pour ces informations.', 'Mme', 'Info', NULL);

-- =========================
-- DEMANDES SUPPRESSION DEMO
-- =========================
INSERT INTO demandes_suppression_compte (id_utilisateur, motif, statut) VALUES
(2, 'Je souhaite supprimer mon compte.', 'en_attente');

SET FOREIGN_KEY_CHECKS = 1;