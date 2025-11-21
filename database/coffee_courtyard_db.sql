-- Coffee CourtYard Database Setup
-- Database: coffee_courtyard_db
-- This SQL file creates all necessary tables for the Coffee CourtYard website

-- Create database
CREATE DATABASE IF NOT EXISTS coffee_courtyard_db;
USE coffee_courtyard_db;

-- Admin Users Table
CREATE TABLE IF NOT EXISTS admin_users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    last_login TIMESTAMP NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Menu Items Table
CREATE TABLE IF NOT EXISTS menu_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    image_path VARCHAR(255),
    category VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Homepage Content Table
CREATE TABLE IF NOT EXISTS homepage_content (
    id INT AUTO_INCREMENT PRIMARY KEY,
    section_name VARCHAR(255) NOT NULL UNIQUE,
    content_text LONGTEXT,
    content_image VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert default admin user (password: admin123)
-- Password is hashed using PHP password_hash()
INSERT INTO admin_users (username, password_hash) VALUES
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');

-- Insert default homepage content
INSERT INTO homepage_content (section_name, content_text, content_image) VALUES
('hero_title', 'Your Everyday Escape.', 'hero-bg.jpg'),
('hero_subtitle', 'Artisan coffee, fresh pastries, and a quiet courtyard to unwind.', NULL),
('about_title', 'Our Story', NULL),
('about_text', 'Coffee CourtYard was born from a simple idea: to create a warm and inviting space where the community can gather, relax, and enjoy exceptionally crafted coffee. We''re passionate about sourcing the finest specialty beans, partnering with local bakeries, and providing a tranquil escape from the everyday hustle. Our mission is to pour our heart into every cup and make you feel right at home in our cozy courtyard.', NULL),
('contact_address', '123 Cafe Lane, Roastville, CA 90210', NULL),
('contact_email', 'hello@coffeecourtyard.com', NULL),
('contact_phone', '(555) 123-4567', NULL);

-- Insert sample menu items
INSERT INTO menu_items (name, description, price, category, image_path) VALUES
-- Hot Coffees
('Espresso', 'A concentrated coffee brew with a rich aroma and a caramel-like sweetness.', 3.00, 'Hot Coffee', 'espresso.jpg'),
('Americano', 'Espresso shots topped with hot water create a light layer of crema.', 3.50, 'Hot Coffee', 'americano.jpg'),
('Latte', 'Rich espresso with steamed milk and a light layer of foam.', 4.50, 'Hot Coffee', 'latte.jpg'),
('Cappuccino', 'A perfect balance of espresso, steamed milk, and a thick layer of foam.', 4.50, 'Hot Coffee', 'cappuccino.jpg'),
('Mocha', 'Espresso combined with rich chocolate and steamed milk.', 4.75, 'Hot Coffee', 'mocha.jpg'),

-- Iced Drinks
('Iced Latte', 'Chilled espresso with milk, served over ice for a refreshing kick.', 5.00, 'Iced Drinks', 'iced-latte.jpg'),
('Cold Brew', 'Slow-steeped for 12 hours for a smooth, low-acid, and bold coffee flavor.', 4.75, 'Iced Drinks', 'cold-brew.jpg'),
('Iced Americano', 'Rich espresso shots combined with cold water and ice. Crisp and invigorating.', 3.75, 'Iced Drinks', 'iced-americano.jpg'),

-- Pastries
('Butter Croissant', 'Flaky, buttery, and freshly baked throughout the day.', 3.50, 'Pastries', 'croissant.jpg'),
('Blueberry Muffin', 'A soft, moist muffin bursting with juicy blueberries.', 3.75, 'Pastries', 'muffin.jpg'),
('Chocolate Chip Cookie', 'Classic and chewy, loaded with rich chocolate chips.', 2.50, 'Pastries', 'cookie.jpg'),
('Almond Croissant', 'Buttery croissant filled with sweet almond cream.', 4.00, 'Pastries', 'almond-croissant.jpg'),

-- Sandwiches & Snacks
('Avocado Toast', 'Fresh avocado on toasted artisan bread with a hint of lemon.', 6.50, 'Food', 'avocado-toast.jpg'),
('Turkey Sandwich', 'Roasted turkey with fresh vegetables on whole grain bread.', 7.50, 'Food', 'turkey-sandwich.jpg');

-- Create indexes for better performance
CREATE INDEX idx_menu_category ON menu_items(category);
CREATE INDEX idx_homepage_section ON homepage_content(section_name);
