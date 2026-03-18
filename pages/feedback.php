<?php
// pages/feedback.php — Customer Satisfaction Survey
require_once __DIR__ . '/../config/config.php';
session_start();

$type = $_GET['type'] ?? 'visit'; // 'visit' or 'delivery'
$pageTitle = ($type === 'delivery') ? 'تقييم خدمة التوصيل' : 'كيف كانت زيارتك اليوم؟';
$extraCss = ['feedback.css'];
$extraJs  = ['feedback.js'];

include __DIR__ . '/../includes/header.php';
?>

<script>window.HAYA_SITE_URL = '<?= SITE_URL ?>';</script>

<!-- Background pattern layer (behind survey box) -->
<div style="position: fixed; inset: 0; z-index: -1; background-image: url('<?= SITE_URL ?>/assets/images/pattern-bg.png'); background-size: 300px; opacity: 0.05; pointer-events: none;"></div>

<?php
// Translations based on type
$texts = [
    'visit' => [
        'q1' => 'كيف كانت زيارتك اليوم؟',
        'q2' => 'كيف كان تعاون الفريق معك؟',
    ],
    'delivery' => [
        'q1' => 'كيف كانت خدمة التوصيل اليوم؟',
        'q2' => 'كيف كان تعامل المندوب معك؟',
    ]
];

$cur = $texts[$type] ?? $texts['visit'];
?>

<div class="feedback-container">
    <!-- Logo outside the box -->
    <img src="<?= SITE_URL ?>/assets/images/haya-logo.png" alt="صيدلية حيا" class="feedback-logo">
    
    <div class="feedback-tagline">صيدلية حيا شريكك لحياة صحية</div>

    <div class="survey-box">
        <!-- RTL Progress Bar -->
        <div class="progress-container">
            <div class="progress-bar" id="progressBar"></div>
        </div>

        <form id="feedbackForm" novalidate>
            <input type="hidden" name="feedback_type" value="<?= htmlspecialchars($type) ?>">
            
            <!-- Step 1: Visit/Delivery Quality -->
            <div class="survey-step active" data-step="1">
                <h2 class="question-title"><?= $cur['q1'] ?></h2>
                <div class="emoji-group">
                    <button type="button" class="emoji-btn" data-value="happy">
                        <span class="emoji-icon">😊</span>
                        <span class="emoji-label">سعيدة</span>
                    </button>
                    <button type="button" class="emoji-btn" data-value="neutral">
                        <span class="emoji-icon">😐</span>
                        <span class="emoji-label">عادية</span>
                    </button>
                    <button type="button" class="emoji-btn" data-value="sad">
                        <span class="emoji-icon">☹️</span>
                        <span class="emoji-label">سيئة</span>
                    </button>
                </div>
                <input type="hidden" name="q1_emoji" id="q1_input">
                <button type="button" class="form-submit btn-next" disabled>التالي</button>
            </div>

            <!-- Step 2: Team/Rider Support -->
            <div class="survey-step" data-step="2">
                <h2 class="question-title"><?= $cur['q2'] ?></h2>
                <div class="emoji-group">
                    <button type="button" class="emoji-btn" data-value="happy">
                        <span class="emoji-icon">😊</span>
                        <span class="emoji-label">ممتاز</span>
                    </button>
                    <button type="button" class="emoji-btn" data-value="neutral">
                        <span class="emoji-icon">😐</span>
                        <span class="emoji-label">جيد</span>
                    </button>
                    <button type="button" class="emoji-btn" data-value="sad">
                        <span class="emoji-icon">☹️</span>
                        <span class="emoji-label">ضعيف</span>
                    </button>
                </div>
                <input type="hidden" name="q2_emoji" id="q2_input">
                <button type="button" class="form-submit btn-next" disabled>التالي</button>
            </div>

            <!-- Step 3: Comments & Phone -->
            <div class="survey-step" data-step="3">
                <h2 class="question-title">رأيك يهمنا <span class="optional-text">(اختياري)</span></h2>
                <textarea name="comment" class="comment-area" placeholder="أخبرنا بالمزيد عن تجربتك..."></textarea>
                
                <div class="phone-input-wrap">
                    <label class="form-label">رقم الهاتف <span class="optional-text">(اختياري)</span></label>
                    <!-- Numbers only input -->
                    <input type="tel" name="phone_number" class="form-control" 
                           placeholder="07XXXXXXXXX" inputmode="numeric" 
                           oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                </div>

                <button type="submit" class="form-submit">إرسال التقييم</button>
            </div>
        </form>

        <div class="success-msg" id="feedbackSuccess" style="display:none;">
            <div class="success-icon" style="background:#f0fff4;">
                <svg viewBox="0 0 24 24" style="stroke:#22c55e;"><polyline points="20 6 9 17 4 12"/></svg>
            </div>
            <h3>شكراً لمشاركتنا رأيك!</h3>
            <p>نحن نقدر وقتك ونسعى دوماً لتقديم الأفضل.</p>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
