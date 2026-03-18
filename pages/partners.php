<?php
// pages/partners.php — Partners Landing Page (Figma 100% Fidelity)
require_once __DIR__ . '/../config/config.php';
session_start();

$pageTitle = 'شركاء صيدلية حيا';
$hideStandardHeader = true; // Prevents double navbar
include __DIR__ . '/../includes/header.php';

// Partners Data
$partnersContent = [
    [
        'title' => 'المختبر الحديث للتحليلات المرضية',
        'owner' => 'إدارة: د. م. أياد عبد الحسين',
        'perks' => ['%25 خصم على كافة التحليلات', '%10 خصم على تحليلات الهرمونات'],
        'img'   => 'https://images.unsplash.com/photo-1579154235602-3c3b01a7d653?auto=format&fit=crop&w=600&q=80',
    ],
    [
        'title' => 'مركز الشرق الأوسط',
        'owner' => 'إدارة: د. محمد التميمي',
        'perks' => ['قسم الأشعة والسونار', 'خصم %15 على جميع الفحوصات'],
        'img'   => 'https://images.unsplash.com/photo-1516549655169-df83a0774514?auto=format&fit=crop&w=600&q=80',
    ],
    [
        'title' => 'د. ليث علي الجصاني',
        'owner' => 'أخصائي عيون',
        'perks' => ['فحص البصر وقياس درجة القرب', 'خصم %20 للشركاء الحاملين للبطاقة'],
        'img'   => 'https://images.unsplash.com/photo-1576091160550-217359f4b010?auto=format&fit=crop&w=600&q=80',
    ],
    [
        'title' => 'مركز النخبة لطب الأسنان',
        'owner' => 'إدارة: د. زينب الشمري',
        'perks' => ['تبييض وتنظيف الأسنان', '%30 خصم على كافة الخدمات السنية'],
        'img'   => 'https://images.unsplash.com/photo-1606811841689-23dfddce3e95?auto=format&fit=crop&w=600&q=80',
    ],
    [
        'title' => 'د. ميثم صاحب السعدي',
        'owner' => 'أخصائي أمراض القلب',
        'perks' => ['تخطيط القلب السونار الملون', 'خصم %15 على كافة الفحوصات'],
        'img'   => 'https://images.unsplash.com/photo-1628595351029-c2bf17511435?auto=format&fit=crop&w=600&q=80',
    ],
    [
        'title' => 'عيادات حيا التخصصية',
        'owner' => 'إدارة: د. سامر البدري',
        'perks' => ['كافة الاختصاصات الطبية', 'خصم %10 على الكشوفات الطبية'],
        'img'   => 'https://images.unsplash.com/photo-1519494026892-80bbd2d6fd0d?auto=format&fit=crop&w=600&q=80',
    ]
];

