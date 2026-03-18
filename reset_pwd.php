<?php
// reset_pwd.php - Temporary script to reset admin password
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/includes/db.php';

$username = 'admin';
$password = 'haya2026';
$hash = password_hash($password, PASSWORD_BCRYPT);

try {
    $db = getDB();
    
    // Check if user exists
    $stmt = $db->prepare("SELECT id FROM admin_users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user) {
        $stmt = $db->prepare("UPDATE admin_users SET password_hash = ? WHERE username = ?");
        $stmt->execute([$hash, $username]);
        echo "Password for 'admin' has been reset to 'haya2026' successfully!";
    } else {
        $stmt = $db->prepare("INSERT INTO admin_users (username, password_hash) VALUES (?, ?)");
        $stmt->execute([$username, $hash]);
        echo "Admin user created with password 'haya2026'!";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
