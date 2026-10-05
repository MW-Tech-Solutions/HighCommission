-- Nigeria High Commission Nairobi Kenya - Master Database Schema
-- Compatible with MySQL 8.x / MariaDB 10.4+ (utf8mb4_unicode_ci)

CREATE DATABASE IF NOT EXISTS `kenya_high_commission` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `kenya_high_commission`;

-- 1. Users Table (Citizens & Staff)
CREATE TABLE IF NOT EXISTS `users` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `full_name` VARCHAR(150) NOT NULL,
    `email` VARCHAR(150) NOT NULL UNIQUE,
    `phone` VARCHAR(50) DEFAULT NULL,
    `password_hash` VARCHAR(255) NOT NULL,
    `role` ENUM('citizen', 'officer', 'editor', 'admin') NOT NULL DEFAULT 'citizen',
    `status` ENUM('active', 'pending', 'suspended') NOT NULL DEFAULT 'active',
    `nin_number` VARCHAR(20) DEFAULT NULL,
    `passport_number` VARCHAR(20) DEFAULT NULL,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 2. Diaspora Citizens Registry Table
CREATE TABLE IF NOT EXISTS `diaspora_citizens` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `user_id` INT DEFAULT NULL,
    `registration_number` VARCHAR(50) NOT NULL UNIQUE,
    `full_name` VARCHAR(150) NOT NULL,
    `gender` ENUM('male', 'female', 'other') NOT NULL,
    `dob` DATE DEFAULT NULL,
    `passport_number` VARCHAR(30) NOT NULL,
    `nin` VARCHAR(20) DEFAULT NULL,
    `kenya_address` TEXT NOT NULL,
    `kenya_county` VARCHAR(100) NOT NULL,
    `occupation` VARCHAR(100) NOT NULL,
    `employer_institution` VARCHAR(150) DEFAULT NULL,
    `emergency_contact_kenya` VARCHAR(150) NOT NULL,
    `emergency_phone_kenya` VARCHAR(50) NOT NULL,
    `emergency_contact_nigeria` VARCHAR(150) NOT NULL,
    `emergency_phone_nigeria` VARCHAR(50) NOT NULL,
    `state_of_origin` VARCHAR(50) NOT NULL,
    `lga` VARCHAR(100) DEFAULT NULL,
    `status` ENUM('submitted', 'verified', 'flagged', 'rejected') DEFAULT 'submitted',
    `verified_at` DATETIME DEFAULT NULL,
    `verified_by` INT DEFAULT NULL,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 3. Consular Requests & Enquiries Table (ETC, Enquiries, Legalization, etc.)
CREATE TABLE IF NOT EXISTS `requests` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `reference_number` VARCHAR(50) NOT NULL UNIQUE,
    `user_id` INT DEFAULT NULL,
    `applicant_name` VARCHAR(150) NOT NULL,
    `applicant_email` VARCHAR(150) NOT NULL,
    `applicant_phone` VARCHAR(50) NOT NULL,
    `service_type` ENUM('etc', 'passport_guidance', 'visa_query', 'legalization', 'general_enquiry', 'emergency_distress') NOT NULL,
    `subject` VARCHAR(255) NOT NULL,
    `details` TEXT NOT NULL,
    `attached_document` VARCHAR(255) DEFAULT NULL,
    `status` ENUM('received', 'under_review', 'info_needed', 'approved', 'closed', 'rejected') DEFAULT 'received',
    `priority` ENUM('low', 'normal', 'high', 'urgent') DEFAULT 'normal',
    `assigned_officer_id` INT DEFAULT NULL,
    `internal_notes` TEXT DEFAULT NULL,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE SET NULL,
    FOREIGN KEY (`assigned_officer_id`) REFERENCES `users`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 4. Request Messages (Communication thread between citizen & staff)
