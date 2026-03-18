<?php
// admin/questionnaire.php — Health Screening Submissions (Figma Matching)
require_once __DIR__ . '/../includes/admin_header.php';

$db = getDB();

// ── Filtering Logic ──────────────────────────────────────────
$genderFilter = $_GET['gender'] ?? '';
$riskFilter   = $_GET['risk_type'] ?? ''; // 'dia', 'hyp', 'thy'
$dateFrom     = $_GET['date_from'] ?? '';
$dateTo       = $_GET['date_to'] ?? '';

$query = "SELECT * FROM questionnaire_submissions WHERE 1=1";
$params = [];

if ($genderFilter) {
    $query .= " AND gender = ?";
    $params[] = $genderFilter;
}
if ($riskFilter === 'dia') {
    $query .= " AND diabetes_risk_level IN ('high', 'very_high')";
} elseif ($riskFilter === 'hyp') {
    $query .= " AND hypertension_risk_level = 'high'";
} elseif ($riskFilter === 'thy') {
    $query .= " AND thyroid_risk_level = 'high'";
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
$submissions = $stmt->fetchAll();

// Statistics
$total      = (int)$db->query("SELECT COUNT(*) FROM questionnaire_submissions")->fetchColumn();
$highRiskD  = (int)$db->query("SELECT COUNT(*) FROM questionnaire_submissions WHERE diabetes_risk_level IN ('high', 'very_high')")->fetchColumn();
$highRiskH  = (int)$db->query("SELECT COUNT(*) FROM questionnaire_submissions WHERE hypertension_risk_level = 'high'")->fetchColumn();
$highRiskT  = (int)$db->query("SELECT COUNT(*) FROM questionnaire_submissions WHERE thyroid_risk_level = 'high'")->fetchColumn();

function translateRiskLabel($l) {
    $map = [
        'low' => 'منخفض',
        'moderate' => 'متوسط',
        'high' => 'مرتفع',
        'very_high' => 'مرتفع جداً',
        'slightly_elevated' => 'مرتفع قليلاً'
    ];
    return $map[$l] ?? $l;
}
?>

<div class="admin-main-card">
    <div class="admin-title-row">
        <h1>نتائج الفحص الصحي</h1>
    </div>

    <!-- Figma Stats Cards -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-card-label">إجمالي الفحوصات</div>
            <div class="stat-card-row">
                <div class="stat-card-val"><?= number_format($total) ?></div>
                <div class="stat-card-icon"><i>📋</i></div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-card-label">خطر سكر عالٍ</div>
            <div class="stat-card-row">
                <div class="stat-card-val" style="color: #ef4444;"><?= number_format($highRiskD) ?></div>
                <div class="stat-card-icon"><i>🩸</i></div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-card-label">خطر ضغط عالٍ</div>
            <div class="stat-card-row">
                <div class="stat-card-val" style="color: #ef4444;"><?= number_format($highRiskH) ?></div>
                <div class="stat-card-icon"><i>💓</i></div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-card-label">خطر غدة عالٍ</div>
            <div class="stat-card-row">
                <div class="stat-card-val" style="color: #ef4444;"><?= number_format($highRiskT) ?></div>
                <div class="stat-card-icon"><i>🦋</i></div>
            </div>
        </div>
    </div>

    <div class="admin-table-wrap">
        <table>
            <thead>
                <tr>
                    <th style="padding-right:0;">الجنس</th>
                    <th>الفيتامينات</th>
                    <th>الغدة الدرقية</th>
                    <th>السكري</th>
                    <th>ضغط الدم</th>
                    <th style="padding-left:0;">التاريخ والوقت</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($submissions)): ?>
                    <tr><td colspan="6" style="text-align:center; padding: 3rem; color: #999;">لا يوجد نتائج تطابق هذه الفلترة</td></tr>
                <?php else: ?>
                    <?php foreach ($submissions as $row): ?>
                        <tr>
                            <td style="color: #005445; font-weight: 700;"><?= $row['gender'] == 'male' ? 'ذكر' : 'أنثى' ?></td>
                            <td>
                                <span class="risk-badge <?= $row['vitamin_risk_level'] ?>">
                                    <?= translateRiskLabel($row['vitamin_risk_level']) ?>
                                </span>
                            </td>
                            <td>
                                <?php if ($row['thyroid_risk_level']): ?>
                                    <span class="risk-badge <?= $row['thyroid_risk_level'] ?>">
                                        <?= translateRiskLabel($row['thyroid_risk_level']) ?>
                                    </span>
                                <?php else: ?>
                                    <span style="opacity:0.4">—</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <span class="risk-badge <?= $row['diabetes_risk_level'] ?>">
                                    <?= translateRiskLabel($row['diabetes_risk_level']) ?>
                                </span>
                            </td>
                            <td>
                                <span class="risk-badge <?= $row['hypertension_risk_level'] ?>">
                                    <?= translateRiskLabel($row['hypertension_risk_level']) ?>
                                </span>
                            </td>
                            <td dir="ltr" style="font-size: 0.9rem; color: #666;"><?= iraqTime($row['submitted_at']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div style="margin-top: 3rem; display: flex; justify-content: space-between; align-items: center; border-top: 1px solid #eee; padding-top: 2rem;">
        <a href="export.php?type=questionnaire" class="cta-btn-green" style="width: auto; padding: 0.8rem 2rem; border-radius: 12px; font-size: 0.95rem;">تصدير بيانات CSV</a>
        
        <form method="GET" style="display: flex; gap: 1rem; align-items: center;">
             <input type="date" name="date_from" value="<?= htmlspecialchars($dateFrom) ?>" class="form-control" style="width: 150px; font-size: 0.85rem;">
             <span style="color: #999;">إلى</span>
             <input type="date" name="date_to" value="<?= htmlspecialchars($dateTo) ?>" class="form-control" style="width: 150px; font-size: 0.85rem;">
             <button type="submit" class="cta-btn-gold" style="width: auto; padding: 0.5rem 1.5rem; border-radius: 8px; font-size: 0.85rem;">فلترة</button>
        </form>
    </div>
</div>

<style>
    .risk-badge { padding: 0.2rem 0.6rem; border-radius: 6px; font-size: 0.8rem; font-weight: 700; white-space: nowrap; }
    .risk-badge.low { background: #ecfdf5; color: #065f46; }
    .risk-badge.moderate, .risk-badge.slightly_elevated { background: #fffbeb; color: #92400e; }
    .risk-badge.high, .risk-badge.very_high { background: #fef2f2; color: #991b1b; }
</style>

</main>
</body>
</html>
