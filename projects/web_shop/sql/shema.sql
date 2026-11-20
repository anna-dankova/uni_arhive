CREATE DATABASE IF NOT EXISTS trgovina CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE trgovina;

CREATE TABLE IF NOT EXISTS kategorije (
  id INT AUTO_INCREMENT PRIMARY KEY,
  naziv VARCHAR(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS izdelki (
  id INT AUTO_INCREMENT PRIMARY KEY,
  naziv VARCHAR(100) NOT NULL,
  cena DECIMAL(8,2) NOT NULL,
  zaloga INT NOT NULL DEFAULT 0,
  kategorija_id INT,
  FOREIGN KEY (kategorija_id) REFERENCES kategorije(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO kategorije (id, naziv) VALUES (1, 'Računalništvo'), (2, 'Pisarna');
INSERT INTO izdelki (naziv, cena, zaloga, kategorija_id) VALUES 
('Tipkovnica', 49.90, 12, 1),
('Miška', 19.50, 0, 1),
('Monitor', 189.00, 5, 1),
('Spletna kamera', 59.00, 3, 1),
('Tiskalnik', 129.00, 2, 1),
('Slušalke', 35.00, 0, 1),
('Podloga za miško', 7.90, 25, 1),
('Pisalo', 1.20, 100, 2);
