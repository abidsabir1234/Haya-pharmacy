<?php
// pages/pioneers.php — Pioneers Card Landing Page
require_once __DIR__ . '/../config/config.php';
session_start();

$pageTitle = 'بطاقة الأوائل';
$extraJs   = ['pioneers.js'];
$hideStandardHeader = true; // Use custom top bar below

include __DIR__ . '/../includes/header.php';
?>
<script>window.HAYA_SITE_URL = '<?= SITE_URL ?>';</script>
<div class="partners-top-bar" style="border-bottom: 1px solid #eee;">
    <div class="social-icons-left">
        <a href="#" class="social-icon"><svg viewBox="0 0 24 24" width="18" height="18" fill="currentColor"><path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"/></svg></a>
        <a href="#" class="social-icon"><svg viewBox="0 0 24 24" width="18" height="18" fill="currentColor"><path d="M12 2c-.8 0-1.5.3-2.1.8-.6.5-1 1.2-1.2 2.1-.2 1.3.4 2.5 1.5 3.3.1.1.3.2.4.3-.1 0-.2.1-.3.1-1.1.4-1.9 1.1-2.4 2.1-.5 1-.6 2.1-.4 3.2.3 1.5 1.4 2.7 2.8 3.2.1 0 .2.1.3.1-.1.1-.3.1-.4.2-.6.4-1 1-1.2 1.7-.2.7-.1 1.5.3 2.1.4.6 1.1 1 1.9 1.1.8.1 1.6-.1 2.2-.6.6-.5 1-1.2 1.2-2.1.2-1.3-.4-2.5-1.5-3.3l-.4-.3c.1 0 .2-.1.3-.1 1.1-.4 1.9-1.1 2.4-2.1.5-1 .6-2.1.4-3.2-.3-1.5-1.4-2.7-2.8-3.2l-.3-.1c.1-.1.3-.1.4-.2.6-.4 1-1 1.2-1.7.2-.7.1-1.5-.3-2.1-.4-.6-1.1-1-1.9-1.1-.1 0-.2 0-.3 0z"/></svg></a>
        <a href="#" class="social-icon"><svg viewBox="0 0 24 24" width="18" height="18" fill="currentColor"><path d="M12.5 3v13.5a3.5 3.5 0 11-3.5-3.5c.3 0 .6 0 .9.1V9.2c-.3 0-.6-.1-.9-.1a7.5 7.5 0 107.5 7.5V7a5.5 5.5 0 004.5 5.4V8.5a1.5 1.5 0 01-4.5-4.5V3h-4z"/></svg></a>
        <a href="#" class="social-icon"><svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line></svg></a>
    </div>

    <nav class="partners-centered-nav" style="display: flex; gap: 2.5rem; direction: rtl;">
        <a href="<?= SITE_URL ?>/pages/pioneers.php" style="color: #005445; font-weight: 800; text-decoration: none; font-size: 1.1rem;">الأوائل</a>
        <a href="<?= SITE_URL ?>/pages/partners.php" style="color: #005445; font-weight: 800; text-decoration: none; font-size: 1.1rem;">الشركاء</a>
        <a href="<?= SITE_URL ?>/pages/questionnaire.php" style="color: #005445; font-weight: 800; text-decoration: none; font-size: 1.1rem;">الفحص الصحي</a>
        <a href="<?= SITE_URL ?>/pages/feedback.php" style="color: #005445; font-weight: 800; text-decoration: none; font-size: 1.1rem;">التقييمات</a>
    </nav>

    <div class="top-logo-right">
        <img src="<?= SITE_URL ?>/assets/images/haya-logo.png" style="height: 3.5rem;">
    </div>
</div>

