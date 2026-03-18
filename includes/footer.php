<?php
// includes/footer.php — Shared site footer + scroll animation JS
$siteUrl = defined('SITE_URL') ? SITE_URL : '/Haya-Pharmacy';
?>
<!-- ═══════════════════ FOOTER ═══════════════════ -->
<footer class="site-footer">
    <img src="<?= $siteUrl ?>/assets/images/haya-logo-wide-white.png"
         alt="Haya Pharmacy" class="footer-logo">
    <p class="footer-copy">© 2026 صيدلية حيا. جميع الحقوق محفوظة.</p>
</footer>

<!-- ═══════════ Global Scroll Animation JS ═══════════ -->
<script>
(function(){
    var targets = document.querySelectorAll('.fade-in-up, .feature-card');
    if (!targets.length) return;
    var observer = new IntersectionObserver(function(entries){
        entries.forEach(function(entry){
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.15 });
    targets.forEach(function(el){ observer.observe(el); });
})();
</script>

<?php if (!empty($extraJs)): ?>
    <?php foreach ($extraJs as $js): ?>
        <script src="<?= $siteUrl ?>/assets/js/<?= $js ?>"></script>
    <?php endforeach; ?>
<?php endif; ?>
</body>
</html>
