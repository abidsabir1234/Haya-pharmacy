<?php
// ============================================================
// Haya Pharmacy — Helper Functions
// ============================================================
require_once __DIR__ . '/../includes/db.php';

/**
 * Sanitize a string input
 */
function clean(string $val): string {
    return htmlspecialchars(strip_tags(trim($val)), ENT_QUOTES, 'UTF-8');
}

/**
 * Generate a unique card number
 * Format: HAY-P-2026-0001
 */
function generateCardNumber(string $prefix, string $table): string {
    $db  = getDB();
    $year = date('Y');
    $stmt = $db->query("SELECT COUNT(*) FROM `$table`");
    $count = (int)$stmt->fetchColumn() + 1;
    return sprintf('%s-%s-%04d', $prefix, $year, $count);
}

/**
 * Format a datetime to Iraq time (UTC+3) for display
 */
function iraqTime(string $datetime): string {
    $dt = new DateTime($datetime, new DateTimeZone('UTC'));
    $dt->setTimezone(new DateTimeZone('Asia/Baghdad'));
    return $dt->format('Y-m-d H:i:s');
}

/**
 * Return JSON response and exit
 */
function jsonResponse(bool $success, string $message, array $data = []): void {
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(array_merge(['success' => $success, 'message' => $message], $data));
    exit;
}

/**
 * Redirect to a URL
 */
function redirect(string $url): void {
    header('Location: ' . $url);
    exit;
}

/**
 * Check admin is logged in, redirect if not
 */
function requireAdmin(): void {
    session_start();
    if (empty($_SESSION[ADMIN_SESSION_KEY])) {
        redirect(SITE_URL . '/admin/index.php');
    }
}

/**
 * Get today's stats for a card table
 */
function getCardStats(string $table): array {
    $db = getDB();
    $today = date('Y-m-d');
    return [
        'total'        => (int)$db->query("SELECT COUNT(*) FROM `$table`")->fetchColumn(),
        'today'        => (int)$db->query("SELECT COUNT(*) FROM `$table` WHERE DATE(created_at) = '$today'")->fetchColumn(),
        'males'        => (int)$db->query("SELECT COUNT(*) FROM `$table` WHERE gender = 'male'")->fetchColumn(),
        'females'      => (int)$db->query("SELECT COUNT(*) FROM `$table` WHERE gender = 'female'")->fetchColumn(),
    ];
}
