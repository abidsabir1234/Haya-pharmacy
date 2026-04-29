<?php
session_start();
$_SESSION['survey_responses'] = [];
header("Location: welcome.php");
exit();
?>
