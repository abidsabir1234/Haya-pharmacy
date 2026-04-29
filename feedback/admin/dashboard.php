<?php
session_start();
require_once '../includes/db.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

// Filters
$branch_id = $_GET['branch_id'] ?? '';
$start_date = $_GET['start_date'] ?? '';
$end_date = $_GET['end_date'] ?? '';
$survey_type_filter = $_GET['survey_type'] ?? '';

$where_clauses = [];
$params = [];
if ($branch_id) {
    $where_clauses[] = "branch_id = ?";
    $params[] = $branch_id;
}
if ($start_date) {
    $where_clauses[] = "DATE(submitted_at) >= ?";
    $params[] = $start_date;
}
if ($end_date) {
    $where_clauses[] = "DATE(submitted_at) <= ?";
    $params[] = $end_date;
}
if ($survey_type_filter) {
    $where_clauses[] = "feedback_type = ?";
    $params[] = $survey_type_filter;
}
$where_sql = $where_clauses ? "WHERE " . implode(" AND ", $where_clauses) : "";

// Stats
$total_stmt = $pdo->prepare("SELECT COUNT(*) FROM feedback_responses $where_sql");
$total_stmt->execute($params);
$total_responses = $total_stmt->fetchColumn();

$today_stmt = $pdo->prepare("SELECT COUNT(*) FROM feedback_responses " . ($where_sql ? $where_sql . " AND " : "WHERE ") . "DATE(submitted_at) = CURDATE()");
$today_stmt->execute($params);
$today_responses = $today_stmt->fetchColumn();

// Ensure q3 and q4 columns exist
try {
    $pdo->exec("ALTER TABLE feedback_responses ADD COLUMN q3_emoji ENUM('happy', 'neutral', 'sad') DEFAULT 'neutral'");
    $pdo->exec("ALTER TABLE feedback_responses ADD COLUMN q4_emoji ENUM('happy', 'neutral', 'sad') DEFAULT 'neutral'");
} catch (PDOException $e) {
    // Columns already exist or error, ignore
}

// Happy / Neutral / Sad totals across all questions
$sentiments = ['happy' => 0, 'neutral' => 0, 'bad' => 0];
foreach (['q1_emoji', 'q2_emoji', 'q3_emoji', 'q4_emoji'] as $col) {
    try {
        $s = $pdo->prepare("SELECT {$col} as val, COUNT(*) as cnt FROM feedback_responses $where_sql GROUP BY {$col}");
        $s->execute($params);
        foreach ($s->fetchAll() as $r) {
            if ($r['val'] === 'happy')   $sentiments['happy']   += $r['cnt'];
            if ($r['val'] === 'neutral') $sentiments['neutral'] += $r['cnt'];
            if ($r['val'] === 'sad')     $sentiments['bad']     += $r['cnt'];
        }
    } catch (Exception $e) {}
}

// Chart data per question (split by survey type)
$chart_data = [];
foreach (['visit', 'delivery'] as $t) {
    for ($i = 1; $i <= 4; $i++) {
        $chart_data["{$t}_q{$i}"] = [0, 0, 0];
    }
}

$types_to_fetch = $survey_type_filter ? [$survey_type_filter] : ['visit', 'delivery'];

foreach ($types_to_fetch as $type) {
    $type_where = $where_clauses;
    $type_params = $params;
    
    // Add type filter if it wasn't already in $where_clauses
    if (!$survey_type_filter) {
        $type_where[] = "feedback_type = ?";
        $type_params[] = $type;
    }
    
    $type_sql = $type_where ? "WHERE " . implode(" AND ", $type_where) : "";
    
    foreach (['q1_emoji' => 1, 'q2_emoji' => 2, 'q3_emoji' => 3, 'q4_emoji' => 4] as $col => $idx) {
        try {
            $q = $pdo->prepare("SELECT {$col} as val, COUNT(*) as count FROM feedback_responses $type_sql GROUP BY {$col}");
            $q->execute($type_params);
            $counts = ['happy' => 0, 'neutral' => 0, 'sad' => 0];
            foreach ($q->fetchAll() as $r) {
                if (isset($counts[$r['val']])) {
                    $counts[$r['val']] = (int)$r['count'];
                }
            }
            $chart_data["{$type}_q{$idx}"] = [$counts['happy'], $counts['neutral'], $counts['sad']]; // Order: Happy, Neutral, Sad
        } catch (Exception $e) {}
    }
}

