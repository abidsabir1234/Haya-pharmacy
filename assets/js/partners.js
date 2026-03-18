// assets/js/partners.js
// Identical logic to pioneers.js — targets partners registration endpoint

(function () {
    'use strict';

    var SITE_URL = window.HAYA_SITE_URL || '/Haya-Pharmacy';

    // ─── Welcome Banner ───────────────────────────────────────────
    function initWelcomeBanner() {
        var banner = document.getElementById('welcomeBanner');
        if (!banner) return;
        if (sessionStorage.getItem('haya_partners_welcomed')) {
            banner.remove();
            return;
        }
        banner.classList.add('open');
        var closeBtn = document.getElementById('welcomeCloseBtn');
        if (closeBtn) {
            closeBtn.addEventListener('click', function () {
                sessionStorage.setItem('haya_partners_welcomed', '1');
                banner.classList.remove('open');
                setTimeout(function () { banner.remove(); }, 400);
            });
        }
    }

    // ─── Modal ────────────────────────────────────────────────────
    function initModal() {
        var overlay     = document.getElementById('regModal');
        var openBtns    = document.querySelectorAll('.open-reg-modal');
        var closeBtn    = document.getElementById('modalClose');
        var form        = document.getElementById('regForm');
        var formWrap    = document.getElementById('modalFormWrap');
        var successWrap = document.getElementById('modalSuccess');

        if (!overlay) return;

        // Automatically show modal on page load (if not already closed this session)
        if (!sessionStorage.getItem('haya_partners_modal_shown')) {
            setTimeout(function() {
                overlay.classList.add('open');
                document.body.style.overflow = 'hidden';
                sessionStorage.setItem('haya_partners_modal_shown', '1');
            }, 1500); // 1.5s delay for smooth entry
        }

        openBtns.forEach(function (btn) {
            btn.addEventListener('click', function (e) {
                e.preventDefault();
                overlay.classList.add('open');
                document.body.style.overflow = 'hidden';
            });
        });

        if (closeBtn) closeBtn.addEventListener('click', closeModal);

        overlay.addEventListener('click', function (e) {
            if (e.target === overlay) closeModal();
        });

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') closeModal();
        });

        function closeModal() {
            overlay.classList.remove('open');
            document.body.style.overflow = '';
            setTimeout(function () {
                if (form) form.reset();
                clearErrors();
                if (formWrap) formWrap.classList.remove('hide');
                if (successWrap) successWrap.classList.remove('show');
            }, 400);
        }

        if (form) {
            var phoneInput = document.getElementById('reg_mobile');
            if (phoneInput) {
                phoneInput.addEventListener('input', function () {
                    this.value = this.value.replace(/[^0-9+]/g, '');
                });
            }

            form.addEventListener('submit', function (e) {
                e.preventDefault();
                if (!validateForm()) return;

                var submitBtn = form.querySelector('.form-submit');
                submitBtn.disabled = true;
                submitBtn.textContent = 'جارٍ التسجيل...';

                fetch(SITE_URL + '/handlers/register-partner.php', {
                    method: 'POST',
                    body: new FormData(form)
                })
                .then(function (res) { return res.json(); })
                .then(function (json) {
                    if (json.success) {
                        if (formWrap) formWrap.classList.add('hide');
                        if (successWrap) {
                            var cardNumEl = document.getElementById('successCardNumber');
                            if (cardNumEl) cardNumEl.textContent = json.card_number || '';
                            successWrap.classList.add('show');
                        }
                    } else {
                        showGlobalError(json.message || 'حدث خطأ، حاول مرة أخرى');
                    }
                })
                .catch(function () {
                    showGlobalError('حدث خطأ في الاتصال، حاول مرة أخرى');
                })
                .finally(function () {
                    submitBtn.disabled = false;
                    submitBtn.textContent = 'سجل الآن';
                });
            });
        }
    }

    function validateForm() {
        clearErrors();
        var valid  = true;
        var name   = document.getElementById('reg_name');
        var mobile = document.getElementById('reg_mobile');

        if (!name || !name.value.trim() || name.value.trim().length < 3) {
            showError('err_name', 'الاسم الكامل مطلوب (3 أحرف على الأقل)');
            valid = false;
        }
        if (!mobile || !/^[0-9+]{7,15}$/.test(mobile.value.trim())) {
            showError('err_mobile', 'أدخل رقم هاتف صحيح');
            valid = false;
        }
        return valid;
    }

    function showError(id, msg) {
        var el = document.getElementById(id);
        if (el) { el.textContent = msg; el.classList.add('show'); }
        var input = document.getElementById(id.replace('err_', 'reg_'));
        if (input) input.classList.add('error');
    }

    function clearErrors() {
        document.querySelectorAll('.form-error').forEach(function (el) { el.classList.remove('show'); });
        document.querySelectorAll('.form-control').forEach(function (el) { el.classList.remove('error'); });
        var ge = document.getElementById('globalError');
        if (ge) ge.style.display = 'none';
    }

    function showGlobalError(msg) {
        var ge = document.getElementById('globalError');
        if (ge) { ge.textContent = msg; ge.style.display = 'block'; }
    }

    document.addEventListener('DOMContentLoaded', function () {
        initModal();
    });

}());
