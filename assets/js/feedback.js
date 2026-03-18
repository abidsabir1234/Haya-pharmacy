/* assets/js/feedback.js */
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('feedbackForm');
    const steps = document.querySelectorAll('.survey-step');
    const progressBar = document.getElementById('progressBar');
    const successBox = document.getElementById('feedbackSuccess');
    const totalSteps = steps.length;
    let currentStep = 1;

    // Handle Emoji Selection
    document.querySelectorAll('.emoji-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const stepGroup = this.closest('.survey-step');
            const stepNum = stepGroup.dataset.step;
            const value = this.dataset.value;

            // Deselect others in same step
            stepGroup.querySelectorAll('.emoji-btn').forEach(b => b.classList.remove('selected'));
            this.classList.add('selected');

            // Update hidden input
            document.getElementById(`q${stepNum}_input`).value = value;

            // Enable next button
            stepGroup.querySelector('.btn-next').disabled = false;
        });
    });

    // Handle Next Buttons
    document.querySelectorAll('.btn-next').forEach(btn => {
        btn.addEventListener('click', function() {
            if (currentStep < totalSteps) {
                goToStep(currentStep + 1);
            }
        });
    });

    function goToStep(step) {
        steps.forEach(s => s.classList.remove('active'));
        document.querySelector(`.survey-step[data-step="${step}"]`).classList.add('active');
        currentStep = step;
        updateProgress();
    }

    function updateProgress() {
        const percent = ((currentStep - 1) / (totalSteps - 1)) * 100;
        progressBar.style.width = percent + '%';
    }

    // Handle Form Submission
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            const submitBtn = this.querySelector('button[type="submit"]');
            submitBtn.disabled = true;
            submitBtn.innerText = 'جاري الإرسال...';

            fetch(window.HAYA_SITE_URL + '/handlers/submit-feedback.php', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    form.style.display = 'none';
                    progressBar.parentElement.style.display = 'none';
                    successBox.style.display = 'block';
                } else {
                    alert(data.message || 'حدث خطأ ما، يرجى المحاولة لاحقاً');
                    submitBtn.disabled = false;
                    submitBtn.innerText = 'إرسال التقييم';
                }
            })
            .catch(err => {
                console.error(err);
                alert('حدث خطأ في الاتصال بالسيرفر');
                submitBtn.disabled = false;
                submitBtn.innerText = 'إرسال التقييم';
            });
        });
    }
});