<!-- Pioneers Hero (Figma Match) -->
<section class="pioneers-hero-figma">
    <div class="hero-gold-curve"></div>
    <div class="hero-content-wrapper">
        <div class="hero-left-dr-wrap">
            <div class="hero-circle-frame">
                <img src="<?= SITE_URL ?>/assets/images/Frame 1.svg" alt="Decoration" class="frame-img">
            </div>
            <img src="<?= SITE_URL ?>/assets/images/doctor.svg" alt="Doctor" class="hero-dr-img-main">
        </div>
        <div class="hero-right-text-content">
            <h1 class="hero-top-msg">شكراً لثقتك</h1>
            <h2 class="hero-main-title">شكراً لأنك من <span class="highlight-green">"الأوائل"</span></h2>
            <p class="hero-desc">في أولى أيام الافتتاح، لم تكن مجرد زائر. بل كنت شريكاً لنا في خطوتنا الأولى. وتقديراً منا لهذه الثقة وهذا الوقت الذي شاركتنا فيه فرحة البداية، يسعدنا أن نهديك بطاقة "الأوائل" الحصرية.</p>
            <p class="hero-welcome">أهلاً ومرحباً بك في أسرة صيدلية حيا</p>
            <img src="<?= SITE_URL ?>/assets/images/haya-logo.png" class="hero-bottom-logo" alt="Haya Logo">
        </div>
    </div>
</section>

<!-- Our Mission / Best Services Section (New) -->
<section class="pioneers-mission-section">
    <div class="mission-container">
        <div class="mission-left-img">
            <div class="mission-img-card">
                 <!-- Reusing the doctor image or a suitable placeholder if no specific asset found -->
                 <img src="<?= SITE_URL ?>/assets/images/doctor.svg" alt="Mission" style="width: 100%; height: 100%; object-fit: cover; opacity: 0.9;">
                 <div class="mission-icon-badge">
                     <img src="<?= SITE_URL ?>/assets/images/pea .svg" alt="Icon">
                 </div>
            </div>
        </div>
        <div class="mission-right-content">
            <div class="mission-tag">
                <span class="dot"></span> نقدم لك أفضل الخدمات
            </div>
            <h2 class="mission-title">رسالتنا هي خدمتكم بكل حب وفخر</h2>
            <p class="mission-desc">نحن في صيدلية حيا، نضع صحتك وصحة عائلتك في مقدمة أولوياتنا. فريقنا المتخصص يعمل بشغف ليضمن لك تجربة صحية فريدة تتجاوز مجرد صرف الدواء.</p>
            
            <div class="mission-features-grid">
                <div class="m-feat-item">
                    <div class="m-feat-icon"><svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg></div>
                    <div class="m-feat-text">خطة صحية متكاملة</div>
                </div>
                <div class="m-feat-item">
                    <div class="m-feat-icon"><svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 3c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm0 14.2c-2.5 0-4.71-1.28-6-3.22.03-1.99 4-3.08 6-3.08 1.99 0 5.97 1.09 6 3.08-1.29 1.94-3.5 3.22-6 3.22z"/></svg></div>
                    <div class="m-feat-text">أطباء اختصاص وكادر متميز</div>
                </div>
            </div>
        </div>
    </div>
</section>



<!-- Pioneers Features Top Row -->
<section class="pioneers-features-list-section">
    <h2 class="section-title-partners" style="margin-bottom: 4rem;">ميزات "الأوائل"</h2>
    <div class="pioneers-features-flex-grid">
        <div class="p-features-row">
            <div class="p-feature-box">
                <span class="p-feature-text">فحص مجاني شهري</span>
                <div class="p-feature-icon-circle"><svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/></svg></div>
            </div>
            <div class="p-feature-box">
                <span class="p-feature-text">توصيل مجاني</span>
                <div class="p-feature-icon-circle"><svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M20 8h-3V4H3c-1.1 0-2 .9-2 2v11h2c0 1.66 1.34 3 3 3s3-1.34 3-3h6c0 1.66 1.34 3 3 3s3-1.34 3-3h2v-5l-3-4zM6 18.5c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5zm13.5-9l1.96 2.5H17V9.5h2.5zm0 9c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5z"/></svg></div>
            </div>
        </div>
        <div class="p-features-row">
            <div class="p-feature-box">
                <span class="p-feature-text">خصم إضافي 10% على كافة المنتجات</span>
                <div class="p-feature-icon-circle"><svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M7 2v10h10V2H7zm8 8H9V4h6v6zM2 20h20v-8H2v8zm18-6H4v4h16v-4z"/></svg></div>
            </div>
            <div class="p-feature-box">
                <span class="p-feature-text">الأولوية في الحصول على المنتجات غير المتوفرة</span>
                <div class="p-feature-icon-circle"><svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/></svg></div>
            </div>
        </div>
        <div class="p-features-row">
            <div class="p-feature-box wide">
                <span class="p-feature-text">تفعيل عضوية الأوائل مجاناً لمدة عام كامل</span>
                <div class="p-feature-icon-circle"><svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg></div>
            </div>
        </div>
    </div>
    <div style="text-align: center; margin-top: 2.5rem;">
        <button class="promo-reg-btn open-reg-modal">فعل الميزات الآن</button>
    </div>
