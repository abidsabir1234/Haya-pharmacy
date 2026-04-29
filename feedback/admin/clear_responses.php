<?php
session_start();
require_once '../includes/db.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['clear_data'])) {
    try {
        // This command deletes all rows and resets the auto-increment counter
        $pdo->exec("TRUNCATE TABLE feedback_responses");
        $success_msg = "تم حذف جميع الردود والتقييمات بنجاح!";
    } catch (PDOException $e) {
        $error_msg = "حدث خطأ أثناء الحذف: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تفريغ الردود</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Tajawal', sans-serif; background-color: #f4f7f6; }
        .card { max-width: 500px; margin: 100px auto; border: none; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
    </style>
</head>
<body>
    <div class="container">
        <div class="card p-5 text-center">
            <h2 class="mb-4 text-danger">تفريغ جميع البيانات</h2>
            <p class="text-muted mb-4">هل أنت متأكد أنك تريد حذف جميع التقييمات والردود من الداشبورد؟ <br><b>لا يمكن التراجع عن هذا الإجراء!</b></p>
            
            <?php if (isset($success_msg)): ?>
                <div class="alert alert-success"><?php echo $success_msg; ?></div>
            <?php endif; ?>
            <?php if (isset($error_msg)): ?>
                <div class="alert alert-danger"><?php echo $error_msg; ?></div>
            <?php endif; ?>

            <form method="POST">
                <button type="submit" name="clear_data" class="btn btn-danger w-100 mb-3" onclick="return confirm('هل أنت متأكد بنسبة 100% من حذف كل البيانات؟');">
                    نعم، احذف جميع الردود
                </button>
                <a href="dashboard.php" class="btn btn-outline-secondary w-100">إلغاء والعودة للداشبورد</a>
            </form>
        </div>
    </div>
</body>
</html>
