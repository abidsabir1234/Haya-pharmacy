// assets/js/pioneers.js
// Handles: Welcome banner, registration popup, form validation, AJAX submit

(function () {
    'use strict';

    var SITE_URL = window.HAYA_SITE_URL || '/Haya-Pharmacy';

    // ─── Welcome Banner ───────────────────────────────────────────
    function initWelcomeBanner() {
        var banner = document.getElementById('welcomeBanner');
        if (!banner) return;

        // Only show once per session
        if (sessionStorage.getItem('haya_welcomed')) {
            banner.remove();
            return;
        }

        banner.classList.add('open');

        var closeBtn = document.getElementById('welcomeCloseBtn');
        if (closeBtn) {
            closeBtn.addEventListener('click', function () {
                sessionStorage.setItem('haya_welcomed', '1');
                banner.classList.remove('open');
                setTimeout(function () { banner.remove(); }, 400);
            });
        }
    }

    // ─── Modal (Registration Popup) ───────────────────────────────
    function initModal() {
        var overlay    = document.getElementById('regModal');
        var openBtns   = document.querySelectorAll('.open-reg-modal');
        var closeBtn   = document.getElementById('modalClose');
        var form       = document.getElementById('regForm');
        var formWrap   = document.getElementById('modalFormWrap');
        var successWrap = document.getElementById('modalSuccess');

        if (!overlay) return;

        // Open modal
        openBtns.forEach(function (btn) {
            btn.addEventListener('click', function (e) {
                e.preventDefault();
                overlay.classList.add('open');
                document.body.style.overflow = 'hidden';
            });
        });

        // Close modal (X button)
        if (closeBtn) {
            closeBtn.addEventListener('click', closeModal);
        }

        // Close modal (click outside)
        overlay.addEventListener('click', function (e) {
            if (e.target === overlay) closeModal();
        });

        // Escape key
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') closeModal();
        });

        function closeModal() {
            overlay.classList.remove('open');
            document.body.style.overflow = '';
            // Reset form after close
            setTimeout(function () {
                if (form) form.reset();
                clearErrors();
                if (formWrap) formWrap.classList.remove('hide');
                if (successWrap) successWrap.classList.remove('show');
            }, 400);
        }

        // ─── Form Submission ───────────────────────────────────────
        if (form) {
            // Phone number: numbers only
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

                var data = new FormData(form);

                fetch(SITE_URL + '/handlers/register-pioneer.php', {
                    method: 'POST',
                    body: data
                })
                .then(function (res) { return res.json(); })
                .then(function (json) {
                    if (json.success) {
                        // Show success state
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
                    submitBtn.textContent = 'تسجيل الآن';
                });
            });
        }
    }

    // ─── Form Validation ──────────────────────────────────────────
    function validateForm() {
        var valid = true;
        var name    = document.getElementById('reg_name');
        var mobile  = document.getElementById('reg_mobile');

        if (!name || !name.value.trim()) {
            valid = false;
        }

        if (!mobile || !mobile.value.trim()) {
            valid = false;
        }

        return valid;
    }

    function showError(id, msg) {
        var el = document.getElementById(id);
        if (el) { el.textContent = msg; el.classList.add('show'); }
        var inputId = id.replace('err_', 'reg_');
        var input = document.getElementById(inputId);
        if (input) input.classList.add('error');
    }

    function clearErrors() {
        document.querySelectorAll('.form-error').forEach(function (el) {
            el.classList.remove('show');
        });
        document.querySelectorAll('.form-control').forEach(function (el) {
            el.classList.remove('error');
        });
        var ge = document.getElementById('globalError');
        if (ge) { ge.style.display = 'none'; }
    }

    function showGlobalError(msg) {
        var ge = document.getElementById('globalError');
        if (ge) { ge.textContent = msg; ge.style.display = 'block'; }
    }

    // ─── Init ─────────────────────────────────────────────────────
    document.addEventListener('DOMContentLoaded', function () {
        initWelcomeBanner();
        initModal();
    });

}());
