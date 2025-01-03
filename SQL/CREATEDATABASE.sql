
DROP TABLE utilisateurs;
-- table utilisateurs

CREATE TABLE IF NOT EXISTS utilisateurs (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    email TEXT NOT NULL UNIQUE,
    mot_de_passe TEXT NOT NULL,
    role TEXT CHECK(role IN ('user', 'admin')) DEFAULT 'user'
);
--insertion de données
INSERT INTO utilisateurs (email, mot_de_passe, role) VALUES
    ('nicolas@example.com', '81dc9bdb52d04dc20036dbd8313ed055', 'user'),
    ('admin@example.com', '81dc9bdb52d04dc20036dbd8313ed055', 'admin');
