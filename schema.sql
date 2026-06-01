-- Sarah Agni Personal Brand Website Database Schema
-- Optimized for MySQL 5.7+ / 8.0+

CREATE DATABASE IF NOT EXISTS `sarah_agni_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `sarah_agni_db`;

-- 1. Admin Users Table
CREATE TABLE IF NOT EXISTS `users` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `username` VARCHAR(50) NOT NULL UNIQUE,
  `password_hash` VARCHAR(255) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 2. Media Gallery Table (Supports filtering by category)
CREATE TABLE IF NOT EXISTS `gallery` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(255) NOT NULL,
  `category` ENUM('dreadlocks', 'firedance', 'events', 'workshops', 'healing') NOT NULL,
  `image_path` VARCHAR(255) NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 3. Testimonials Table (Supports star rating and optional video link)
CREATE TABLE IF NOT EXISTS `testimonials` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `client_name` VARCHAR(100) NOT NULL,
  `role_or_title` VARCHAR(100) DEFAULT NULL,
  `star_rating` INT NOT NULL DEFAULT 5,
  `testimonial_text` TEXT NOT NULL,
  `video_url` VARCHAR(255) DEFAULT NULL,
  `image_path` VARCHAR(255) DEFAULT NULL,
  `is_featured` TINYINT(1) DEFAULT 0,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 4. Contact Requests / Lead Capture Table
CREATE TABLE IF NOT EXISTS `contact_requests` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(100) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `phone` VARCHAR(30) DEFAULT NULL,
  `service_interest` VARCHAR(50) DEFAULT NULL,
  `message` TEXT NOT NULL,
  `status` ENUM('unread', 'read', 'archived') DEFAULT 'unread',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 5. Site Dynamic Content Table (For editing content direct from Admin Panel)
CREATE TABLE IF NOT EXISTS `site_content` (
  `key_name` VARCHAR(100) PRIMARY KEY,
  `field_value` TEXT NOT NULL,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Seed Default Content Keys (To prevent empty page loadings)
INSERT INTO `site_content` (`key_name`, `field_value`) VALUES
('home_hero_title', 'Transform Your Hair. Heal Your Energy. Ignite Your Spirit.'),
('home_hero_subtitle', 'Professional Dreadlocks Artist, Hypnotherapist, Breathwork Guide & Fire Dance Instructor based in India.'),
('home_about_summary', 'Sarah Agni is a visionary dreadlock artist and spiritual facilitator. Combining a decade of dreadlock artistry with transformational healing modalities, she guides individuals through physical, energetic, and creative rebirths.'),
('dreadlocks_pricing_new', 'Custom quote based on hair length, volume, and extension selection. Starts from ₹15,000.'),
('dreadlocks_pricing_maint', 'Hourly rate for deep maintenance, tightening, and root locking. Starting at ₹1,500/hour.'),
('dreadlocks_pricing_repair', 'Specialized restoration of thinning roots, broken dreads, and build-up removal. Quote upon consultation.'),
('dreadlocks_pricing_extensions', 'High-quality organic human hair or wool extensions, custom colored and styled to match. Starting at ₹20,000.'),
('healing_intro_text', 'A gentle, integrated path of clinical hypnotherapy, trauma release, and emotional alignment. Designed to guide you from stress and anxiety into deep center-grounding and energetic clarity.'),
('breathwork_intro_text', 'Rebirth Breathwork is a circular breathing method that facilitates somatic release, emotional integration, and altered states of consciousness, allowing deep-seated blockages to dissolve naturally.'),
('firedance_intro_text', 'Ignite your internal flame. Fire dance is more than movement; it is a spiritual dialogue with energy, fear, and focus. Weekly classes range from beginner poi/staff to intermediate safety choreography.')
ON DUPLICATE KEY UPDATE `field_value` = VALUES(`field_value`);
