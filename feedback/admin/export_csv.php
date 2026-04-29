<?php
session_start();
require_once '../includes/db.php';

// Check if logged in
if (!isset($_SESSION['admin_id'])) {
    exit("Unauthorized");
}

// Filters
$branch_id          = $_GET['branch_id']  ?? '';
$start_date         = $_GET['start_date'] ?? '';
$end_date           = $_GET['end_date']   ?? '';
$sentiment          = $_GET['sentiment']  ?? '';
$has_comment        = $_GET['has_comment'] ?? '';
$has_phone          = $_GET['has_phone']   ?? '';
$survey_type_filter = $_GET['survey_type'] ?? '';

$where_clauses = [];
$params        = [];

if ($branch_id) {
    $where_clauses[] = "r.branch_id = ?";
    $params[]        = $branch_id;
}
if ($start_date) {
    $where_clauses[] = "DATE(r.submitted_at) >= ?";
    $params[]        = $start_date;
}
if ($end_date) {
    $where_clauses[] = "DATE(r.submitted_at) <= ?";
    $params[]        = $end_date;
}
if ($sentiment) {
    if ($sentiment === 'sad') {
        $where_clauses[] = "(r.q1_emoji = 'sad' OR r.q2_emoji = 'sad')";
    } elseif ($sentiment === 'neutral') {
        $where_clauses[] = "(r.q1_emoji = 'neutral' OR r.q2_emoji = 'neutral')";
    } elseif ($sentiment === 'happy') {
        $where_clauses[] = "(r.q1_emoji = 'happy' OR r.q2_emoji = 'happy')";
    }
}
if ($has_comment === 'yes') {
    $where_clauses[] = "r.comment IS NOT NULL AND r.comment != ''";
} elseif ($has_comment === 'no') {
    $where_clauses[] = "(r.comment IS NULL OR r.comment = '')";
}
if ($has_phone === 'yes') {
    $where_clauses[] = "r.phone_number IS NOT NULL AND r.phone_number != ''";
} elseif ($has_phone === 'no') {
    $where_clauses[] = "(r.phone_number IS NULL OR r.phone_number = '')";
}
if ($survey_type_filter) {
    $where_clauses[] = "r.feedback_type = ?";
    $params[]        = $survey_type_filter;
}

$where_sql = count($where_clauses) > 0
    ? "WHERE " . implode(" AND ", $where_clauses)
    : "";

// Fetch data — uses correct table & column names
$query = "SELECT r.submitted_at, r.branch_id, r.feedback_type,
                 r.q1_emoji, r.q2_emoji, r.comment, r.phone_number
          FROM feedback_responses r
          $where_sql
          ORDER BY r.submitted_at DESC";

$stmt = $pdo->prepare($query);
$stmt->execute($params);
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Send CSV headers
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=pharmacy_feedback_' . date('Y-m-d') . '.csv');

$output = fopen('php://output', 'w');

// BOM for Excel UTF-8 support
fprintf($output, chr(0xEF) . chr(0xBB) . chr(0xBF));

// CSV header row
fputcsv($output, ['Date & Time', 'Branch', 'Type', 'Q1', 'Q2', 'Comment', 'Phone']);

// Data rows
foreach ($data as $row) {
    fputcsv($output, [
        $row['submitted_at'],
        $row['branch_id'],
        $row['feedback_type'],
        $row['q1_emoji'],
        $row['q2_emoji'],
        $row['comment'],
        $row['phone_number'],
    ]);
}

fclose($output);
exit();
