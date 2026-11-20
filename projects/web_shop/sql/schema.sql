CREATE DATABASE IF NOT EXISTS shop CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE shop;

CREATE TABLE IF NOT EXISTS categories (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS products (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  price DECIMAL(8,2) NOT NULL,
  stock INT NOT NULL DEFAULT 0,
  category_id INT,
  FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO categories (id, name) VALUES 
(1, 'Computers'), 
(2, 'Office');

INSERT INTO products (name, price, stock, category_id) VALUES 
('Keyboard', 49.90, 12, 1),
('Mouse', 19.50, 0, 1),
('Monitor', 189.00, 5, 1),
('Webcam', 59.00, 3, 1),
('Printer', 129.00, 2, 1),
('Headphones', 35.00, 0, 1),
('Mousepad', 7.90, 25, 1),
('Pen', 1.20, 100, 2);