// Packages Data
$packagesContent = [
    [
        'title' => 'باكج الصحة النفسية',
        'tagline' => 'تنفس أفضل كل يوم',
        'desc' => 'باكج متكامل لدعم الجهاز التنفسي، والروحي',
        'img'   => SITE_URL . '/assets/images/card 3.svg',
        'icon'  => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20.42 4.58a5.4 5.4 0 0 0-7.65 0l-.77.78-.77-.78a5.4 5.4 0 0 0-7.65 0C1.46 6.7 1.33 10.28 4 13l8 8 8-8c2.67-2.72 2.54-6.3.42-8.42z"/></svg>',
        'list'  => [
            'جهاز بخار (سبيرومتري)',
            'كرتون بخاخ أنف',
            'بخاخ جيب الفلو تابعة',
            'بخاخ جيوب طبية',
            'مرهم مخصص للشخير',
            'حبوب وقائية للحساسية التنفسية',
            'مناديل بحجم اليد',
            'عبوات ماء معطرة',
            'فيتامين C',
            'بندول (Panadol)'
        ],
        'btn'   => 'اطلب باكج الصحة النفسية'
    ],
    [
        'title' => 'باكج رمضان الصحي',
        'tagline' => 'صيام مريح وطاقة أفضل',
        'desc' => 'دعم متكامل للجسم خلال شهر رمضان',
        'img'   => SITE_URL . '/assets/images/card 2.svg',
        'icon'  => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/></svg>',
        'list'  => [
            'مكمل مغنيسيوم (لتقليل التعب والشد العضلي)',
            'اوميغا 3',
            'فيتامين B',
            'تمر عضوي',
            'مرطب شفاه',
            'كمادة وجه دافئة',
            'معطر اليد (معقم للاستخدام)',
            'كرتون شاي أعشاب',
            'تمرات صحية مغلفة'
        ],
        'btn'   => 'اطلب باكج رمضان الصحي'
    ],
    [
        'title' => 'باكج عيد الأم',
        'tagline' => 'عناية متكاملة تستحقها كل أم',
        'desc' => 'باكج أنيق يجمع بين الصحة والعناية الوردية',
        'img'   => SITE_URL . '/assets/images/card 1.svg',
        'icon'  => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"/></svg>',
        'list'  => [
            'مكمل فيتامينات (صحة ونشاط دائم بالحياة)',
            'قناع تفتيح البشرة اليومي',
            'كريم يدينا المغذي للنوم',
            'ليف طبيعية للجلد',
            'زيت عطري مهدئ',
            'منشفة وجه ناعمة (قطن ميكروفيبر / حساسة)',
            'كرت معايدة (عيد أم سعيد)'
        ],
        'btn'   => 'اطلب باكج عيد الأم'
    ],
    [
        'title' => 'باكج المكتب / الموظف',
        'tagline' => 'نشاط وتركيز طول اليوم',
        'desc' => 'مصمم لدعم الموظفين ونمط الحياة المكتبي',
        'img'   => SITE_URL . '/assets/images/card 6.svg',
        'icon'  => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>', 
        'list'  => [
            'فيتامين B-Complex',
            'مغنيسيوم',
            'معقم يد',
            'كريم يد',
            'قطرات ترطيب العين',
            'شاي أعشاب أو قهوة صحية',
            'كريم رقبة أو جل عضلات',
            'مناديل مبللة',
            'مرطب شفاه',
            'حبوب صداع',
            'باكة طبية'
        ],
        'btn'   => 'اطلب باكج المكتب'
    ],
    [
        'title' => 'باكج التسنين',
        'tagline' => 'راحة لطفلك واطمئنان لك',
        'desc' => 'أساسيات العناية بمرحلة التسنين',
        'img'   => SITE_URL . '/assets/images/card 5.svg',
        'icon'  => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M4.5 16.5c-1.5 1.26-2 3.43-2 3.43s2.17-.5 3.43-2c1.57-1.87.87-4.17-.5-5.5-1.33-1.37-3.63-2.07-5.5-.5Zm15-9c1.5-1.26 2-3.43 2-3.43s-2.17.5-3.43 2c-1.57 1.87-.87 4.17.5 5.5 1.33 1.37 3.63 2.07 5.5.5ZM12 4v4m0 8v4m-8-8h4m8 0h4"/></svg>', 
        'list'  => [
            'مناديل',
            'عضاضة',
            'كريم ترطيب وجه',
            'محلول ملحي',
            'سيريلاك',
            'جل لثة',
            'شفاط أنف',
            'خافض حرارة'
        ],
        'btn'   => 'اطلب باكج التسنين'
    ],
    [
        'title' => 'باكج الرياضي',
        'tagline' => 'دعم الأداء والتعافي',
        'desc' => 'باكج مثالي للرياضيين ونمط الحياة النشط',
        'img'   => SITE_URL . '/assets/images/card 4.svg',
        'icon'  => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8h1a4 4 0 0 1 0 8h-1M2 8h16v8H2V8z"/><path d="M6 12h8"/></svg>', 
        'list'  => [
            'رباط ضاغط (ركبة او كاحل)',
            'مكمل Amino Acids',
            'سبراي تبريد فوري',
            'كريم تشققات القدم',
            'جل عضلات (تبريد / تسكين)',
            'مكمل فيتامينات غذائي'
        ],
        'btn'   => 'اطلب باكج الرياضي'
    ],
    [
        'title' => 'باكج التدخين',
        'tagline' => 'عناية يومية للمدخنين',
        'desc' => 'يساعد على تقليل آثار التدخين اليومية',
        'img'   => SITE_URL . '/assets/images/card 9.svg',
        'icon'  => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M18 12h3"/><path d="M18 10h3"/><path d="M3 12h11l2 2h4V10h-4l-2 2H3z"/><path d="M14 10V8a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v2"/></svg>', 
        'list'  => [
            'فيتامينات',
            'غسول فم',
            'مرطب شفاه',
            'علكة نيكوتين',
            'معجون أسنان',
            'فرشاة أسنان',
            'شرائح معطرة للفم',
            'بخاخ معطر للفم'
        ],
        'btn'   => 'اطلب باكج التدخين'
    ],
    [
        'title' => 'باكج السفر والتنقل',
        'tagline' => 'كل ما تحتاجه في شنطة واحدة',
        'desc' => 'أساسيات الصحة أثناء السفر والتنقل',
        'img'   => SITE_URL . '/assets/images/card 8.svg',
        'icon'  => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M16 10h4a2 2 0 0 1 2 2v1h-20v-1a2 2 0 0 1 2-2h4"/><path d="M15 10V6a2 2 0 0 0-2-2H11a2 2 0 0 0-2 2v4"/><path d="M3 13v5a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-5"/></svg>', 
        'list'  => [
            'حافظة حبوب',
            'قطرات عين مرطبة',
            'مرطب شفاه',
            'جل معقم لليدين',
            'مسكن OTC خفيف',
            'مناديل معقمة'
        ],
        'btn'   => 'اطلب باكج السفر'
    ],
    [
        'title' => 'باكج العناية اليومية للمرأة',
        'tagline' => 'عناية متكاملة لراحتك كل يوم',
        'desc' => 'باكج أساسي يدعم صحة المرأة والعناية الشخصية اليومية',
        'img'   => SITE_URL . '/assets/images/card 7.svg',
        'icon'  => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0"/><path d="M12 17l0 4"/><path d="M10 19l4 0"/></svg>', 
        'list'  => [
            'فيتامينات نسائية متعددة',
            'حقيبة صغيرة للمنتجات',
            'غسول نسائي لطيف',
            'مناديل دائرية جافة',
            'كريم مرطب لليد',
            'منظم حبوب / فيتامينات',
            'مرطب شفاف طبي (حجم صغير)'
        ],
        'btn'   => 'اطلب باكج العناية اليومية للمرأة'
    ],
    [
        'title' => 'باكج العناية بعد الحلاقة',
        'tagline' => 'راحة وتهدئة بعد كل حلاقة',
        'desc' => 'باكج مصمم لتهدئة البشرة وترطيبها بعد الحلاقة',
        'img'   => SITE_URL . '/assets/images/card 12.svg',
        'icon'  => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3l1 1"/><path d="M20 7l1 1"/><path d="M14 6l6 6"/><path d="M11 9l7 7"/><path d="M8 12l9 9"/><path d="M5 15l10 10"/></svg>', 
        'list'  => [
            'غسول وجه لطيف',
            'كريم ترطيب للبشرة',
            'جل أو كريم مهدئ بعد الحلاقة',
            'ليب بالم طبي',
            'ماسك للوجه'
        ],
        'btn'   => 'اطلب باكج العناية بعد الحلاقة'
    ],
    [
        'title' => 'باكج حب الشباب',
        'tagline' => 'بشرة أنقى بثقة أكبر',
        'desc' => 'باكج علاجي يومي مخصص للبشرة المعرضة لحب الشباب',
        'img'   => SITE_URL . '/assets/images/card 11.svg',
        'icon'  => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 21a9 9 0 1 0 0-18 9 9 0 0 0 0 18z"/><path d="M12 7v5"/><path d="M12 16h.01"/></svg>', 
        'list'  => [
            'غسول طبي مضاد لحب الشباب',
            'جل علاجي موضعي',
            'كريم مرطب خفيف',
            'واقي شمس',
            'لاصقات حبوب'
        ],
        'btn'   => 'اطلب باكج حب الشباب'
    ],
    [
        'title' => 'باكج دعم العظام والمفاصل',
        'tagline' => 'حركة أسهل وراحة أطول',
        'desc' => 'باكج متكامل لدعم العظام والمفاصل وتقليل الألم',
        'img'   => SITE_URL . '/assets/images/card 10.svg',
        'icon'  => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2a10 10 0 0 1 10 10c0 1.25-.25 2.5-.75 3.5"/><path d="M4 12a8 8 0 0 1 8-8"/><path d="M12 12m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"/><path d="M14.5 9.5l4.5 -4.5"/><path d="M9.5 14.5l-4.5 4.5"/></svg>', 
        'list'  => [
            'مكمل غذائي بالفيتامينات',
            'حافظة حبوب',
            'فيتامين D3',
            'كريم موضعي لتخفيف الألم',
            'كمادات صغيرة ساخنة / باردة',
            'كتر أو مسند طبية',
            'حزام أو جهاز تدليك كهربائي'
        ],
        'btn'   => 'اطلب باكج دعم العظام والمفاصل'
    ]
];
?>

