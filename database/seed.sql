-- Nigeria High Commission Nairobi Kenya - Synthetic Seed Data
-- Visibly labeled as DEMONSTRATION DATA for presentation & evaluation

USE `kenya_high_commission`;

-- Default Passwords for seed users: "Password123!" hashed with password_hash()
-- Hash string for "Password123!": $2y$10$e.w3j3w53p/2gN0dE7r2eO0O/H6J0X.1X.Y.Z (We will generate exact hash in PHP installer)

-- 1. Users
INSERT IGNORE INTO `users` (`id`, `full_name`, `email`, `phone`, `password_hash`, `role`, `status`, `nin_number`, `passport_number`) VALUES
(1, 'High Commission Staff Officer', 'officer@nigeriankenya.or.ke', '+254 795 770 247', '$2y$10$4.qJb7M6D2eU3N2R4b0m1.Q2s2L6a9K1j2m3n4o5p6q7r8s9t0u1v', 'officer', 'active', '12345678901', 'A00123456'),
(2, 'Mission Editorial Editor', 'editor@nigeriankenya.or.ke', '+254 795 770 248', '$2y$10$4.qJb7M6D2eU3N2R4b0m1.Q2s2L6a9K1j2m3n4o5p6q7r8s9t0u1v', 'editor', 'active', '12345678902', 'A00123457'),
(3, 'System Super Administrator', 'admin@nigeriankenya.or.ke', '+254 795 770 249', '$2y$10$4.qJb7M6D2eU3N2R4b0m1.Q2s2L6a9K1j2m3n4o5p6q7r8s9t0u1v', 'admin', 'active', '12345678903', 'A00123458'),
(4, 'Tunde Emmanuel (Demo Citizen)', 'tunde.demo@example.com', '+254 712 345 678', '$2y$10$4.qJb7M6D2eU3N2R4b0m1.Q2s2L6a9K1j2m3n4o5p6q7r8s9t0u1v', 'citizen', 'active', '98765432101', 'A99887766'),
(5, 'Amina Mohammed (Demo Citizen)', 'amina.demo@example.com', '+254 733 987 654', '$2y$10$4.qJb7M6D2eU3N2R4b0m1.Q2s2L6a9K1j2m3n4o5p6q7r8s9t0u1v', 'citizen', 'active', '98765432102', 'A99887767');

-- 2. Diaspora Citizens Registry Seed Data
INSERT IGNORE INTO `diaspora_citizens` (`id`, `user_id`, `registration_number`, `full_name`, `gender`, `dob`, `passport_number`, `nin`, `kenya_address`, `kenya_county`, `occupation`, `employer_institution`, `emergency_contact_kenya`, `emergency_phone_kenya`, `emergency_contact_nigeria`, `emergency_phone_nigeria`, `state_of_origin`, `lga`, `status`) VALUES
(1, 4, 'NHC-REG-2026-001', 'Tunde Emmanuel (Demo)', 'male', '1990-05-14', 'A99887766', '98765432101', 'Flat 4B, Woodavenue Apartments, Kilimani', 'Nairobi', 'Software Architect', 'TechAfrica Ltd Nairobi', 'Grace Emmanuel', '+254 722 111 222', 'Olusegun Emmanuel', '+234 803 111 2222', 'Lagos', 'Ikeja', 'verified'),
(2, 5, 'NHC-REG-2026-002', 'Amina Mohammed (Demo)', 'female', '1995-11-20', 'A99887767', '98765432102', 'House 12, Westlands Avenue', 'Nairobi', 'Postgraduate Student', 'University of Nairobi', 'Dr. Ibrahim Mohammed', '+254 733 444 555', 'Hajiya Fatima Mohammed', '+234 802 333 4444', 'Kano', 'Kano Municipal', 'submitted');

-- 3. Consular Requests & Enquiries
INSERT IGNORE INTO `requests` (`id`, `reference_number`, `user_id`, `applicant_name`, `applicant_email`, `applicant_phone`, `service_type`, `subject`, `details`, `status`, `priority`, `assigned_officer_id`, `internal_notes`) VALUES
(1, 'REQ-2026-1001', 4, 'Tunde Emmanuel (Demo)', 'tunde.demo@example.com', '+254 712 345 678', 'passport_guidance', 'Enquiry regarding e-passport renewal process in Nairobi', 'I need clarification on whether standard passport renewal requires fresh biometrics capture at the Mission premises in Kilimani.', 'under_review', 'normal', 1, 'Applicant has valid NIN. Instructed to schedule biometrics slot on portal.'),
(2, 'REQ-2026-1002', 5, 'Amina Mohammed (Demo)', 'amina.demo@example.com', '+254 733 987 654', 'etc', 'Emergency Travel Certificate Request for Lost Passport', 'I misplaced my Nigerian passport in Mombasa and have an urgent flight back to Abuja next week. Please guide me on ETC processing.', 'received', 'urgent', 1, 'Requires police loss abstract from Mombasa Police Station.');

-- 4. Request Messages
INSERT IGNORE INTO `request_messages` (`id`, `request_id`, `sender_id`, `sender_type`, `message`) VALUES
(1, 1, 4, 'citizen', 'Good day, please I would like to know if my appointment slot can be booked for next Wednesday.'),
(2, 1, 1, 'staff', 'Dear Tunde, Yes, Wednesday slots are open between 10:00 AM and 1:00 PM. Please use the Appointment Booking module on the website.');

