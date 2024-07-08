<?php
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

// Redirect to loading page
header("Location: loading.html?teacher_id={$_GET['teacher_id']}&course_id={$_GET['course_id']}&chapter_number={$_GET['chapter_number']}");
exit();
?>