<!-- Partners Page Specific Header -->
<div class="partners-top-bar">
    <div class="social-icons-left">
        <a href="#" class="social-icon" aria-label="Facebook">
            <svg viewBox="0 0 24 24" width="18" height="18" fill="currentColor"><path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"/></svg>
        </a>
        <a href="#" class="social-icon" aria-label="Snapchat">
            <svg viewBox="0 0 24 24" width="18" height="18" fill="currentColor"><path d="M12 2c-.8 0-1.5.3-2.1.8-.6.5-1 1.2-1.2 2.1-.2 1.3.4 2.5 1.5 3.3.1.1.3.2.4.3-.1 0-.2.1-.3.1-1.1.4-1.9 1.1-2.4 2.1-.5 1-.6 2.1-.4 3.2.3 1.5 1.4 2.7 2.8 3.2.1 0 .2.1.3.1-.1.1-.3.1-.4.2-.6.4-1 1-1.2 1.7-.2.7-.1 1.5.3 2.1.4.6 1.1 1 1.9 1.1.8.1 1.6-.1 2.2-.6.6-.5 1-1.2 1.2-2.1.2-1.3-.4-2.5-1.5-3.3l-.4-.3c.1 0 .2-.1.3-.1 1.1-.4 1.9-1.1 2.4-2.1.5-1 .6-2.1.4-3.2-.3-1.5-1.4-2.7-2.8-3.2l-.3-.1c.1-.1.3-.1.4-.2.6-.4 1-1 1.2-1.7.2-.7.1-1.5-.3-2.1-.4-.6-1.1-1-1.9-1.1-.1 0-.2 0-.3 0z"/></svg>
        </a>
        <a href="#" class="social-icon" aria-label="TikTok">
            <svg viewBox="0 0 24 24" width="18" height="18" fill="currentColor"><path d="M12.5 3v13.5a3.5 3.5 0 11-3.5-3.5c.3 0 .6 0 .9.1V9.2c-.3 0-.6-.1-.9-.1a7.5 7.5 0 107.5 7.5V7a5.5 5.5 0 004.5 5.4V8.5a1.5 1.5 0 01-4.5-4.5V3h-4z"/></svg>
        </a>
        <a href="#" class="social-icon" aria-label="Instagram">
            <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line></svg>
        </a>
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

