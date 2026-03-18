<?php
// pages/questionnaire.php — Disease Screening Questionnaire
require_once __DIR__ . '/../config/config.php';
session_start();

$pageTitle = 'الفحص الصحي الشامل';
$extraCss = ['questionnaire.css'];
$extraJs  = ['questionnaire.js'];

include __DIR__ . '/../includes/header.php';
?>

<!-- Inject site URL for JS -->
<script>window.HAYA_SITE_URL = '<?= SITE_URL ?>';</script>

<div class="quest-container">
    <div class="quest-box">
        <div class="quest-header">
            <h1 class="quest-title">استبيان الفحص الصحي</h1>
            <p class="quest-subtitle">أجب عن الأسئلة التالية للحصول على تقييم صحي أولي</p>
        </div>

        <form id="questionnaireForm" novalidate>
            <!-- STEP 0: Demographic Info -->
            <div class="step-content active" data-step="0">
                <div class="section-tag">البيانات الأساسية</div>
                
                <div class="question-item">
                    <p class="question-text">الجنس</p>
                    <div class="options-grid">
                        <button type="button" class="option-btn" data-name="gender" data-value="male">
                            <span class="radio-check"></span> 👨 ذكر
                        </button>
                        <button type="button" class="option-btn" data-name="gender" data-value="female">
                            <span class="radio-check"></span> 👩 أنثى
                        </button>
                    </div>
                    <input type="hidden" name="gender" id="input_gender">
                </div>

                <div class="question-item">
                    <p class="question-text">العمر</p>
                    <div class="inline-options">
                        <button type="button" class="option-btn" data-name="age_group" data-value="under45" data-points="0">&lt; 45</button>
                        <button type="button" class="option-btn" data-name="age_group" data-value="45-54" data-points="2">45–54</button>
                        <button type="button" class="option-btn" data-name="age_group" data-value="55-64" data-points="3">55–64</button>
                        <button type="button" class="option-btn" data-name="age_group" data-value="over64" data-points="4">&gt; 64</button>
                    </div>
                    <input type="hidden" name="age_points" id="input_age_points">
                </div>

                <div class="question-item">
                    <p class="question-text">مؤشر كتلة الجسم (BMI)</p>
                    <div class="inline-options">
                        <button type="button" class="option-btn" data-name="bmi_group" data-value="under25" data-points="0">&lt; 25</button>
                        <button type="button" class="option-btn" data-name="bmi_group" data-value="25-30" data-points="1">25–30</button>
                        <button type="button" class="option-btn" data-name="bmi_group" data-value="over30" data-points="3">&gt; 30</button>
                    </div>
                    <input type="hidden" name="bmi_points" id="input_bmi_points">
                </div>

                <div class="question-item">
                    <p class="question-text">هل تم تشخيصك مسبقاً بأي من الحالات التالية؟</p>
                    <div class="inline-options">
                        <button type="button" class="option-btn multi-select" data-value="diabetes">السكر</button>
                        <button type="button" class="option-btn multi-select" data-value="hypertension">الضغط</button>
                        <button type="button" class="option-btn multi-select" data-value="thyroid">الغدة الدرقية</button>
                        <button type="button" class="option-btn multi-select" data-value="none">لا يوجد</button>
                    </div>
                    <input type="hidden" name="existing_conditions" id="input_existing">
                </div>

                <button type="button" class="cta-btn btn-next">ابدأ الفحص</button>
            </div>

            <!-- STEP 1: Vitamins -->
            <div class="step-content" data-step="1">
                <div class="section-tag">نقص الفيتامينات والمعادن</div>
                <div id="vitamins-questions">
                    <!-- Dynamic -->
                </div>
                <button type="button" class="cta-btn btn-next">القسم التالي</button>
            </div>

            <!-- STEP 2: Thyroid (Conditional) -->
            <div class="step-content" data-step="2" id="step-thyroid">
                <div class="section-tag">أعراض الغدة الدرقية</div>
                <div id="thyroid-questions">
                    <!-- Dynamic -->
                </div>
                <button type="button" class="cta-btn btn-next">القسم التالي</button>
            </div>

            <!-- STEP 3: Diabetes -->
            <div class="step-content" data-step="3" id="step-diabetes">
                <div class="section-tag">خطر الإصابة بالسكري</div>
                <div id="diabetes-questions">
                    <!-- Dynamic -->
                </div>
                <button type="button" class="cta-btn btn-next">القسم التالي</button>
            </div>

            <!-- STEP 4: Hypertension -->
            <div class="step-content" data-step="4" id="step-hypertension">
                <div class="section-tag">فحص ضغط الدم</div>
                <div id="hypertension-questions">
                    <!-- Dynamic -->
                </div>
                <button type="button" class="cta-btn btn-finish">عرض النتائج</button>
            </div>
        </form>

        <!-- Final Results State -->
        <div id="questResults" style="display:none;">
            <div class="quest-header">
                <h2 class="quest-title" style="color:#22c55e;">اكتمل الفحص بنجاح 🎉</h2>
                <p class="quest-subtitle">بناءً على إجاباتك، إليك التقييم المقترح لكل قسم:</p>
            </div>

            <div class="results-grid" id="resultsList">
                <!-- Result Cards go here -->
            </div>

            <div style="margin-top:2.5rem; padding:1.5rem; background:#f8fafc; border-radius:1rem; text-align:center;">
                <p style="font-size:0.85rem; color:#64748b; line-height:1.6;">
                    <strong>ملاحظة هامة:</strong> هذا التقرير هو لأغراض التوعية والإرشاد فقط ولا يُعتبر تشخيصاً طبياً. يرجى استشارة الطبيب المختص.
                </p>
                <button onclick="window.location.reload()" class="cta-btn-outline" style="margin-top:1.5rem; width:auto; padding:0.75rem 2rem;">إجراء فحص جديد</button>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
