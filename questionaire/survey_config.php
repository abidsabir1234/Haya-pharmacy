<?php
// questionaire/survey_config.php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Defining the exact sequence of 35 questionnaire steps as requested.
 * 
 * Order:
 * - General Info (1-6)
 * - Thyroid Screening (7-13)
 * - Diabetes Risk (14-19)
 * - Blood Pressure (20-27)
 * - Vitamins Deficiency (28-34)
 * - Result (35)
 */
define('SURVEY_STEPS', [
    'welcome.php',
    'age.php',
    'gender.php',
    'marriage-status.php',
    'chronic-diseases.php',
    'diagnosed.php',
    'index.php',
    'heart-sweat.php',
    'fatigue.php',
    'temp-sensitivity.php',
    'skin-hair.php',
    'weight-change.php',
    'period-regularity.php',
    'age-diabetes.php',
    'diabetes-family.php',
    'physical-activity.php',
    'fruits-veg.php',
    'high-blood-sugar.php',
    'blood-pressure-history.php',
    'age-40plus.php',
    'symptoms-check.php',
    'activity-150min.php',
    'bmi-check-bp.php',
    'high-salt-foods.php',
    'smoking-shisha.php',
    'diabetes-cholesterol.php',
    'vitamin-deficiency.php',
    'vitamin-diet.php',
    'blood-pressure-meds.php',
    'vitamin-fatigue.php',
    'vitamin-hair.php',
    'vitamin-muscle.php',
    'vitamin-skin-nails.php',
    'vitamin-appetite.php',
    'results.php'
]);

/**
 * Grouping pages for conditional skipping
 */
define('THYROID_PAGES', [
    'index.php', 'heart-sweat.php', 'fatigue.php', 'temp-sensitivity.php', 
    'skin-hair.php', 'weight-change.php', 'period-regularity.php'
]);

define('DIABETES_PAGES', [
    'age-diabetes.php', 'diabetes-family.php', 'physical-activity.php', 
    'fruits-veg.php', 'high-blood-sugar.php', 'blood-pressure-history.php',
    'age-40plus.php', 'symptoms-check.php', 'activity-150min.php', 
    'bmi-check-bp.php', 'high-salt-foods.php', 'smoking-shisha.php', 
    'diabetes-cholesterol.php'
]);

define('BP_PAGES', [
    'vitamin-deficiency.php', 'vitamin-diet.php', 'blood-pressure-meds.php', 
    'vitamin-fatigue.php', 'vitamin-hair.php', 'vitamin-muscle.php', 
    'vitamin-skin-nails.php', 'vitamin-appetite.php'
]);

define('FEMALE_ONLY_PAGES', [
    'period-regularity.php'
]);

/**
 * Helper to get current file position in the sequence.
 */
function getCurrentStepIndex() {
    $currentFile = basename($_SERVER['PHP_SELF']);
    $index = array_search($currentFile, SURVEY_STEPS);
    return ($index !== false) ? $index : 0;
}

/**
 * Check if a page should be skipped based on user responses.
 */
function shouldSkipPage($filename) {
    $responses = $_SESSION['survey_responses'] ?? [];
    $gender = $responses['gender.php'] ?? '';
    $chronic = $responses['chronic-diseases.php'] ?? '';
    $chronicArr = explode(',', $chronic);

    // Skip female-only pages if male
    if (in_array($filename, FEMALE_ONLY_PAGES) && $gender === 'male') {
        return true;
    }

    // Skip Thyroid screening if already has thyroid disease
    if (in_array($filename, THYROID_PAGES) && in_array('thyroid', $chronicArr)) {
        return true;
    }

    // Skip Diabetes screening if already has diabetes
    if (in_array($filename, DIABETES_PAGES) && in_array('diabetes', $chronicArr)) {
        return true;
    }

    // Skip BP screening if already has hypertension (pressure)
    if (in_array($filename, BP_PAGES) && in_array('pressure', $chronicArr)) {
        return true;
    }

    return false;
}

/**
 * Get Next & Prev URLs dynamically.
 */
function getNextStepUrl() {
    $index = getCurrentStepIndex();
    for ($i = $index + 1; $i < count(SURVEY_STEPS); $i++) {
        $nextFile = SURVEY_STEPS[$i];
        if (!shouldSkipPage($nextFile)) {
            return $nextFile;
        }
    }
    return 'results.php';
}

function getPrevStepUrl() {
    $index = getCurrentStepIndex();
    for ($i = $index - 1; $i >= 0; $i--) {
        $prevFile = SURVEY_STEPS[$i];
        if (!shouldSkipPage($prevFile)) {
            return $prevFile;
        }
    }
    return '../index.php'; // Back to home if first step
}

/**
 * Dynamic Progress Bar Logic.
 * Lights up 'ON' segments based on the current step position.
 */
function getProgressBarsHtml() {
    $totalBars = 10; // Default segments to display
    $index = getCurrentStepIndex();
    $totalSteps = count(SURVEY_STEPS);
    
    // Percentage-based fill
    $numOn = ceil((($index + 1) / $totalSteps) * $totalBars);
    
    $html = '<div class="bars">';
    for ($i = 0; $i < $totalBars; $i++) {
        $class = ($i < $numOn) ? 'on' : 'off';
        $html .= '<div class="bar ' . $class . '"></div>';
    }
    $html .= '</div>';
    
    return $html;
}

/**
 * Saves current page answer and redirects to the next page.
 */
$currentPage = basename($_SERVER['PHP_SELF']);

// Requirement 1 & 4: Clear cache if on welcome.php or if specifically requested
if ($currentPage === 'welcome.php') {
    $_SESSION['survey_responses'] = [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['survey_answer'])) {
    $_SESSION['survey_responses'][$currentPage] = $_POST['survey_answer'];
    
    $nextUrl = getNextStepUrl();
    header("Location: " . $nextUrl);
    exit();
}
?>
