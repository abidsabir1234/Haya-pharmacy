<?php
session_start();
try {
    require_once 'includes/db.php';

    // Use branch_slug directly as branch_id (no separate branches table)
    $branch_id     = $_SESSION['branch_slug'] ?? 'main-branch';
    $feedback_type = $_SESSION['survey_type']  ?? 'visit';

    // Map numeric values (1=sad, 2=neutral, 3=happy) to ENUM strings
    $emojiMap = ['1' => 'sad', '2' => 'neutral', '3' => 'happy'];
    $q1 = $emojiMap[strval($_SESSION['q1'] ?? '')] ?? 'neutral';
    $q2 = $emojiMap[strval($_SESSION['q2'] ?? '')] ?? 'neutral';
    $q3 = $emojiMap[strval($_SESSION['q3'] ?? '')] ?? 'neutral';
    $q4 = $emojiMap[strval($_SESSION['q4'] ?? '')] ?? 'neutral';

    $comment      = $_SESSION['comment'] ?? '';
    $phone_number = $_SESSION['phone']   ?? '';

    // Ensure q3 and q4 columns exist (migration)
    try {
        $pdo->exec("ALTER TABLE feedback_responses ADD COLUMN q3_emoji ENUM('happy', 'neutral', 'sad') DEFAULT 'neutral'");
        $pdo->exec("ALTER TABLE feedback_responses ADD COLUMN q4_emoji ENUM('happy', 'neutral', 'sad') DEFAULT 'neutral'");
    } catch (PDOException $e) { }

    // Insert into feedback_responses (actual table name in DB)
    $stmt = $pdo->prepare("INSERT INTO feedback_responses (branch_id, feedback_type, q1_emoji, q2_emoji, q3_emoji, q4_emoji, comment, phone_number) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$branch_id, $feedback_type, $q1, $q2, $q3, $q4, $comment ?: null, $phone_number ?: null]);

    // Clear session after submission (preserve branch_slug and survey_type)
    $current_branch = $_SESSION['branch_slug'] ?? 'main-branch';
    $current_type   = $_SESSION['survey_type']  ?? 'visit';
    session_unset();
    $_SESSION['branch_slug'] = $current_branch;
    $_SESSION['survey_type'] = $current_type;

    echo json_encode(['status' => 'success']);
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
}