CREATE TABLE IF NOT EXISTS `request_messages` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `request_id` INT NOT NULL,
    `sender_id` INT NOT NULL,
    `sender_type` ENUM('citizen', 'staff') NOT NULL,
    `message` TEXT NOT NULL,
    `attachment` VARCHAR(255) DEFAULT NULL,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`request_id`) REFERENCES `requests`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`sender_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 5. Appointments Table
CREATE TABLE IF NOT EXISTS `appointments` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `voucher_number` VARCHAR(50) NOT NULL UNIQUE,
    `user_id` INT DEFAULT NULL,
    `applicant_name` VARCHAR(150) NOT NULL,
    `applicant_email` VARCHAR(150) NOT NULL,
    `applicant_phone` VARCHAR(50) NOT NULL,
    `service_category` ENUM('biometrics', 'visa_interview', 'legalization', 'etc_pickup', 'general_consular') NOT NULL,
    `appointment_date` DATE NOT NULL,
    `time_slot` VARCHAR(20) NOT NULL,
    `status` ENUM('confirmed', 'attended', 'cancelled', 'rescheduled') DEFAULT 'confirmed',
    `notes` VARCHAR(255) DEFAULT NULL,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 6. Document Verification / Receipt Authenticator Table
CREATE TABLE IF NOT EXISTS `verifications` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `verification_code` VARCHAR(50) NOT NULL UNIQUE,
    `document_type` VARCHAR(100) NOT NULL,
    `holder_name` VARCHAR(150) NOT NULL,
    `passport_or_ref` VARCHAR(50) NOT NULL,
    `issue_date` DATE NOT NULL,
    `expiry_date` DATE DEFAULT NULL,
    `status` ENUM('valid', 'pending', 'revoked', 'unverified') DEFAULT 'valid',
    `issued_by_officer` VARCHAR(150) NOT NULL DEFAULT 'Nigeria High Commission Nairobi',
    `remarks` VARCHAR(255) DEFAULT NULL,
    `qr_hash` VARCHAR(255) NOT NULL,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 7. Trade Matchmaking Table
CREATE TABLE IF NOT EXISTS `trade_matchmaking` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `reference_code` VARCHAR(50) NOT NULL UNIQUE,
    `company_name` VARCHAR(150) NOT NULL,
    `contact_person` VARCHAR(150) NOT NULL,
    `email` VARCHAR(150) NOT NULL,
    `phone` VARCHAR(50) NOT NULL,
    `country_origin` ENUM('Kenya', 'Nigeria', 'Other') NOT NULL,
    `sector` VARCHAR(100) NOT NULL,
    `business_description` TEXT NOT NULL,
    `investment_size` VARCHAR(100) DEFAULT NULL,
    `status` ENUM('pending', 'in_progress', 'matched', 'closed') DEFAULT 'pending',
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 8. CMS Notices & Newsroom Table
CREATE TABLE IF NOT EXISTS `notices` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `title` VARCHAR(255) NOT NULL,
    `slug` VARCHAR(255) NOT NULL UNIQUE,
    `category` ENUM('public_advisory', 'holiday_announcement', 'diplomatic_news', 'press_release', 'consular_update') NOT NULL,
    `content` TEXT NOT NULL,
    `featured_image` VARCHAR(255) DEFAULT NULL,
    `is_urgent` TINYINT(1) DEFAULT 0,
    `is_published` TINYINT(1) DEFAULT 1,
    `published_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `author_id` INT DEFAULT NULL,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (`author_id`) REFERENCES `users`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 9. Audit Logs Table
CREATE TABLE IF NOT EXISTS `audit_logs` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `user_id` INT DEFAULT NULL,
    `user_email` VARCHAR(150) DEFAULT NULL,
    `action` VARCHAR(100) NOT NULL,
    `details` TEXT DEFAULT NULL,
    `ip_address` VARCHAR(50) DEFAULT NULL,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 10. Dynamic Roles Table
CREATE TABLE IF NOT EXISTS `roles` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(100) NOT NULL,
    `slug` VARCHAR(100) NOT NULL UNIQUE,
    `description` TEXT DEFAULT NULL,
    `is_system` TINYINT(1) DEFAULT 0,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 11. Dynamic Permissions Table
CREATE TABLE IF NOT EXISTS `permissions` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(100) NOT NULL,
    `slug` VARCHAR(100) NOT NULL UNIQUE,
    `module` VARCHAR(50) NOT NULL,
    `description` TEXT DEFAULT NULL,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 12. Role Permissions Pivot Table
CREATE TABLE IF NOT EXISTS `role_permissions` (
    `role_id` INT NOT NULL,
    `permission_id` INT NOT NULL,
    PRIMARY KEY (`role_id`, `permission_id`),
    FOREIGN KEY (`role_id`) REFERENCES `roles`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`permission_id`) REFERENCES `permissions`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 13. User Roles Pivot Table
CREATE TABLE IF NOT EXISTS `user_roles` (
    `user_id` INT NOT NULL,
    `role_id` INT NOT NULL,
    PRIMARY KEY (`user_id`, `role_id`),
    FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`role_id`) REFERENCES `roles`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 14. Explicit User Permission Overrides (Grants / Denials - Denials Win)
CREATE TABLE IF NOT EXISTS `user_permissions` (
    `user_id` INT NOT NULL,
    `permission_id` INT NOT NULL,
    `type` ENUM('grant', 'deny') NOT NULL DEFAULT 'grant',
    PRIMARY KEY (`user_id`, `permission_id`),
    FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`permission_id`) REFERENCES `permissions`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 15. Password Recovery Tokens
CREATE TABLE IF NOT EXISTS `password_recovery_tokens` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `user_id` INT NOT NULL,
    `token_hash` VARCHAR(255) NOT NULL UNIQUE,
    `expires_at` DATETIME NOT NULL,
    `used_at` DATETIME DEFAULT NULL,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 16. Staff MFA Secrets
CREATE TABLE IF NOT EXISTS `mfa_secrets` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `user_id` INT NOT NULL UNIQUE,
    `secret` VARCHAR(255) NOT NULL,
    `is_enabled` TINYINT(1) DEFAULT 1,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 17. Content Revisions & Workflows (Draft -> In Review -> Approved -> Published -> Archived)
