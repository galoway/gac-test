CREATE DATABASE homestead;
USE homestead;
CREATE TABLE IF NOT EXISTS detail_appels (
id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
compte_facture INT NOT NULL,
num_facture INT NOT NULL,
num_abonne INT NOT NULL,
date DATE DEFAULT NULL,
heure TIME DEFAULT NULL,
duree TIME DEFAULT '00:00:00',
volume INT DEFAULT 0,
type INT DEFAULT 0
);