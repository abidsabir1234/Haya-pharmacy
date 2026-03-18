<?php
// handlers/submit-questionnaire.php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonResponse(false, 'Method not allowed');
}

$db = getDB();

// 1. Parse Metadata
$gender = $_POST['gender'] ?? 'male';
$existing = $_POST['existing_conditions'] ?? '';
$agePoints = (int)($_POST['age_points'] ?? 0);
$bmiPoints = (int)($_POST['bmi_points'] ?? 0);

// 2. Calculate Vitamin Score
$vitScore = 0;
if (isset($_POST['vit'])) {
    foreach ($_POST['vit'] as $val) if ($val === 'yes') $vitScore++;
}
$vitRisk = $vitScore >= 5 ? 'high' : ($vitScore >= 3 ? 'moderate' : 'low');

// 3. Calculate Thyroid (Females only)
$thyScore = null;
$thyRisk = null;
if ($gender === 'female' && !str_contains($existing, 'thyroid')) {
    $thyScore = 0;
    if (isset($_POST['thy'])) {
        foreach ($_POST['thy'] as $val) if ($val === 'yes') $thyScore++;
    }
    $thyRisk = $thyScore >= 6 ? 'high' : ($thyScore >= 4 ? 'moderate' : 'low');
}

// 4. Calculate Diabetes
$diaScore = 0;
$diaRisk = 'low';
if (!str_contains($existing, 'diabetes')) {
    $diaScore = $agePoints + $bmiPoints;
    if (isset($_POST['dia'])) {
        $dia = $_POST['dia'];
        if (($dia[0] ?? '') === 'no') $diaScore += 2;
        if (($dia[1] ?? '') === 'no') $diaScore += 1;
        if (($dia[2] ?? '') === 'yes') $diaScore += 2;
        if (($dia[3] ?? '') === 'yes') $diaScore += 5;
        
        // Relative logic (We don't have the points sent directly in simple POST, 
        // but we can infer from the value if we used pts in the JS data-value.
        // In the JS I actually just used 'no', 'relative', 'immediate'.
        if (($dia[4] ?? '') === 'relative') $diaScore += 3;
        if (($dia[4] ?? '') === 'immediate') $diaScore += 5;
    }
    
    if ($diaScore > 20) $diaRisk = 'very_high';
    else if ($diaScore >= 15) $diaRisk = 'high';
    else if ($diaScore >= 12) $diaRisk = 'moderate';
    else if ($diaScore >= 7) $diaRisk = 'slightly_elevated';
    else $diaRisk = 'low';
}

// 5. Calculate Hypertension
$hypScore = 0;
$hypRisk = 'low';
if (!str_contains($existing, 'hypertension')) {
    if (isset($_POST['hyp'])) {
        foreach ($_POST['hyp'] as $val) if ($val === 'yes') $hypScore++;
    }
    $hypRisk = $hypScore >= 6 ? 'high' : ($hypScore >= 3 ? 'moderate' : 'low');
}

try {
    $stmt = $db->prepare("
        INSERT INTO questionnaire_submissions (
            gender, age, bmi, pre_existing_conditions,
            vitamin_score, vitamin_risk_level,
            thyroid_score, thyroid_risk_level,
            diabetes_score, diabetes_risk_level,
            hypertension_score, hypertension_risk_level,
            answers_json
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");

    $stmt->execute([
        $gender,
        0, // Age in years not captured directly, using groups for scoring
        0, // BMI val not captured directly, using groups for scoring
        json_encode(explode(',', $existing)),
        $vitScore, $vitRisk,
        $thyScore, $thyRisk,
        $diaScore, $diaRisk,
        $hypScore, $hypRisk,
        json_encode($_POST)
    ]);

    jsonResponse(true, 'Data saved successfully');

} catch (PDOException $e) {
    error_log("Questionnaire Error: " . $e->getMessage());
    jsonResponse(false, 'Database error');
}
