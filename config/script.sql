USE peersync;
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(50) NOT NULL
);
CREATE TABLE skills (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE
);
CREATE TABLE help_requests (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titre VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    technologie VARCHAR(100) NOT NULL,
    statut VARCHAR(50) NOT NULL,
    id_student INT NOT NULL,
    id_tutor INT NULL,
    FOREIGN KEY (id_student) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (id_tutor) REFERENCES users(id) ON DELETE SET NULL
);
INSERT INTO users (nom, email, password, role) VALUES
('Sara Student', 'student@enaa.com', '123456', 'student'),
('Ali Tutor', 'tutor@enaa.com', '123456', 'tutor'),
('Yassine Tutor', 'yassine@enaa.com', '123456', 'tutor');

INSERT INTO skills (name)
 VALUES
('PHP'),
('POO'),
('SQL'),
('JavaScript');

INSERT INTO help_requests (titre, description, technologie, statut, id_student, id_tutor) VALUES
('Problème héritage POO', 'Je ne comprends pas le concept d’héritage en PHP', 'POO', 'EN_ATTENTE', 1, NULL);