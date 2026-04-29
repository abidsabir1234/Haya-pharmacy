<?php
session_start();
require_once '../includes/db.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

// Filters
$branch_id   = $_GET['branch_id']   ?? '';
$start_date  = $_GET['start_date']  ?? '';
$end_date    = $_GET['end_date']    ?? '';
$sentiment   = $_GET['sentiment']   ?? '';
$has_comment = $_GET['has_comment'] ?? '';
$has_phone   = $_GET['has_phone']   ?? '';
$survey_type_filter = $_GET['survey_type'] ?? '';

$where_clauses = [];
$params = [];

if ($branch_id && $branch_id !== "") {
    $where_clauses[] = "r.branch_id = ?";
    $params[] = $branch_id;
}

if ($start_date && $end_date) {
    if (strtotime($start_date) > strtotime($end_date)) {
        $temp = $start_date;
        $start_date = $end_date;
        $end_date = $temp;
    }
}

if ($start_date) {
    $where_clauses[] = "r.submitted_at >= ?";
    $params[] = $start_date . " 00:00:00";
}

if ($end_date) {
    $where_clauses[] = "r.submitted_at <= ?";
    $params[] = $end_date . " 23:59:59";
}

if ($sentiment) {
    if ($sentiment === 'sad') {
        $where_clauses[] = "(r.q1_emoji = 'sad' OR r.q2_emoji = 'sad' OR r.q3_emoji = 'sad' OR r.q4_emoji = 'sad')";
    } elseif ($sentiment === 'neutral') {
        $where_clauses[] = "(r.q1_emoji = 'neutral' OR r.q2_emoji = 'neutral' OR r.q3_emoji = 'neutral' OR r.q4_emoji = 'neutral')";
    } elseif ($sentiment === 'happy') {
        $where_clauses[] = "(r.q1_emoji = 'happy' OR r.q2_emoji = 'happy' OR r.q3_emoji = 'happy' OR r.q4_emoji = 'happy')";
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
    $params[] = $survey_type_filter;
}

$where_sql = $where_clauses ? "WHERE " . implode(" AND ", $where_clauses) : "";

$query = "SELECT r.*, r.branch_id as branch_name FROM feedback_responses r $where_sql ORDER BY r.submitted_at DESC";

// DEBUG INFO FOR LIVE SERVER
$debug_info = [
    'query' => $query,
    'params' => $params,
    'get' => $_GET
];

try {
    $stmt = $pdo->prepare($query);
    $stmt->execute($params);
    $responses = $stmt->fetchAll();
} catch (PDOException $e) {
    $responses = [];
    $error = "Database Error: " . $e->getMessage();
}

try {
    $branches = $pdo->query("SELECT id, branch_name, branch_slug FROM branches ORDER BY branch_name ASC")->fetchAll();
} catch (Exception $e) {
    // Fallback if branches table doesn't exist
    $branches = $pdo->query("SELECT DISTINCT branch_id as id, branch_id as branch_name, branch_id as branch_slug FROM feedback_responses ORDER BY branch_id ASC")->fetchAll();
}

function sentimentHtml($val)
{
    $map = [
        'happy'   => '../assets/images/Smile.png',
        'neutral' => '../assets/images/Neutral.png',
        'sad'     => '../assets/images/emoji_sad.png',
    ];
    if (!isset($map[$val])) return '-';
    return '<img src="' . $map[$val] . '" alt="' . htmlspecialchars($val) . '" style="width:32px;height:32px;object-fit:contain;">';
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>جدول الردود - لوحة مؤشرات رضا العملاء</title>
    <link rel="icon" type="image/png" href="../assets/images/logo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../assets/css/admin-style.css?v=2.7">
</head>

<body>

    <!-- Top Bar -->
    <div class="admin-topbar">
        <span class="topbar-title">لوحة مؤشرات رضا العملاء</span>
        <img src="../assets/images/Mask group.svg" alt="Haya Logo" class="topbar-logo">
    </div>

    <!-- Nav Tabs -->
    <nav class="admin-nav">
        <button class="nav-hamburger" id="navHamburger">
            <i class="bi bi-list"></i>
        </button>
        <div class="admin-nav-links" id="navLinks">
            <a href="dashboard.php" class="nav-link">الرسوم البيانية</a>
            <a href="responses.php" class="nav-link active">ادارة الاستبيان</a>
            <a href="branches.php" class="nav-link">إدارة الفروع</a>
            <div class="nav-logout">
                <a href="logout.php" class="btn-logout"><i class="bi bi-box-arrow-left"></i> خروج</a>
            </div>
        </div>
    </nav>

    <div class="admin-content">
        <!-- Filter Bar -->
        <div class="filter-card">
            <div class="filter-header">
                <h5 class="filter-title">فلتر نطاق التاريخ</h5>
            </div>
            <form action="" method="GET" class="filter-form">
                <div class="filter-group">
                    <label>الفرع</label>
                    <select name="branch_id">
                        <option value="">الكل</option>
                        <?php foreach ($branches as $b): ?>
                            <option value="<?php echo $b['branch_slug'] ?? $b['id']; ?>" <?php echo $branch_id == ($b['branch_slug'] ?? $b['id']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($b['branch_name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="filter-group">
                    <label>من</label>
                    <input type="date" name="start_date" value="<?php echo htmlspecialchars($start_date); ?>">
                </div>
                <div class="filter-group">
                    <label>الى</label>
                    <input type="date" name="end_date" value="<?php echo htmlspecialchars($end_date); ?>">
                </div>
                <div class="filter-group">
                    <label>الانطباع</label>
                    <select name="sentiment">
                        <option value="">كافة الحالات</option>
                        <option value="happy" <?php echo $sentiment === 'happy' ? 'selected' : ''; ?>>سعيد</option>
                        <option value="neutral" <?php echo $sentiment === 'neutral' ? 'selected' : ''; ?>>محايد</option>
                        <option value="sad" <?php echo $sentiment === 'sad' ? 'selected' : ''; ?>>سلبي</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label>التعليق</label>
                    <select name="has_comment">
                        <option value="">الجميع</option>
                        <option value="yes" <?php echo $has_comment === 'yes' ? 'selected' : ''; ?>>يوجد تعليق</option>
                        <option value="no" <?php echo $has_comment === 'no' ? 'selected' : ''; ?>>بدون تعليق</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label>رقم الهاتف</label>
                    <select name="has_phone">
                        <option value="">الجميع</option>
                        <option value="yes" <?php echo $has_phone === 'yes' ? 'selected' : ''; ?>>يوجد رقم</option>
                        <option value="no" <?php echo $has_phone === 'no' ? 'selected' : ''; ?>>بدون رقم</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label>نوع الاستبيان</label>
                    <select name="survey_type">
                        <option value="">الكل</option>
                        <option value="visit" <?php echo $survey_type_filter === 'visit' ? 'selected' : ''; ?>>زيارة</option>
                        <option value="delivery" <?php echo $survey_type_filter === 'delivery' ? 'selected' : ''; ?>>توصيل</option>
                    </select>
                </div>
                <div class="filter-actions">
                    <button type="submit" class="btn-apply"><i class="bi bi-funnel"></i> تصفية</button>
                    <a href="responses.php" class="btn-reset"><i class="bi bi-arrow-counterclockwise"></i> إعادة تعيين</a>
                </div>
            </form>
        </div>

        <?php if ($sentiment): ?>
            <div class="alert alert-info d-flex justify-content-between align-items-center mb-0 mt-3 rounded-3">
                <span>
                    <i class="bi bi-filter-circle"></i> عرض النتائج: 
                    <strong>
                        <?php 
                        if ($sentiment === 'sad') echo 'كل الردود السلبية/غير الراضية';
                        if ($sentiment === 'neutral') echo 'كل الردود المحايدة';
                        if ($sentiment === 'happy') echo 'كل الردود السعيدة/الراضية';
                        ?>
                    </strong>
                </span>
                <a href="responses.php?<?php echo http_build_query(array_diff_key($_GET, ['sentiment' => ''])); ?>" class="btn btn-sm btn-outline-info">إلغاء الفلتر</a>
            </div>
        <?php endif; ?>

        <!-- Responses Table -->
        <div class="table-card mt-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="section-title mb-0 fs-3" style="color: #015645; font-weight: 800;">جدول الردود</div>
                <a href="export_csv.php?<?php echo http_build_query($_GET); ?>" class="btn-export">
                    <i class="bi bi-download"></i> تصدير إلى...
                </a>
            </div>
            <?php if (count($responses) > 0): ?>
                <table class="responses-table">
                    <thead>
                        <tr>
                            <th>التاريخ والوقت</th>
                            <th>الفرع</th>
                            <th>نوع الاستبيان</th>
                            <th>تقييم الزيارة/التوصيل</th>
                            <th>وقت الانتظار/سرعة التوصيل</th>
                            <th>تعاون الفريق/المندوب</th>
                            <th>توفر المنتج/حالة الطلب</th>
                            <th>رقم الموبايل</th>
                            <th>تعليق</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($responses as $row): ?>
                            <tr>
                                <td class="text-muted" style="font-size:12px; white-space:nowrap;">
                                    <?php echo date('Y-m-d', strtotime($row['submitted_at'])); ?><br>
                                    <?php echo date('H:i', strtotime($row['submitted_at'])); ?>
                                </td>
                                <td><?php echo htmlspecialchars($row['branch_name']); ?></td>
                                <td><?php echo ($row['feedback_type'] ?? 'visit') === 'delivery' ? 'توصيل' : 'زيارة'; ?></td>
                                <td><?php echo sentimentHtml($row['q1_emoji']); ?></td>
                                <td><?php echo sentimentHtml($row['q2_emoji']); ?></td>
                                <td><?php echo sentimentHtml($row['q3_emoji']); ?></td>
                                <td><?php echo sentimentHtml($row['q4_emoji']); ?></td>
                                <td style="direction:ltr;"><?php echo htmlspecialchars($row['phone_number'] ?: '-'); ?></td>
                                <td class="comment-cell"><?php echo htmlspecialchars($row['comment'] ?: '-'); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="text-center py-5 text-muted">
                    <i class="bi bi-inbox fs-1"></i>
                    <p class="mt-3">لا توجد ردود تطابق معايير البحث.</p>
                </div>
            <?php endif; ?>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Hamburger Menu Toggle
        document.getElementById('navHamburger').addEventListener('click', function() {
            document.getElementById('navLinks').classList.toggle('open');
        });
    </script>
</body>

</html>