<?php
// handlers/register-pioneer.php
// Handles pioneer card registration form submission via AJAX POST

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/functions.php';

header('Content-Type: application/json; charset=utf-8');

// Only allow POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    jsonResponse(false, 'Method not allowed.');
}

// ── Collect and validate inputs ──────────────────────────────────
$name   = clean($_POST['reg_name']   ?? '');
$mobile = clean($_POST['reg_mobile'] ?? '');
$dob    = isset($_POST['reg_dob']) ? clean($_POST['reg_dob']) : null;
$gender = isset($_POST['reg_gender']) ? clean($_POST['reg_gender']) : null;

if (empty($name) || empty($mobile)) {
    jsonResponse(false, 'الاسم ورقم الهاتف مطلوبان');
}

// ── Check for duplicate phone number ─────────────────────────────
$db = getDB();
$stmt = $db->prepare('SELECT id FROM pioneers_cards WHERE mobile_number = ?');
$stmt->execute([$mobile]);
if ($stmt->fetch()) {
    jsonResponse(false, 'رقم الهاتف هذا مسجل بالفعل في برنامج الأوائل');
}

// ── Generate card number & insert ────────────────────────────────
try {
    $cardNumber = generateCardNumber(PIONEER_PREFIX, 'pioneers_cards');

    $insert = $db->prepare(
        'INSERT INTO pioneers_cards (card_number, full_name, mobile_number, gender, date_of_birth)
         VALUES (?, ?, ?, ?, ?)'
    );
    $insert->execute([$cardNumber, $name, $mobile, $gender, $dob]);

    jsonResponse(true, 'تم التسجيل بنجاح', [
        'card_number' => $cardNumber,
        'name'        => $name,
    ]);
} catch (PDOException $e) {
    jsonResponse(false, 'حدث خطأ أثناء التسجيل، حاول مرة أخرى');
}
