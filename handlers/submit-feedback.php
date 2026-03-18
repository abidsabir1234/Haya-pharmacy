<?php
// handlers/submit-feedback.php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonResponse(false, 'طريقة طلب غير صالحة');
}

// 1. Sanitize Inputs
$type       = clean($_POST['feedback_type'] ?? 'visit');
$q1         = clean($_POST['q1_emoji'] ?? '');
$q2         = clean($_POST['q2_emoji'] ?? '');
$comment    = clean($_POST['comment'] ?? '');
$mobile     = clean($_POST['phone_number'] ?? '');

// 2. Validate Required
if (!$q1 || !$q2) {
    jsonResponse(false, 'يرجى اختيار الوجوه التعبيرية للأسئلة المطلوبة');
}

// 3. Normalize mobile (Numbers only)
$mobile = preg_replace('/[^0-9]/', '', $mobile);

try {
    $db = getDB();
    $stmt = $db->prepare("
        INSERT INTO feedback_responses (feedback_type, q1_emoji, q2_emoji, comment, phone_number, branch_id)
        VALUES (?, ?, ?, ?, ?, ?)
    ");

    // For now, branch_id is set to 'Main' or can be dynamic later
    $stmt->execute([
        $type,
        $q1,
        $q2,
        $comment,
        $mobile,
        'بغداد - المقر الرئيسي'
    ]);

    jsonResponse(true, 'تم إرسال تقييمك بنجاح. شكراً لك!');

} catch (PDOException $e) {
    error_log("Feedback Error: " . $e->getMessage());
    jsonResponse(false, 'عذراً، حدث خطأ أثناء حفظ التقييم. يرجى المحاولة لاحقاً.');
}