</section>

<!-- Pioneers Info Grid (The 6 Cards) -->
<section class="pioneers-info-grid-section">
    <div class="pioneers-info-grid">
        <!-- Card 1 -->
        <div class="p-info-card">
            <div class="p-info-img-wrap">
                <img src="https://images.unsplash.com/photo-1576091160550-217359f4b010?auto=format&fit=crop&w=600&q=80" alt="Consultation">
            </div>
            <div class="p-info-content">
                <h3>استشارة مجانية من الخبراء</h3>
                <p>تواصل مع نخبة من الصيادلة الاستشاريين للحصول على أفضل نصيحة طبية مجانية.</p>
                <div class="p-info-pointer">✓</div>
            </div>
        </div>
        <!-- Card 2 -->
        <div class="p-info-card">
            <div class="p-info-img-wrap">
                <img src="https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?auto=format&fit=crop&w=600&q=80" alt="Priority">
            </div>
            <div class="p-info-content">
                <h3>الأولوية والتميز دائماً</h3>
                <p>صيدلية حيا تمنحك أولوية التجهيز والخدمة السريعة في كافة الأوقات.</p>
                <div class="p-info-pointer">✓</div>
            </div>
        </div>
        <!-- Card 3 -->
        <div class="p-info-card">
            <div class="p-info-img-wrap">
                <img src="https://images.unsplash.com/photo-1556742044-3c52d6e88c62?auto=format&fit=crop&w=600&q=80" alt="Delivery">
            </div>
            <div class="p-info-content">
                <h3>خدمة التوصيل</h3>
                <p>نوفر خدمة التوصيل المجاني والسريع لموقعك داخل مدينة بغداد.</p>
                <div class="p-info-pointer">✓</div>
            </div>
        </div>
        <!-- Card 4 -->
        <div class="p-info-card">
            <div class="p-info-img-wrap">
                <img src="https://images.unsplash.com/photo-1542831371-29b0f74f9713?auto=format&fit=crop&w=600&q=80" alt="Exclusive">
            </div>
            <div class="p-info-content">
                <h3>العروض الحصرية</h3>
                <p>استفد من خصومات وعروض شهرية مخصصة فقط لأعضاء بطاقة الأوائل.</p>
                <div class="p-info-pointer">✓</div>
            </div>
        </div>
        <!-- Card 5 -->
        <div class="p-info-card">
            <div class="p-info-img-wrap">
                <img src="https://images.unsplash.com/photo-1580674285054-bed31e145f59?auto=format&fit=crop&w=600&q=80" alt="Original">
            </div>
            <div class="p-info-content">
                <h3>منتجات أصلية</h3>
                <p>نضمن لك الحصول على أجود أنواع الأدوية والمكملات الغذائية الأصلية 100%.</p>
                <div class="p-info-pointer">✓</div>
            </div>
        </div>
        <!-- Card 6 -->
        <div class="p-info-card">
            <div class="p-info-img-wrap">
                <img src="https://images.unsplash.com/photo-1454165833767-027eeef1596e?auto=format&fit=crop&w=600&q=80" alt="Privacy">
            </div>
            <div class="p-info-content">
                <h3>الأمان والخصوصية</h3>
                <p>بياناتك الصحية وتاريخك الطبي محفوظ لدينا بأعلى مستويات الخصوصية.</p>
                <div class="p-info-pointer">✓</div>
            </div>
        </div>
    </div>