-- 5. Appointments Seed Data
INSERT IGNORE INTO `appointments` (`id`, `voucher_number`, `user_id`, `applicant_name`, `applicant_email`, `applicant_phone`, `service_category`, `appointment_date`, `time_slot`, `status`, `notes`) VALUES
(1, 'APT-2026-8801', 4, 'Tunde Emmanuel (Demo)', 'tunde.demo@example.com', '+254 712 345 678', 'biometrics', CURRENT_DATE + INTERVAL 2 DAY, '10:30 AM', 'confirmed', 'Biometric passport renewal capture.'),
(2, 'APT-2026-8802', 5, 'Amina Mohammed (Demo)', 'amina.demo@example.com', '+254 733 987 654', 'etc_pickup', CURRENT_DATE + INTERVAL 3 DAY, '11:30 AM', 'confirmed', 'ETC collection and identity verification.');

-- 6. Document Verifications / Receipt Authenticator
INSERT IGNORE INTO `verifications` (`id`, `verification_code`, `document_type`, `holder_name`, `passport_or_ref`, `issue_date`, `expiry_date`, `status`, `issued_by_officer`, `remarks`, `qr_hash`) VALUES
(1, 'NHCK-2026-8849', 'Consular Attestation Certificate', 'Tunde Emmanuel', 'A99887766', '2026-09-15', '2027-09-15', 'valid', 'Consular Section - High Commission Nairobi', 'Authentic document issued under official seal.', 'HASH8849VERIFIED'),
(2, 'NHCK-2026-1024', 'Emergency Travel Certificate', 'Amina Mohammed', 'A99887767', '2026-10-01', '2026-11-01', 'valid', 'Consular Section - High Commission Nairobi', 'Single journey travel document to Nigeria.', 'HASH1024VERIFIED'),
(3, 'REC-8841-KEN', 'Official Consular Service Receipt', 'Kiplagat Omondi', 'VS-992019', '2026-09-28', NULL, 'valid', 'Finance Office - High Commission Nairobi', 'Paid via Remita Official Payment Channel.', 'HASH8841REC');

-- 7. Trade Matchmaking Seed Data
INSERT IGNORE INTO `trade_matchmaking` (`id`, `reference_code`, `company_name`, `contact_person`, `email`, `phone`, `country_origin`, `sector`, `business_description`, `status`) VALUES
(1, 'TRD-2026-501', 'Nairobi Agro-Tech Enterprises', 'James Oduor', 'j.oduor@nairobiagrotech.co.ke', '+254 720 000 111', 'Kenya', 'Agriculture & Food Processing', 'Seeking partnership with Nigerian horticulture exporters and fertilizer suppliers.', 'in_progress');

-- 8. CMS Notices & Newsroom
INSERT IGNORE INTO `notices` (`id`, `title`, `slug`, `category`, `content`, `is_urgent`, `is_published`, `published_at`, `author_id`) VALUES
(1, 'PUBLIC ADVISORY: Official Payment Policy & Scam Fee Warning', 'public-advisory-official-payment-policy', 'public_advisory', 'The High Commission of the Federal Republic of Nigeria in Nairobi wishes to advise all citizens and visa applicants that ALL official consular fees (Passport applications, Visas, ETCs) are paid STRICTLY through authorized channels (Nigeria Immigration Service / Remita Portal). The High Commission NEVER requests cash transfers to private personal accounts or M-Pesa phone numbers. Report any unauthorized solicitation immediately.', 1, 1, '2026-10-01 09:00:00', 2),
(2, 'NOTICE: Holiday Closure for Independence Day & Mashujaa Day Observance', 'notice-holiday-closure-october-2026', 'holiday_announcement', 'The High Commission of the Federal Republic of Nigeria, Nairobi will be closed on official public holidays observed in both Nigeria and Kenya. Emergency consular contact protocols remain operational for registered citizens during non-business hours.', 0, 1, '2026-09-28 10:00:00', 2),
(3, 'PRESS RELEASE: Nigeria-Kenya Bilateral Business & Trade Forum 2026', 'press-release-nigeria-kenya-trade-forum-2026', 'press_release', 'His Excellency the High Commissioner presided over the bilateral trade symposium in Nairobi, focusing on financial technology, intra-African trade under AfCFTA, and renewable energy investments.', 0, 1, '2026-09-20 14:00:00', 2);

-- 9. Hero Slides Seed Data
INSERT IGNORE INTO `hero_slides` (`id`, `heading`, `subheading`, `image_desktop`, `image_mobile`, `image_alt`, `cta_primary_label`, `cta_primary_url`, `cta_secondary_label`, `cta_secondary_url`, `caption_theme`, `text_align`, `display_order`, `is_enabled`) VALUES
(1, 'Consular Services and Support, Made Easier', 'Serving Nigerian citizens, residents, and visitors in Kenya with transparent guidance and secure appointment bookings.', 'assets/images/hero-diplomatic.jpg', 'assets/images/hero-diplomatic.jpg', 'Nigeria High Commission Chancery Building Nairobi', 'Find a Service', '/services', 'Register as Nigerian in Kenya', '/diaspora/register', 'light_on_dark', 'left', 1, 1),
(2, 'Strengthening Nigeria-Kenya Economic Partnership', 'Fostering bilateral trade, investment opportunities, and commercial matchmaking across East Africa.', 'assets/images/hero-diplomatic.jpg', 'assets/images/hero-diplomatic.jpg', 'Bilateral Business Delegation in Nairobi', 'Explore Trade Opportunities', '/trade', 'Contact Trade Desk', '/contact', 'light_on_dark', 'left', 2, 1),
(3, 'Official Diaspora Citizen Registration Hub', 'Register your presence in Kenya to access emergency consular support and official Mission services.', 'assets/images/hero-diplomatic.jpg', 'assets/images/hero-diplomatic.jpg', 'Nigerian Diaspora Community Representative Assembly', 'Complete Registration', '/diaspora/register', 'Verify Record', '/verify', 'light_on_dark', 'left', 3, 1);