<!-- Hero Section -->
<section class="partners-hero">
    <div class="hero-arc-element"></div>
    <div class="hero-overlay-content">
        <div class="promo-grid-figma">
            <div class="promo-text-group">
                <h1 class="promo-title-figma">خصومات<br>تصل إلي</h1>
                <a href="#" class="promo-reg-btn open-reg-modal">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>
                    سجل الآن
                </a>
            </div>
            <div class="promo-vertical-20">20%</div>
        </div>
    </div>

    <div class="countdown-banner-figma">
        <div class="timer-header-dark">
            عروض غطاء اشتمل على 25% عرض لفترة محدودة!
        </div>
        <div class="timer-body-row">
            <div class="flip-box-figma" id="days-box">
                <div class="card-unit" id="days">07</div>
                <div class="label-unit">DAYS</div>
            </div>
            <div class="flip-box-figma" id="hours-box">
                <div class="card-unit" id="hours">06</div>
                <div class="label-unit">HOURS</div>
            </div>
            <div class="flip-box-figma" id="mins-box">
                <div class="card-unit" id="mins">05</div>
                <div class="label-unit">MINUTES</div>
            </div>
            <div class="flip-box-figma" id="secs-box">
                <div class="card-unit" id="secs">01</div>
                <div class="label-unit">SECONDS</div>
            </div>
        </div>
    </div>