// Get branches from branches table
try {
    $branches = $pdo->query("SELECT id, branch_name, branch_slug FROM branches ORDER BY branch_name ASC")->fetchAll();
    $branches_count = count($branches);
} catch (Exception $e) {
    // Fallback if branches table doesn't exist
    $branches = $pdo->query("SELECT DISTINCT branch_id as id, branch_id as branch_name, branch_id as branch_slug FROM feedback_responses ORDER BY branch_id ASC")->fetchAll();
    $branches_count = count($branches);
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة مؤشرات رضا العملاء</title>
    <link rel="icon" type="image/png" href="../assets/images/logo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../assets/css/admin-style.css?v=2.7">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
            <a href="dashboard.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'active' : ''; ?>">الرسوم البيانية</a>
            <a href="responses.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'responses.php' ? 'active' : ''; ?>">ادارة الاستبيان</a>
            <a href="branches.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'branches.php' ? 'active' : ''; ?>">إدارة الفروع</a>
            <div class="nav-logout">
                <a href="logout.php" class="btn-logout">
                    <i class="bi bi-box-arrow-left"></i> خروج
                </a>
            </div>
        </div>
    </nav>

    <!-- Page Content -->
    <div class="admin-content">

        <!-- Filter Bar -->
        <div class="filter-card">
            <div class="filter-header">
                <h5 class="filter-title">فلتر نطاق التاريخ</h5>
            </div>
            <form action="" method="GET" class="filter-form">
                <div class="filter-actions">
                    <button type="submit" class="btn-apply"><i class="bi bi-funnel"></i> تصفية</button>
                    <a href="dashboard.php" class="btn-reset"><i class="bi bi-arrow-counterclockwise"></i> إعادة تعيين</a>
                </div>
                <div class="filter-group">
                    <label>من</label>
                    <input type="date" name="start_date" value="<?php echo htmlspecialchars($start_date); ?>">
                </div>
                <div class="filter-group">
                    <label>الى</label>
                    <input type="date" name="end_date" value="<?php echo htmlspecialchars($end_date); ?>">
                </div>
                <!-- Keeping branch filter for functionality, styled to match -->
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
                    <label>نوع الاستبيان</label>
                    <select name="survey_type">
                        <option value="">الكل</option>
                        <option value="visit" <?php echo $survey_type_filter === 'visit' ? 'selected' : ''; ?>>زيارة</option>
                        <option value="delivery" <?php echo $survey_type_filter === 'delivery' ? 'selected' : ''; ?>>توصيل</option>
                    </select>
                </div>
            </form>
        </div>

        <!-- Summary Cards -->
        <div class="summary-cards" style="grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));">
            <a href="responses.php?sentiment=happy&<?php echo http_build_query($_GET); ?>" class="summary-card card-green text-decoration-none">
                <div class="card-info">
                    <div class="card-label">عدد التقييمات السعيدة</div>
                    <div class="card-value"><?php echo str_pad($sentiments['happy'], 2, '0', STR_PAD_LEFT); ?></div>
                </div>
                <div class="card-icon">
                    <img src="../assets/images/Smile.png" alt="Smile">
                </div>
            </a>
            <a href="responses.php?sentiment=neutral&<?php echo http_build_query($_GET); ?>" class="summary-card card-yellow text-decoration-none">
                <div class="card-info">
                    <div class="card-label">عدد التقييمات المحايدة</div>
                    <div class="card-value"><?php echo str_pad($sentiments['neutral'], 2, '0', STR_PAD_LEFT); ?></div>
                </div>
                <div class="card-icon">
                    <img src="../assets/images/Neutral.png" alt="Neutral">
                </div>
            </a>
            <a href="responses.php?sentiment=sad&<?php echo http_build_query($_GET); ?>" class="summary-card card-red text-decoration-none">
                <div class="card-info">
                    <div class="card-label">عدد التقييمات السلبية</div>
                    <div class="card-value"><?php echo str_pad($sentiments['bad'], 2, '0', STR_PAD_LEFT); ?></div>
                </div>
                <div class="card-icon">
                    <img src="../assets/images/emoji_sad.png" alt="Sad">
                </div>
            </a>
            <a href="responses.php?<?php echo http_build_query($_GET); ?>" class="summary-card card-blue text-decoration-none">
                <div class="card-info">
                    <div class="card-label">إجمالي الردود</div>
                    <div class="card-value"><?php echo $total_responses; ?></div>
                </div>
                <div class="card-icon">
                    <img src="../assets/images/Envelope.svg" alt="Envelope">
                </div>
            </a>
            <a href="branches.php" class="summary-card text-decoration-none" style="background-color: #f6edea; border-color: #c09068;">
                <div class="card-info">
                    <div class="card-label">إدارة الفروع</div>
                    <div class="card-value"><?php echo $branches_count ?? 0; ?></div>
                </div>
                <div class="card-icon">
                    <i class="bi bi-shop fs-1" style="color: #c09068;"></i>
                </div>
            </a>
        </div>

        <!-- Charts -->
        <div class="charts-grid" style="grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));">
            
            <?php if ($survey_type_filter === '' || $survey_type_filter === 'visit'): ?>
            <div class="chart-card">
                <h6>شلون كانت زيارتك اليوم؟</h6>
                <canvas id="chart-visit-q1" height="180"></canvas>
            </div>
            <div class="chart-card">
                <h6>كيف كان تعاون فريق حيا معك ؟</h6>
                <canvas id="chart-visit-q2" height="180"></canvas>
            </div>
            <div class="chart-card">
                <h6>كيف تقيّم وقت الانتظار؟</h6>
                <canvas id="chart-visit-q3" height="180"></canvas>
            </div>
            <div class="chart-card">
                <h6>هل كانت المنتجات متوفّرة؟</h6>
                <canvas id="chart-visit-q4" height="180"></canvas>
            </div>
            <?php endif; ?>

            <?php if ($survey_type_filter === '' || $survey_type_filter === 'delivery'): ?>
            <div class="chart-card">
                <h6>كيف كانت تجربة التوصيل؟</h6>
                <canvas id="chart-delivery-q1" height="180"></canvas>
            </div>
            <div class="chart-card">
                <h6>كيف كان تعامل موصّل الطلب؟</h6>
                <canvas id="chart-delivery-q2" height="180"></canvas>
            </div>
            <div class="chart-card">
                <h6>كيف تقيّم سرعة التوصيل؟</h6>
                <canvas id="chart-delivery-q3" height="180"></canvas>
            </div>
            <div class="chart-card">
                <h6>هل وصل طلبك كاملاً وبحالة جيدة؟</h6>
                <canvas id="chart-delivery-q4" height="180"></canvas>
            </div>
            <?php endif; ?>
        </div>

    </div>

    <script>
        const chartColors = ['#015645', '#ffa500', '#ff3d3d']; // Green, Orange, Red
        const IMG_SIZE = 30;

        function loadImg(src) {
            const img = new Image();
            img.src = src;
            return img;
        }

        // faceImgs order: Happy, Neutral, Bad
        const faceImgs = [
            loadImg('../assets/images/Smile.png'),
            loadImg('../assets/images/Neutral.png'),
            loadImg('../assets/images/emoji_sad.png')
        ];

        // productImgs order: Yes, Some, No
        const productImgs = [
            loadImg('../assets/images/Ok.png'),
            loadImg('../assets/images/no.png'),
            loadImg('../assets/images/Bad.png')
        ];

        // Custom plugin: draws emoji images below each bar on X-axis
        function emojiAxisPlugin(imgs) {
            return {
                id: 'emojiAxis_' + Math.random(),
                afterDraw(chart) {
                    const ctx = chart.ctx;
                    const xAxis = chart.scales.x;
                    const bottom = chart.chartArea.bottom;
                    xAxis.ticks.forEach((tick, i) => {
                        const x = xAxis.getPixelForTick(i);
                        const img = imgs[i];
                        if (img && img.complete) {
                            ctx.drawImage(img, x - IMG_SIZE / 2, bottom + 8, IMG_SIZE, IMG_SIZE);
                        }
                    });
                }
            };
        }

        function makeChart(id, data, imgs) {
            new Chart(document.getElementById(id), {
                type: 'bar',
                data: {
                    labels: ['', '', ''], // Empty — images drawn by plugin
                    datasets: [{
                        data: data,
                        backgroundColor: chartColors,
                        borderRadius: 4,
                        barThickness: 45
                    }]
                },
                options: {
                    responsive: true,
                    layout: {
                        padding: {
                            bottom: IMG_SIZE + 12
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 3,
                                color: '#a0a0a0'
                            },
                            grid: {
                                color: '#f0f0f0',
                                borderDash: [4, 4],
                                drawBorder: false
                            }
                        },
                        x: {
                            ticks: {
                                display: false
                            },
                            grid: {
                                display: true,
                                color: '#f0f0f0',
                                borderDash: [4, 4],
                                drawBorder: false
                            }
                        }
                    }
                },
                plugins: [emojiAxisPlugin(imgs)]
            });
        }

        
        <?php if ($survey_type_filter === '' || $survey_type_filter === 'visit'): ?>
        makeChart('chart-visit-q1', <?php echo json_encode($chart_data['visit_q1']); ?>, faceImgs);
        makeChart('chart-visit-q2', <?php echo json_encode($chart_data['visit_q2']); ?>, faceImgs);
        makeChart('chart-visit-q3', <?php echo json_encode($chart_data['visit_q3']); ?>, faceImgs);
        makeChart('chart-visit-q4', <?php echo json_encode($chart_data['visit_q4']); ?>, faceImgs);
        <?php endif; ?>

        <?php if ($survey_type_filter === '' || $survey_type_filter === 'delivery'): ?>
        makeChart('chart-delivery-q1', <?php echo json_encode($chart_data['delivery_q1']); ?>, faceImgs);
        makeChart('chart-delivery-q2', <?php echo json_encode($chart_data['delivery_q2']); ?>, faceImgs);
        makeChart('chart-delivery-q3', <?php echo json_encode($chart_data['delivery_q3']); ?>, faceImgs);
        makeChart('chart-delivery-q4', <?php echo json_encode($chart_data['delivery_q4']); ?>, faceImgs);
        <?php endif; ?>

        // Hamburger Menu Toggle
        document.getElementById('navHamburger').addEventListener('click', function() {
            document.getElementById('navLinks').classList.toggle('open');
        });
    </script>

</body>

</html>