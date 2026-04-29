<?php
// ============================================================
// TEMPORARY ADMIN RESET SCRIPT — DELETE AFTER USE!
// ============================================================
require_once __DIR__ . '/config/config.php';

$new_username = 'admin';
$new_password = 'haya2026';
$new_hash = password_hash($new_password, PASSWORD_BCRYPT);

try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Show existing users
    $rows = $pdo->query("SELECT id, username FROM admin_users")->fetchAll(PDO::FETCH_ASSOC);
    echo "<h3>المستخدمين الحاليين في admin_users:</h3><pre>";
    print_r($rows);
    echo "</pre>";

    // Insert or update admin user
    $stmt = $pdo->prepare("
        INSERT INTO admin_users (username, password_hash)
        VALUES (:username, :hash)
        ON DUPLICATE KEY UPDATE password_hash = :hash2
    ");
    $stmt->execute([
        'username' => $new_username,
        'hash'     => $new_hash,
        'hash2'    => $new_hash,
    ]);

    echo "<p style='color:green;font-size:18px;'>✅ تم بنجاح! البيانات الجديدة:</p>";
    echo "<p><b>Username:</b> $new_username</p>";
    echo "<p><b>Password:</b> $new_password</p>";
    echo "<p style='color:red;'><b>⚠️ احذف هذا الملف من السيرفر فوراً بعد الاستخدام!</b></p>";
    echo "<p><a href='/sys/feedback/admin/login.php'>← الذهاب لصفحة الدخول</a></p>";

} catch (PDOException $e) {
    echo "<p style='color:red;'>❌ خطأ: " . $e->getMessage() . "</p>";
}
?>
