<?php
// admin/feedback.php — Feedback Dashboard (Figma Matching)
require_once __DIR__ . '/../includes/admin_header.php';

$db = getDB();

// ── Filtering Logic ──────────────────────────────────────────
$emojiFilter = $_GET['emoji'] ?? '';
$hasComment  = isset($_GET['has_comment']) && $_GET['has_comment'] == '1';
$searchPhone = $_GET['phone'] ?? '';
$dateFrom    = $_GET['date_from'] ?? '';
$dateTo      = $_GET['date_to'] ?? '';

$query = "SELECT * FROM feedback_responses WHERE 1=1";
$params = [];

if ($emojiFilter) {
    $query .= " AND q1_emoji = ?";
    $params[] = $emojiFilter;
}
if ($hasComment) {
    $query .= " AND comment != '' AND comment IS NOT NULL";
}
if ($searchPhone) {
    $query .= " AND phone_number LIKE ?";
    $params[] = "%$searchPhone%";
}
if ($dateFrom) {
    $query .= " AND DATE(submitted_at) >= ?";
    $params[] = $dateFrom;
}
if ($dateTo) {
    $query .= " AND DATE(submitted_at) <= ?";
    $params[] = $dateTo;
}

$query .= " ORDER BY submitted_at DESC";
$stmt = $db->prepare($query);
$stmt->execute($params);
$responses = $stmt->fetchAll();

// ── Calculate Stats ─────────────────────────────────────────
$totalCount   = (int)$db->query("SELECT COUNT(*) FROM feedback_responses")->fetchColumn();
$happyCount   = (int)$db->query("SELECT COUNT(*) FROM feedback_responses WHERE q1_emoji = 'happy'")->fetchColumn();
$neutralCount = (int)$db->query("SELECT COUNT(*) FROM feedback_responses WHERE q1_emoji = 'neutral'")->fetchColumn();
$sadCount     = (int)$db->query("SELECT COUNT(*) FROM feedback_responses WHERE q1_emoji = 'sad'")->fetchColumn();
?>

<div class="admin-main-card">
    <div class="admin-title-row">
        <h1>طلبات التقييم (Feedback)</h1>
    </div>

    <!-- Figma Stats Cards -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-card-label">إجمالي التقييمات</div>
            <div class="stat-card-row">
                <div class="stat-card-val"><?= number_format($totalCount) ?></div>
                <div class="stat-card-icon"><i>📊</i></div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-card-label">سعيدة (Happy)</div>
            <div class="stat-card-row">
                <div class="stat-card-val"><?= number_format($happyCount) ?></div>
                <div class="stat-card-icon"><i>😊</i></div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-card-label">عادية (Neutral)</div>
            <div class="stat-card-row">
                <div class="stat-card-val"><?= number_format($neutralCount) ?></div>
                <div class="stat-card-icon"><i>😐</i></div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-card-label">سيئة (Sad)</div>
            <div class="stat-card-row">
                <div class="stat-card-val"><?= number_format($sadCount) ?></div>
                <div class="stat-card-icon"><i>☹️</i></div>
            </div>
        </div>
    </div>

    <div class="admin-table-wrap">
        <table>
            <thead>
                <tr>
                    <th style="padding-right:0;">النوع</th>
                    <th>التقييم العام</th>
                    <th>تعاون الفريق</th>
                    <th>رقم الهاتف</th>
                    <th>التعليق</th>
                    <th style="padding-left:0;">التاريخ والوقت</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($responses)): ?>
                    <tr><td colspan="6" style="text-align:center; padding: 3rem; color: #999;">لا توجد سجلات مطابقة</td></tr>
                <?php else: ?>
                    <?php foreach ($responses as $row): ?>
                        <tr>
                            <td>
                                <span style="padding: 0.2rem 0.6rem; border-radius: 4px; font-size: 0.8rem; background: <?= $row['feedback_type'] == 'visit' ? '#eef2ff' : '#fff7ed' ?>; color: <?= $row['feedback_type'] == 'visit' ? '#4338ca' : '#c2410c' ?>;">
                                    <?= $row['feedback_type'] == 'visit' ? 'زيارة' : 'توصيل' ?>
                                </span>
                            </td>
                            <td>
                                <?php 
                                $e = $row['q1_emoji'];
                                if ($e == 'happy') echo '😊 سعيد جداً';
                                elseif ($e == 'neutral') echo '😐 عادي';
                                else echo '☹️ مستاء';
                                ?>
                            </td>
                            <td>
                                 <?php 
                                $e2 = $row['q2_emoji'];
                                if ($e2 == 'happy') echo 'ممتاز';
                                elseif ($e2 == 'neutral') echo 'جيد';
                                else echo 'ضعيف';
                                ?>
                            </td>
                            <td><?= $row['phone_number'] ?: '<span style="opacity:0.4">غير مقدم</span>' ?></td>
                            <td style="max-width:300px; white-space: normal; line-height: 1.4; font-size: 0.9rem;">
                                <?= htmlspecialchars($row['comment']) ?: '<span style="opacity:0.4">—</span>' ?>
                            </td>
                            <td dir="ltr" style="font-size: 0.9rem; color: #666;">
                                <?= iraqTime($row['submitted_at']) ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div style="margin-top: 3rem; display: flex; justify-content: space-between; align-items: center; border-top: 1px solid #eee; padding-top: 2rem;">
        <a href="export.php?type=feedback" class="cta-btn-green" style="width: auto; padding: 0.8rem 2rem; border-radius: 12px; font-size: 0.95rem;">تصدير بيانات CSV</a>
        
        <form method="GET" style="display: flex; gap: 1rem; align-items: center;">
             <input type="date" name="date_from" value="<?= htmlspecialchars($dateFrom) ?>" class="form-control" style="width: 150px; font-size: 0.85rem;">
             <span style="color: #999;">إلى</span>
             <input type="date" name="date_to" value="<?= htmlspecialchars($dateTo) ?>" class="form-control" style="width: 150px; font-size: 0.85rem;">
             <button type="submit" class="cta-btn-gold" style="width: auto; padding: 0.5rem 1.5rem; border-radius: 8px; font-size: 0.85rem;">فلترة</button>
        </form>
    </div>
</div>

</main>
</body>
</html>
