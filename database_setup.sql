-- Library Books Management System Database Setup
-- This file creates the complete database structure with one sample book
-- Import this file in phpMyAdmin or MySQL command line

-- Create the database
CREATE DATABASE IF NOT EXISTS `library_db` 
CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Use the database
USE `library_db`;

-- Create the books table
CREATE TABLE IF NOT EXISTS `books` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `genre` varchar(100) DEFAULT NULL,
  `publication_year` int(4) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_title` (`title`),
  KEY `idx_author` (`author`),
  KEY `idx_genre` (`genre`),
  KEY `idx_publication_year` (`publication_year`),
  KEY `idx_created_at` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert one sample book to test the system
INSERT INTO `books` (`title`, `author`, `genre`, `publication_year`, `description`, `created_at`, `updated_at`) VALUES
('The Great Gatsby', 'F. Scott Fitzgerald', 'Fiction', 1925, 'A story of the fabulously wealthy Jay Gatsby and his love for the beautiful Daisy Buchanan. Set in the Jazz Age on Long Island, the novel depicts first-person narrator Nick Carraway\'s interactions with mysterious millionaire Jay Gatsby and Gatsby\'s obsession to reunite with his former lover, Daisy Buchanan.', NOW(), NOW());

-- Show the created table
SHOW TABLES;

-- Show the sample book
SELECT 'Sample Book:' as info;
SELECT id, title, author, genre, publication_year, LEFT(description, 50) as description_preview FROM books;

-- Database setup complete!
SELECT 'Database setup completed successfully!' as status;