</section>

<!-- Why Choose Haya Section (Reused from Partners for consistency) -->
<section class="partners-why-section">
    <div class="why-content-wrapper-figma">
        <h2 class="why-main-title-figma" style="color: #fff;">ليش تختار صيدلية حيا؟</h2>
        <div class="why-items-row-figma">
            <div class="why-item-figma">
                <div class="why-item-text" style="color: #fff;">صيدلانية مرخصة</div>
                <div class="why-icon-circle-figma"><svg width="22" height="22" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg></div>
            </div>
            <div class="why-item-figma">
                <div class="why-item-text" style="color: #fff;">أدوية مضمونة وأصلية</div>
                <div class="why-icon-circle-figma"><svg width="22" height="22" viewBox="0 0 24 24" fill="currentColor"><path d="M12.14 3.1l8.52 7.08-1.57 3.33-6.95 7.39-6.95-7.39-1.57-3.33 8.52-7.08z"/></svg></div>
            </div>
            <div class="why-item-figma">
                <div class="why-item-text" style="color: #fff;">خدمة مباشرة بدون تعقيد</div>
                <div class="why-icon-circle-figma"><svg width="22" height="22" viewBox="0 0 24 24" fill="currentColor"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg></div>
            </div>
        </div>
    </div>
</section>

<!-- Ready to Order Section -->
<section class="ready-to-order-section">
    <div class="bg-pattern-figma left"></div>
    <div class="bg-pattern-figma right"></div>
    <h2 class="ready-title">جاهز تطلب؟</h2>
    <div class="ready-btns-row">
        <a href="https://wa.me/9647700000000" class="btn-order-whatsapp"><span>اطلب الآن عبر واتساب</span><svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8l-6-6zm0 1.5L18.5 8H14V3.5zM6 20V4h7v5h5v11H6z"/></svg></a>
        <a href="tel:9647700000000" class="btn-order-hotline"><span>اتصل بالخط الساخن</span><svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M6.62 10.79a15.053 15.053 0 006.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.24.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/></svg></a>
    </div>
</section>

<!-- Bottom Notice Bar -->
<div class="baghdad-only-bar">خدمتنا داخل بغداد فقط</div>

<!-- Pioneers Registration Modal (Matches Partners Popup) -->
<div id="regModal" class="reg-modal-overlay">
    <div class="reg-modal-content">
        <button id="modalClose" class="modal-close-btn" aria-label="Close"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
        <div id="modalFormWrap">
            <form id="regForm" method="POST" novalidate>
                <div class="modal-form-group"><label class="modal-label">الاسم</label><input type="text" id="reg_name" name="reg_name" class="modal-input" placeholder="محمد" required></div>
                <div class="modal-form-group"><label class="modal-label">رقم الهاتف</label><input type="tel" id="reg_mobile" name="reg_mobile" class="modal-input" placeholder="+20 10xxxxxxxx" required></div>
                <button type="submit" class="modal-submit-btn form-submit">سجل الآن</button>
            </form>
        </div>
        <div id="modalSuccess" class="success-message-wrap">
            <div style="font-size: 3rem; margin-bottom: 1rem;">🎉</div>
            <h2 style="color: #005445; font-weight: 900;">تم التسجيل بنجاح!</h2>
            <p>رقم بطاقة الأوائل الخاص بك هو:</p>
            <div id="successCardNumber" class="success-card-num"></div>
            <button onclick="location.reload()" class="modal-submit-btn">حسناً</button>
        </div>
    </div>
</div>

<script src="<?= SITE_URL ?>/assets/js/pioneers.js"></script>
</body>
</html>