</section>

<!-- Packages Grid -->
<h2 class="packages-title">باكجات حيّا لكل فرد من العائلة</h2>
<section class="packages-grid">
    <?php foreach ($packagesContent as $pkg): ?>
        <div class="pkg-card">
            <img src="<?= $pkg['img'] ?>" alt="<?= $pkg['title'] ?>" class="pkg-img">
            <div class="pkg-content">
                <h3 class="pkg-name"><?= $pkg['title'] ?></h3>
                <p class="pkg-tagline"><?= $pkg['tagline'] ?></p>
                <p class="pkg-desc"><?= $pkg['desc'] ?></p>
                <ul class="pkg-list">
                    <?php foreach ($pkg['list'] as $item): ?>
                        <li><?= $item ?></li>
                    <?php endforeach; ?>
                </ul>
                <a href="#" class="pkg-btn open-reg-modal">
                    <?= $pkg['icon'] ?>
                    <?= $pkg['btn'] ?>
                </a>
            </div>
        </div>
    <?php endforeach; ?>
</section>

<!-- Why Choose Haya Section (Figma Exact Match) -->
<section class="partners-why-section">
    <div class="why-content-wrapper-figma">
        <h2 class="why-main-title-figma" style="color: #fff;">ليش تختار صيدلية حيا؟</h2>
        <div class="why-items-row-figma">
            <div class="why-item-figma">
                <div class="why-item-text" style="color: #fff;">صيدلانية مرخصة</div>
                <div class="why-icon-circle-figma">
                    <!-- Ribbon / Award Icon -->
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2zm0 13c1.66 0 3-1.34 3-3s-1.34-3-3-3-3 1.34-3 3 1.34 3 3 3z"/>
                        <circle cx="12" cy="12" r="1.5" fill="none" stroke="white" stroke-width="1.5"/>
                    </svg>
                </div>
            </div>
            <div class="why-item-figma">
                <div class="why-item-text" style="color: #fff;">أدوية مضمونة وأصلية</div>
                <div class="why-icon-circle-figma">
                    <!-- Diamond Icon -->
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12.14 3.1l8.52 7.08-1.57 3.33-6.95 7.39-6.95-7.39-1.57-3.33 8.52-7.08zM12 5.27l-6.18 5.12 1.16 2.47 5.02 5.34 5.02-5.34 1.16-2.47L12 5.27z"/>
                    </svg>
                </div>
            </div>
            <div class="why-item-figma">
                <div class="why-item-text" style="color: #fff;">خدمة مباشرة بدون تعقيد</div>
                <div class="why-icon-circle-figma">
                    <!-- Headset / Direct Service Icon -->
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                        <path d="M19.35 10.04C18.67 6.59 15.64 4 12 4s-6.67 2.59-7.35 6.04c-.1.52.32.96.85.96h.03c.4 0 .74-.29.81-.68C6.84 7.69 9.2 5.5 12 5.5s5.16 2.19 5.66 4.82c.07.39.41.68.81.68h.03c.53 0 .95-.44.85-.96z"/>
                    </svg>
                </div>
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
        <a href="https://wa.me/yournumber" class="btn-order-whatsapp">
            <span>اطلب الآن عبر واتساب</span>
            <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8l-6-6zm0 1.5L18.5 8H14V3.5zM6 20V4h7v5h5v11H6zm10-9h-8v1.5h8V11zm-8 3h8v1.5h-8V14z"/></svg>
        </a>
        <a href="tel:yournumber" class="btn-order-hotline">
            <span>اتصل بالخط الساخن</span>
            <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M6.62 10.79a15.053 15.053 0 006.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.24.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/></svg>
        </a>
    </div>
