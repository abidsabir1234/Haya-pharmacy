/* assets/js/questionnaire.js */
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('questionnaireForm');
    const resultsDiv = document.getElementById('questResults');
    const resultsList = document.getElementById('resultsList');
    const steps = document.querySelectorAll('.step-content');
    let currentStepIndex = 0;

    // ── Questionnaire Data ──────────────────────────────────────
    const questions = {
        vitamins: [
            "هل تعاني من تعب مستمر حتى بعد نوم كافي؟",
            "هل لاحظت تساقط شعر غير طبيعي أو ضعف بالشعر؟",
            "هل تعاني من تشنجات أو ضعف في العضلات؟",
            "هل بشرتك شاحبة أو جافة أو أظافرك تتكسر بسهولة؟",
            "هل لديك ضعف في الشهية أو صعوبة في التركيز؟",
            "هل نادراً ما تتناول منتجات الألبان أو اللحوم أو الأغذية مدعمة؟",
            "هل لديك تاريخ مرضي لفقر الدم أو انخفاض فيتامين د؟"
        ],
        thyroid: [
            "هل دورتك الشهرية غير منتظمة؟ (للإناث فقط)",
            "هل زاد أو نقص وزنك مؤخراً بدون سبب واضح؟",
            "هل تشعر بحساسية زائدة للبرد أو للحر؟",
            "هل تحسين بخفقان بالقلب أو تعرّق زائد؟",
            "هل عندچ تساقط شعر أو جفاف واضح بالبشرة؟",
            "هل تشعر غالبًا بالتعب أو النعاس؟",
            "هل سبق أن تم تشخيصك بحالة مرضية في الغدة الدرقية؟"
        ],
        diabetes: [
            { text: "هل تمارس عادةً نشاطًا بدنيًا (30 دقيقة يومياً)؟", points: (v) => v === 'no' ? 2 : 0 },
            { text: "هل تتناول الخضار أو الفواكه يومياً؟", points: (v) => v === 'no' ? 1 : 0 },
            { text: "هل سبق أن تناولت أدوية لعلاج ارتفاع ضغط الدم؟", points: (v) => v === 'yes' ? 2 : 0 },
            { text: "هل سبق أن ظهر لديك ارتفاع في سكر الدم (مثلاً خلال الحمل)؟", points: (v) => v === 'yes' ? 5 : 0 },
            { 
                text: "هل لدى أحد من أقاربك المقربين مرض السكري؟", 
                options: [
                    { label: "لا", value: "no", pts: 0 },
                    { label: "نعم، أقارب الدرجة الثانية (جد، عم)", value: "relative", pts: 3 },
                    { label: "نعم، والدين أو إخوة", value: "immediate", pts: 5 }
                ]
            }
        ],
        hypertension: [
            "هل لديك تاريخ عائلي للإصابة بارتفاع ضغط الدم؟",
            "هل عمرك 40 عامًا أو أكثر؟",
            "هل تشعر غالبًا بصداع أو دوخة أو تشوش في الرؤية؟",
            "هل وزنك أعلى من المعدل الصحي؟",
            "هل تتناول أطعمة عالية الملح في معظم الأيام؟",
            "هل تدخن التبغ أو تستخدم الشيشة بانتظام؟",
            "هل لديك السكري أو ارتفاع في الكولسترول؟",
            "هل تمارس أقل من 150 دقيقة نشاط بدني أسبوعياً؟"
        ]
    };

    // Initialize Question Blocks
    function renderQuestions() {
        // Vitamins
        const vitDiv = document.getElementById('vitamins-questions');
        questions.vitamins.forEach((q, i) => vitDiv.appendChild(createQuestionHTML('vit', i, q)));

        // Thyroid
        const thyDiv = document.getElementById('thyroid-questions');
        questions.thyroid.forEach((q, i) => thyDiv.appendChild(createQuestionHTML('thy', i, q)));

        // Diabetes
        const diaDiv = document.getElementById('diabetes-questions');
        questions.diabetes.forEach((q, i) => {
            if (typeof q === 'string') {
                diaDiv.appendChild(createQuestionHTML('dia', i, q));
            } else {
                diaDiv.appendChild(createCustomQuestionHTML('dia', i, q));
            }
        });

        // Hypertension
        const hypDiv = document.getElementById('hypertension-questions');
        questions.hypertension.forEach((q, i) => hypDiv.appendChild(createQuestionHTML('hyp', i, q)));
    }

    function createQuestionHTML(prefix, index, text) {
        const wrap = document.createElement('div');
        wrap.className = 'question-item';
        wrap.innerHTML = `
            <p class="question-text">${text}</p>
            <div class="options-grid">
                <button type="button" class="option-btn" data-key="${prefix}_${index}" data-value="yes"><span class="radio-check"></span> نعم</button>
                <button type="button" class="option-btn" data-key="${prefix}_${index}" data-value="no"><span class="radio-check"></span> لا</button>
            </div>
            <input type="hidden" name="${prefix}[${index}]" id="${prefix}_${index}">
        `;
        return wrap;
    }

    function createCustomQuestionHTML(prefix, index, q) {
        const wrap = document.createElement('div');
        wrap.className = 'question-item';
        let optionsHTML = '';
        if (q.options) {
            optionsHTML = q.options.map(opt => `
                <button type="button" class="option-btn" data-key="${prefix}_${index}" data-value="${opt.value}" data-pts="${opt.pts}">
                    <span class="radio-check"></span> ${opt.label}
                </button>
            `).join('');
        } else {
             optionsHTML = `
                <button type="button" class="option-btn" data-key="${prefix}_${index}" data-value="yes"><span class="radio-check"></span> نعم</button>
                <button type="button" class="option-btn" data-key="${prefix}_${index}" data-value="no"><span class="radio-check"></span> لا</button>
            `;
        }
        wrap.innerHTML = `
            <p class="question-text">${q.text}</p>
            <div class="options-grid">${optionsHTML}</div>
            <input type="hidden" name="${prefix}[${index}]" id="${prefix}_${index}">
        `;
        return wrap;
    }

    // ── Interaction Logic ──────────────────────────────────────
    document.addEventListener('click', function(e) {
        const btn = e.target.closest('.option-btn');
        if (!btn) return;

        const container = btn.closest('.options-grid');
        const isMulti = btn.classList.contains('multi-select');

        if (!isMulti) {
            container.querySelectorAll('.option-btn').forEach(b => b.classList.remove('selected'));
            btn.classList.add('selected');

            // Set hidden value
            if (btn.dataset.name) {
                // Demographic logic — map data-name to the correct hidden input ID
                const nameMap = {
                    'gender': 'input_gender',
                    'age_group': 'input_age_points',
                    'bmi_group': 'input_bmi_points'
                };
                const inputId = nameMap[btn.dataset.name];
                if (inputId && document.getElementById(inputId)) {
                    // For gender, store the value; for age/bmi, store the points
                    if (btn.dataset.name === 'gender') {
                        document.getElementById(inputId).value = btn.dataset.value;
                    } else {
                        document.getElementById(inputId).value = btn.dataset.points || 0;
                    }
                }
            } else if (btn.dataset.key) {
                document.getElementById(btn.dataset.key).value = btn.dataset.value;
                if (btn.dataset.pts !== undefined) {
                     document.getElementById(btn.dataset.key).setAttribute('data-points', btn.dataset.pts);
                }
            }
        } else {
            // Multi-select for existing conditions
            if (btn.dataset.value === 'none') {
                container.querySelectorAll('.option-btn').forEach(b => b.classList.remove('selected'));
                btn.classList.add('selected');
            } else {
                container.querySelector('[data-value="none"]').classList.remove('selected');
                btn.classList.toggle('selected');
            }
            const selected = Array.from(container.querySelectorAll('.option-btn.selected')).map(b => b.dataset.value);
            document.getElementById('input_existing').value = selected.join(',');
        }
    });

    // ── Navigation Logic ────────────────────────────────────────
    document.querySelectorAll('.btn-next').forEach(btn => {
        btn.addEventListener('click', function() {
            if (validateStep(currentStepIndex)) {
                // Logic to skip sections based on existing conditions
                let nextStep = currentStepIndex + 1;
                const existing = document.getElementById('input_existing').value.split(',');
                const gender = document.getElementById('input_gender').value;

                // Condition check for skip
                if (nextStep === 2 && (existing.includes('thyroid') || gender === 'male')) nextStep++;
                if (nextStep === 3 && existing.includes('diabetes')) nextStep++;
                if (nextStep === 4 && existing.includes('hypertension')) nextStep++;

                if (nextStep >= steps.length) {
                    finishQuestionnaire();
                } else {
                    showStep(nextStep);
                }
            }
        });
    });

    document.querySelector('.btn-finish').addEventListener('click', function() {
         if (validateStep(currentStepIndex)) finishQuestionnaire();
    });

    function showStep(index) {
        steps.forEach(s => s.classList.remove('active'));
        steps[index].classList.add('active');
        currentStepIndex = index;
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    function validateStep(index) {
        const currentStep = steps[index];
        const inputs = currentStep.querySelectorAll('input[type="hidden"]');
        for (let input of inputs) {
            if (!input.value && input.id !== 'input_existing') { // existing is optional
                alert('يرجى الإجابة على جميع الأسئلة للمتابعة');
                return false;
            }
        }
        return true;
    }

    // ── Result Calculation ──────────────────────────────────────
    function finishQuestionnaire() {
        const formData = new FormData(form);
        const results = calculateScores(formData);
        
        form.style.display = 'none';
        resultsDiv.style.display = 'block';
        renderResultCards(results);

        // Submit to DB (AJAX)
        fetch(window.HAYA_SITE_URL + '/handlers/submit-questionnaire.php', {
            method: 'POST',
            body: formData
        });
    }

    function calculateScores(data) {
        const res = {};

        // 1. Vitamins
        let vitScore = 0;
        for (let i = 0; i < 7; i++) if (data.get(`vit[${i}]`) === 'yes') vitScore++;
        res.vit = {
            score: vitScore,
            level: vitScore >= 5 ? 'high' : (vitScore >= 3 ? 'moderate' : 'low'),
            name: "نقص الفيتامينات",
            icon: "💊",
            msg: getMessage('vit', vitScore)
        };

        // 2. Thyroid
        if (data.get('gender') === 'female' && !data.get('existing_conditions').includes('thyroid')) {
            let thyScore = 0;
            for (let i = 0; i < 7; i++) if (data.get(`thy[${i}]`) === 'yes') thyScore++;
            res.thy = {
                score: thyScore,
                level: thyScore >= 6 ? 'high' : (thyScore >= 4 ? 'moderate' : 'low'),
                name: "خطر الغدة الدرقية",
                icon: "🦋",
                msg: getMessage('thy', thyScore)
            };
        }

        // 3. Diabetes
        if (!data.get('existing_conditions').includes('diabetes')) {
            let diaScore = parseInt(data.get('age_points') || 0) + parseInt(data.get('bmi_points') || 0);
            
            // Physical Activity
            if (data.get('dia[0]') === 'no') diaScore += 2;
            // Veggies
            if (data.get('dia[1]') === 'no') diaScore += 1;
            // BP Meds
            if (data.get('dia[2]') === 'yes') diaScore += 2;
            // Blood Sugar History
            if (data.get('dia[3]') === 'yes') diaScore += 5;
            // Immediate family
            const familyBtn = document.querySelector('[data-key="dia_4"].selected');
            if (familyBtn) diaScore += parseInt(familyBtn.dataset.pts || 0);

            res.dia = {
                score: diaScore,
                level: diaScore > 20 ? 'very_high' : (diaScore >= 15 ? 'high' : (diaScore >= 12 ? 'moderate' : (diaScore >= 7 ? 'slightly_elevated' : 'low'))),
                name: "خطر السكري",
                icon: "🩸",
                msg: getMessage('dia', diaScore)
            };
        }

        // 4. Hypertension
        if (!data.get('existing_conditions').includes('hypertension')) {
            let hypScore = 0;
            for (let i = 0; i < 8; i++) if (data.get(`hyp[${i}]`) === 'yes') hypScore++;
            res.hyp = {
                score: hypScore,
                level: hypScore >= 6 ? 'high' : (hypScore >= 3 ? 'moderate' : 'low'),
                name: "ضغط الدم",
                icon: "💓",
                msg: getMessage('hyp', hypScore)
            };
        }

        return res;
    }

    function getMessage(type, score) {
        if (type === 'vit') {
            if (score >= 5) return "خطر مرتفع. تشير هذه النتيجة إلى احتمال قوي لوجود نقص في الفيتامينات. يُوصى بإجراء التحاليل المخبرية واستشارة مختص.";
            if (score >= 3) return "خطر متوسط. قد تدل هذه النتيجة على احتمال وجود نقص في الفيتامينات. يُفضّل التفكير في إجراء التحاليل المناسبة.";
            return "خطر منخفض. تشير هذه النتيجة إلى احتمال أقل لوجود نقص في الفيتامينات. يُنصح بالحفاظ على نظام غذائي متوازن.";
        }
        if (type === 'thy') {
            if (score >= 6) return "خطر مرتفع. قد تعكس هذه النتيجة احتمالًا كبيرًا لوجود مشكلة مرتبطة بالغدة الدرقية. تُنصح المراجعة الطبية المتخصصة.";
            if (score >= 4) return "خطر متوسط. تشير هذه النتيجة إلى احتمال ملحوظ لوجود اضطراب. يُنصح بإجراء تحاليل TSH, T3, T4.";
            return "خطر منخفض. قد تشير هذه النتيجة إلى احتمال بسيط لوجود أعراض مرتبطة بالغدة الدرقية.";
        }
        if (type === 'dia') {
            if (score > 20) return "خطر مرتفع جداً. تعكس هذه الدرجة احتمالاً مرتفعاً جداً للإصابة بالسكري. تقريباً ١ من كل ٢ قد يصاب بالسكري.";
            if (score >= 15) return "خطر مرتفع. تشير هذه النتيجة إلى احتمال واضح للإصابة بالسكري. تقريباً ١ من كل ٣ قد يصاب بالسكري.";
            if (score >= 12) return "خطر متوسط. تعكس هذه الدرجة مستوى متوسطاً من الخطورة. تقريباً ١ من كل ٦ قد يصاب بالسكري.";
            if (score >= 7) return "خطر مرتفع قليلاً. تقريباً ١ من كل ٢٥ قد يصاب بالسكري.";
            return "خطر منخفض. تقريباً ١ من كل ١٠٠ قد يصاب بالسكري.";
        }
        if (type === 'hyp') {
            if (score >= 6) return "خطر مرتفع. تشير هذه النتيجة إلى احتمال كبير لارتفاع ضغط الدم. يُنصح بقياس ضغط الدم فوراً ومراجعة مختص.";
            if (score >= 3) return "خطر متوسط. قد تدل هذه النتيجة على زيادة في احتمال وجود مشكلات. يُوصى بتعديل نمط الحياة وقياس الضغط بانتظام.";
            return "خطر منخفض. تشير هذه النتيجة إلى احتمال منخفض نسبياً. يُنصح بالاستمرار على نمط حياة صحي.";
        }
    }

    function renderResultCards(results) {
        resultsList.innerHTML = '';
        Object.values(results).forEach(r => {
            const card = document.createElement('div');
            card.className = 'result-card';
            card.innerHTML = `
                <div class="result-icon">${r.icon}</div>
                <div class="result-label">${r.name}</div>
                <div class="result-disease-name">الحالة: ${r.level === 'low' ? 'مستقرة' : 'بحاجة انتباه'}</div>
                <div class="risk-badge ${r.level}">${translateLevel(r.level)}</div>
                <div class="result-msg">${r.msg}</div>
            `;
            resultsList.appendChild(card);
        });
    }

    function translateLevel(l) {
        const map = { low: 'خطر منخفض', moderate: 'خطر متوسط', high: 'خطر مرتفع', very_high: 'خطر مرتفع جداً', slightly_elevated: 'مرتفع قليلاً' };
        return map[l] || l;
    }

    renderQuestions();
});
