<?php
// ============================================================
// Haya Pharmacy — Site Configuration
// ============================================================

// Database settings
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'haya_pharmacy');
define('DB_CHARSET', 'utf8mb4');

// Site settings
define('SITE_NAME', 'صيدلية حيا');
define('SITE_NAME_EN', 'Haya Pharmacy');
define('SITE_URL', 'http://localhost/Haya-Pharmacy');

// Iraq timezone (UTC+3)
define('SITE_TIMEZONE', 'Asia/Baghdad');
date_default_timezone_set(SITE_TIMEZONE);

// Card number prefixes
define('PIONEER_PREFIX', 'HAY-P');
define('PARTNER_PREFIX', 'HAY-S'); // شريك

// Admin session key
define('ADMIN_SESSION_KEY', 'haya_admin_logged_in');

// Error reporting (set to 0 on production)
error_reporting(E_ALL);
ini_set('display_errors', 1);
