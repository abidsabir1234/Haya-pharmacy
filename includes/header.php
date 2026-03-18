<?php
// includes/header.php — Shared HTML head + site header
// Usage: include with $pageTitle set before including
$pageTitle = $pageTitle ?? 'صيدلية حيا';
$siteUrl   = defined('SITE_URL') ? SITE_URL : '/Haya-Pharmacy';
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?? 'صيدلية حيا - Haya Pharmacy' ?></title>
    <meta name="description" content="صيدلية حيا — شريكك لحياة صحية. برنامج الأوائل الحصري للعملاء المميزين.">
    <meta name="robots" content="index, follow">
    <link rel="icon" type="image/x-icon" href="<?= $siteUrl ?>/favicon.ico">
    <link rel="icon" type="image/png" href="<?= SITE_URL ?>/assets/images/favicon.png">
    <link rel="stylesheet" href="<?= $siteUrl ?>/assets/css/main.css">
    <?php if (!empty($extraCss)): ?>
        <?php foreach ($extraCss as $css): ?>
            <link rel="stylesheet" href="<?= $siteUrl ?>/assets/css/<?= $css ?>">
        <?php endforeach; ?>
    <?php endif; ?>

    <!-- Meta Pixel Code -->
    <script>
    !function(f,b,e,v,n,t,s)
    {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
    n.callMethod.apply(n,arguments):n.queue.push(arguments)};
    if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
    n.queue=[];t=b.createElement(e);t.async=!0;
    t.src=v;s=b.getElementsByTagName(e)[0];
    s.parentNode.insertBefore(t,s)}(window, document,'script',
    'https://connect.facebook.net/en_US/fbevents.js');
    fbq('init', '925043297093520');
    fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none"
    src="https://www.facebook.com/tr?id=925043297093520&ev=PageView&noscript=1"
    /></noscript>
    <!-- End Meta Pixel Code -->
</head>
<body>

<!-- ═══════════════════ SITE HEADER ═══════════════════ -->
<?php if (empty($hideStandardHeader)): ?>
<header class="site-header" id="siteHeader">
    <!-- Logo -->
    <div class="header-logo" style="height:5.75rem;">
        <img src="<?= $siteUrl ?>/assets/images/haya-logo.png"
             alt="Haya Pharmacy Logo" class="logo-color">
        <img src="<?= $siteUrl ?>/assets/images/haya-logo-wide-white.png"
             alt="Haya Pharmacy Logo" class="logo-white">
    </div>

    <!-- Navigation Links -->
    <nav class="header-nav" style="display: flex; gap: 2rem; align-items: center;">
        <a href="<?= $siteUrl ?>/pages/pioneers.php" style="font-weight: 700; color: var(--color-primary);">الأوائل</a>
        <a href="<?= $siteUrl ?>/pages/partners.php" style="font-weight: 700; color: var(--color-primary);">الشركاء</a>
        <a href="<?= $siteUrl ?>/pages/questionnaire.php" style="font-weight: 700; color: var(--color-primary);">الفحص الصحي</a>
        <a href="<?= $siteUrl ?>/pages/feedback.php" style="font-weight: 700; color: var(--color-primary);">التقييمات</a>
    </nav>

    <!-- Desktop social icons -->
    <div class="header-social">
        <!-- ... existing social icons ... -->
        <a href="#" class="social-icon" aria-label="Instagram">
            <svg viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" style="width:1.25rem;height:1.25rem;stroke:#fff">
                <rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/>
            </svg>
        </a>
        <a href="#" class="social-icon" aria-label="Facebook">
            <svg viewBox="0 0 24 24" style="width:1.25rem;height:1.25rem;fill:#fff">
                <path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"/>
            </svg>
        </a>
    </div>

    <!-- Mobile hamburger -->
    <button class="header-hamburger" id="menuToggle" aria-label="فتح القائمة">
        <svg width="24" height="24" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round">
            <line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/>
        </svg>
    </button>
</header>
<?php endif; ?>

<!-- ═══════════════════ MOBILE MENU ═══════════════════ -->
<div class="mobile-menu" id="mobileMenu">
    <button class="mobile-menu-close" id="menuClose" aria-label="إغلاق القائمة">
        <svg width="28" height="28" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round">
            <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
        </svg>
    </button>
    <img src="<?= $siteUrl ?>/assets/images/haya-logo-wide-white.png"
         alt="Haya Pharmacy" class="mobile-menu-logo" style="margin-bottom: 2rem;">
    
    <nav class="mobile-nav-links" style="display: flex; flex-direction: column; gap: 1.5rem; text-align: center; margin-bottom: 2rem;">
        <a href="<?= $siteUrl ?>/pages/pioneers.php" style="color: #fff; font-size: 1.25rem; font-weight: 700;">برنامج الأوائل</a>
        <a href="<?= $siteUrl ?>/pages/partners.php" style="color: #fff; font-size: 1.25rem; font-weight: 700;">برنامج الشركاء</a>
        <a href="<?= $siteUrl ?>/pages/questionnaire.php" style="color: #fff; font-size: 1.25rem; font-weight: 700;">الفحص الصحي المجاني</a>
        <a href="<?= $siteUrl ?>/pages/feedback.php" style="color: #fff; font-size: 1.25rem; font-weight: 700;">تقييم الخدمة</a>
    </nav>

    <div class="header-social">
        <a href="#" class="social-icon" aria-label="Instagram">
            <svg viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" style="width:1.25rem;height:1.25rem;stroke:#fff">
                <rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/>
            </svg>
        </a>
        <a href="#" class="social-icon" aria-label="Facebook">
            <svg viewBox="0 0 24 24" style="width:1.25rem;height:1.25rem;fill:#fff">
                <path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"/>
            </svg>
        </a>
    </div>
</div>
<!-- Header JS -->
<script>
(function(){
    var header   = document.getElementById('siteHeader');
    var toggle   = document.getElementById('menuToggle');
    var menu     = document.getElementById('mobileMenu');
    var closeBtn = document.getElementById('menuClose');

    window.addEventListener('scroll', function(){
        header.classList.toggle('scrolled', window.scrollY > 30);
    });

    toggle.addEventListener('click',   function(){ menu.classList.add('open');    document.body.style.overflow = 'hidden'; });
    closeBtn.addEventListener('click', function(){ menu.classList.remove('open'); document.body.style.overflow = ''; });
})();
</script>