</section>

<!-- Partners Registration Modal (Figma Match) -->
<div id="regModal" class="reg-modal-overlay">
    <div class="reg-modal-content">
        <button id="modalClose" class="modal-close-btn" aria-label="Close">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>

        <div id="modalFormWrap">
            <form id="regForm" method="POST" novalidate>
                <div class="modal-form-group">
                    <label class="modal-label" for="reg_name">الاسم</label>
                    <input type="text" id="reg_name" name="reg_name" class="modal-input" placeholder="محمد" required>
                    <div id="err_name" class="form-error" style="color:red; font-size:0.8rem; margin-top:0.4rem; display:none;"></div>
                </div>

                <div class="modal-form-group">
                    <label class="modal-label" for="reg_mobile">رقم الهاتف</label>
                    <input type="tel" id="reg_mobile" name="reg_mobile" class="modal-input" placeholder="+20 10xxxxxxxx" required>
                    <div id="err_mobile" class="form-error" style="color:red; font-size:0.8rem; margin-top:0.4rem; display:none;"></div>
                </div>

                <div id="globalError" style="color:red; margin-bottom:1rem; display:none; text-align:center; font-weight:bold;"></div>

                <button type="submit" class="modal-submit-btn form-submit">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>
                    سجل الآن
                </button>
            </form>
        </div>

        <div id="modalSuccess" class="success-message-wrap">
            <div style="font-size: 3rem; margin-bottom: 1rem;">🎉</div>
            <h2 style="color: #005445; font-weight: 900; font-size: 2rem;">تم التسجيل بنجاح!</h2>
            <p style="color: #666; font-size: 1.1rem; margin-top: 0.5rem;">رقم بطاقة الشريك الخاص بك هو:</p>
            <div id="successCardNumber" class="success-card-num"></div>
            <button onclick="location.reload()" class="modal-submit-btn">حسناً</button>
        </div>
    </div>
</div>

<script src="<?= SITE_URL ?>/assets/js/partners.js"></script>

<script>
window.HAYA_SITE_URL = '<?= SITE_URL ?>';
function startCountdown() {
    const target = new Date().getTime() + (7 * 24 * 60 * 60 * 1000);
    setInterval(() => {
        const now = new Date().getTime();
        const diff = target - now;
        if(diff < 0) return;
        document.getElementById('days').innerText = String(Math.floor(diff / (1000 * 60 * 60 * 24))).padStart(2, '0');
        document.getElementById('hours').innerText = String(Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60))).padStart(2, '0');
        document.getElementById('mins').innerText = String(Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60))).padStart(2, '0');
        document.getElementById('secs').innerText = String(Math.floor((diff % (1000 * 60)) / 1000)).padStart(2, '0');
    }, 1000);
}
startCountdown();
</script>

</body>
</html>