CREATE TABLE IF NOT EXISTS `content_revisions` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `notice_id` INT DEFAULT NULL,
    `version_number` INT NOT NULL DEFAULT 1,
    `title` VARCHAR(255) NOT NULL,
    `content` TEXT NOT NULL,
    `edited_by` INT NOT NULL,
    `status` ENUM('draft', 'in_review', 'approved', 'published', 'archived') NOT NULL DEFAULT 'draft',
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`notice_id`) REFERENCES `notices`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`edited_by`) REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 18. Editorial Approval Logs
CREATE TABLE IF NOT EXISTS `editorial_approvals` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `revision_id` INT NOT NULL,
    `approver_id` INT NOT NULL,
    `action` ENUM('submit', 'approve', 'reject', 'publish', 'archive') NOT NULL,
    `comments` TEXT DEFAULT NULL,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`revision_id`) REFERENCES `content_revisions`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`approver_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 19. Private Document Uploads & Virus Scanning Metadata
CREATE TABLE IF NOT EXISTS `private_documents` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `user_id` INT NOT NULL,
    `request_id` INT DEFAULT NULL,
    `original_filename` VARCHAR(255) NOT NULL,
    `stored_filename` VARCHAR(255) NOT NULL UNIQUE,
    `file_path` VARCHAR(255) NOT NULL,
    `mime_type` VARCHAR(100) NOT NULL,
    `file_size` INT NOT NULL,
    `scan_state` ENUM('pending', 'scanned_clean', 'scan_failed') NOT NULL DEFAULT 'scanned_clean',
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`request_id`) REFERENCES `requests`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 20. Institutional & System Settings
CREATE TABLE IF NOT EXISTS `system_settings` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `setting_key` VARCHAR(100) NOT NULL UNIQUE,
    `setting_value` TEXT NOT NULL,
    `group_name` VARCHAR(50) NOT NULL DEFAULT 'general',
    `updated_by` INT DEFAULT NULL,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (`updated_by`) REFERENCES `users`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 21. Approved Charge Records (Services & Fees)
CREATE TABLE IF NOT EXISTS `approved_charge_records` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `service_name` VARCHAR(150) NOT NULL,
    `fee_currency` VARCHAR(10) NOT NULL DEFAULT 'USD',
    `fee_amount` DECIMAL(10,2) NOT NULL,
    `effective_date` DATE NOT NULL,
    `approved_by` INT DEFAULT NULL,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`approved_by`) REFERENCES `users`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 22. Office Hours & Holiday Schedules
CREATE TABLE IF NOT EXISTS `office_hours` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `day_of_week` ENUM('Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday') NOT NULL,
    `open_time` TIME DEFAULT '08:30:00',
    `close_time` TIME DEFAULT '16:30:00',
    `is_closed` TINYINT(1) DEFAULT 0,
    `notes` VARCHAR(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `holidays` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `holiday_date` DATE NOT NULL UNIQUE,
    `holiday_name` VARCHAR(150) NOT NULL,
    `is_recurring` TINYINT(1) DEFAULT 0,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 23. Notification Outbox Table
CREATE TABLE IF NOT EXISTS `notification_outbox` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `recipient_email` VARCHAR(150) NOT NULL,
    `recipient_name` VARCHAR(150) DEFAULT NULL,
    `subject` VARCHAR(255) NOT NULL,
    `body_text` TEXT NOT NULL,
    `event_type` VARCHAR(50) NOT NULL,
    `status` ENUM('queued', 'attempted', 'delivered', 'failed') NOT NULL DEFAULT 'queued',
    `attempts_count` INT NOT NULL DEFAULT 0,
    `last_attempt_at` DATETIME DEFAULT NULL,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 24. Notification Delivery Attempts Table
CREATE TABLE IF NOT EXISTS `delivery_attempts` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `outbox_id` INT NOT NULL,
    `attempt_number` INT NOT NULL,
    `status` ENUM('success', 'failed') NOT NULL,
    `response_log` TEXT DEFAULT NULL,

    `attempted_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`outbox_id`) REFERENCES `notification_outbox`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 25. Hero Slides Table for Admin-Managed Slideshow
CREATE TABLE IF NOT EXISTS `hero_slides` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `heading` VARCHAR(255) NOT NULL,
    `subheading` TEXT DEFAULT NULL,
    `image_desktop` VARCHAR(255) NOT NULL,
    `image_mobile` VARCHAR(255) DEFAULT NULL,
    `image_alt` VARCHAR(255) NOT NULL,
    `cta_primary_label` VARCHAR(100) DEFAULT NULL,
    `cta_primary_url` VARCHAR(255) DEFAULT NULL,
    `cta_secondary_label` VARCHAR(100) DEFAULT NULL,
    `cta_secondary_url` VARCHAR(255) DEFAULT NULL,
    `caption_theme` ENUM('light_on_dark', 'dark_on_light') DEFAULT 'light_on_dark',
    `text_align` ENUM('left', 'center', 'right') DEFAULT 'left',
    `display_order` INT DEFAULT 0,
    `is_enabled` TINYINT(1) DEFAULT 1,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



