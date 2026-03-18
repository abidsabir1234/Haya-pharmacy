<?php
// index.php — Entry point, redirect to Pioneers page
require_once __DIR__ . '/config/config.php';
header('Location: ' . SITE_URL . '/pages/pioneers.php');
exit;
