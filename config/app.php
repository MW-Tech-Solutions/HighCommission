<?php
// Application Configuration & Session Setup

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

\App\Core\Helper::setSecurityHeaders();


return [
    'name' => 'High Commission of the Federal Republic of Nigeria, Nairobi',
    'short_name' => 'Nigeria High Commission Nairobi',
    'location' => 'Lenana Road, Kilimani, P.O. Box 30516, Nairobi, Kenya',
    'official_email' => 'info@nigeriankenya.or.ke',
    'emergency_phone' => '+254 795 770 247',
    'working_hours' => 'Monday - Friday: 9:00 AM - 3:00 PM',
    'timezone' => 'Africa/Nairobi',
    'environment' => 'demonstration', // 'demonstration' or 'production'
];
