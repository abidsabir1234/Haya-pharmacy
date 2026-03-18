<?php
// admin/logout.php
require_once __DIR__ . '/../config/config.php';
session_start();
session_destroy();
header('Location: ' . SITE_URL . '/admin/index.php');
exit;
