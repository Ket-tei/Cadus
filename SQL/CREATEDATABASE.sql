-- table utilisateurs
DROP TABLE questions;
DROP TABLE choix;
DROP TABLE reponses;
DROP TABLE utilisateurs;
DROP TABLE sessions;


CREATE TABLE IF NOT EXISTS utilisateurs (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    email TEXT NOT NULL UNIQUE,
    mot_de_passe TEXT NOT NULL,
    role TEXT CHECK(role IN ('user', 'admin')) DEFAULT 'user',
    sondage_effectue BOOLEAN DEFAULT FALSE
);
--insertion de données
INSERT INTO utilisateurs (email, mot_de_passe, role) VALUES
    ('nicolas@example.com', '81dc9bdb52d04dc20036dbd8313ed055', 'user'),
    ('admin@example.com', '81dc9bdb52d04dc20036dbd8313ed055', 'admin');

-- table des questions
CREATE TABLE IF NOT EXISTS questions (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    texte TEXT NOT NULL,
    type_de_reponse TEXT CHECK(type_de_reponse IN ('texte', 'numerique', 'choix')) NOT NULL
);

-- insertion des questions
INSERT INTO questions (texte, type_de_reponse) VALUES
    ('Quel est votre âge ?', 'numerique'),
    ('Quel est votre sexe ?', 'choix'),
    ('Quel est votre statut ?', 'choix'),
    ('Dans quelle région vivez-vous ?', 'choix'),
    ('Vivez-vous dans une zone urbaine ou rurale ?', 'choix'),
    ('Quel est votre activité ?', 'choix'),
    ('Pratiquez-vous un loisir/sport ?', 'choix'),
    ('Avez-vous des problèmes de santé', 'choix'),
    ('Êtes-vous satisfait de votre vie ?', 'choix'),
    ('Avez-vous besoin de soutien psychologique ?', 'choix'),
    ('Avez-vous besoin d aide financière', 'choix');



-- table des questions à choix multiples

CREATE TABLE IF NOT EXISTS choix (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    id_question INTEGER NOT NULL,
    texte TEXT NOT NULL,
    FOREIGN KEY (id_question) REFERENCES questions(id)
);
-- insertion des choix
INSERT INTO choix (id_question, texte) VALUES
    (2, 'Homme'),
    (2, 'Femme'),
    (2, 'Autre'),
    (3, 'Adulte'),
    (3, 'Adolescent'),
    (4, 'Auvergne-Rhône-Alpes'),
    (4, 'Bourgogne-Franche-Comté'),
    (4, 'Bretagne'),
    (4, 'Centre-Val de Loire'),
    (4, 'Corse'),
    (4, 'Grand Est'),
    (4, 'Hauts-de-France'),
    (4, 'Île-de-France'),
    (4, 'Normandie'),
    (4, 'Nouvelle-Aquitaine'),
    (4, 'Occitanie'),
    (4, 'Pays de la Loire'),
    (4, 'Provence-Alpes-Côte d Azur'),
    (4, 'Guadeloupe'),
    (4, 'Guyane'),
    (4, 'La Réunion'),
    (4, 'Martinique'),
    (4, 'Mayotte'),
    (5, 'Urbaine'),
    (5, 'Rurale'),
    (6, 'Étudiant'),
    (6, 'En emploi'),
    (6, 'Sans emploi'),
    (6, 'Retraité'),
    (7, 'Oui, régulièrement'),
    (7, 'Oui, occasionnellement'),
    (7, 'Non'),
    (8, 'Oui'),
    (8, 'Non'),
    (9, 'Oui'),
    (9, 'Non'),
    (9, 'Je ne souhaite pas répondre'),
    (10, 'Oui'),
    (10, 'Non'),
    (10, 'Je ne souhaite pas répondre'),
    (11, 'Oui'),
    (11, 'Non'),
    (11, 'Je ne souhaite pas répondre');



CREATE TABLE sessions (
    id INT AUTO_INCREMENT PRIMARY KEY
);

-- table des réponses
CREATE TABLE IF NOT EXISTS reponses (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    id_question INTEGER NOT NULL,
    id_sessions INTEGER NOT NULL,
    reponse TEXT NOT NULL,
    FOREIGN KEY (id_question) REFERENCES questions(id)
);
