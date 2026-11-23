CREATE DATABASE IF NOT EXISTS shop CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE shop;

DROP TABLE IF EXISTS order_items;
DROP TABLE IF EXISTS orders;
DROP TABLE IF EXISTS products;
DROP TABLE IF EXISTS categories;
DROP TABLE IF EXISTS users;

CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL UNIQUE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    stock INT NOT NULL DEFAULT 0,
    category_id INT NOT NULL,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    role ENUM('user', 'admin') NOT NULL DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    total_price DECIMAL(10, 2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    price_at_order DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO categories (id, name) VALUES
(1, 'Processors'),
(2, 'Graphics Cards'),
(3, 'Memory and Storage'),
(4, 'Power Supplies');

INSERT INTO products (name, description, price, stock, category_id) VALUES
('AMD Ryzen 5 7600X', '6-core, 12-thread AM5 desktop processor with up to 5.3 GHz boost clock.', 149.00, 10, 1),
('Intel Core i5-14600K', '14-core LGA1700 processor suitable for gaming and productivity workloads.', 234.99, 7, 1),
('AMD Ryzen 7 9700X', '8-core, 16-thread Zen 5 AM5 processor with 65W TDP and up to 5.5 GHz boost.', 244.99, 6, 1),
('AMD Ryzen 7 9800X3D', '8-core AM5 gaming processor with 3D V-Cache technology.', 363.00, 4, 1),
('NVIDIA GeForce RTX 4060 8GB', 'Mid-range graphics card with DLSS 3 support and low power draw.', 379.07, 6, 2),
('AMD Radeon RX 7700 XT 12GB', '1440p gaming graphics card with 12 GB GDDR6 memory.', 794.99, 4, 2),
('NVIDIA GeForce RTX 5060 8GB', 'Blackwell architecture GPU with 8 GB GDDR7 memory and DLSS 4 support.', 486.90, 5, 2),
('NVIDIA GeForce RTX 5070 12GB', 'High-performance 1440p graphics card with 12 GB GDDR7 memory.', 888.88, 3, 2),
('Corsair Vengeance 32GB DDR5-6000', 'Dual-channel 2x16 GB DDR5 memory kit optimized for modern platforms.', 559.99, 15, 3),
('Samsung 990 PRO 1TB NVMe SSD', 'PCIe 4.0 M.2 solid-state drive with sequential reads up to 7450 MB/s.', 210.80, 12, 3),
('Kingston NV2 2TB NVMe SSD', 'Affordable PCIe 4.0 M.2 SSD for game libraries and general storage.', 309.90, 0, 3),
('Kingston Fury Beast 32GB DDR5-6000', '2x16 GB DDR5-6000 memory kit with EXPO and XMP 3.0 profiles.', 613.40, 9, 3),
('Samsung 990 EVO Plus 1TB NVMe SSD', 'PCIe 4.0/5.0 M.2 SSD balancing speed and power efficiency.', 189.00, 11, 3),
('Seasonic Focus GX-750', '750W 80 PLUS Gold fully modular ATX 3.1 power supply.', 99.90, 8, 4),
('be quiet! Pure Power 12 M 850W', '850W 80 PLUS Gold modular PSU with ATX 3.0 and PCIe 5.0 support.', 144.09, 5, 4),
('Corsair RM850x 850W ATX 3.1', '850W fully modular low-noise power supply with native 12V-2x6 cable.', 119.00, 7, 4),
('MSI MAG A750GL PCIE5 750W', '750W 80 PLUS Gold compact modular PSU ready for PCIe 5.0 GPUs.', 98.99, 10, 4);

INSERT INTO users (name, email, password_hash, role) VALUES
('Admin User', 'admin@pcshop.local', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin');