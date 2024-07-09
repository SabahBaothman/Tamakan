<?php
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

if (isset($_POST['teacher_id'], $_POST['course_id'], $_POST['lesson_number'], $_POST['chapter_number'], $_POST['transcribed_text'])) {
    $teacher_id = $_POST['teacher_id'];
    $course_id = $_POST['course_id'];
    $lesson_number = $_POST['lesson_number'];
    $chapter_number = $_POST['chapter_number'];
    $transcribed_text = $_POST['transcribed_text'];

    // Redirect to loading page with POST data as URL parameters
    header("Location: loadingPer.html?teacher_id=$teacher_id&course_id=$course_id&lesson_number=$lesson_number&chapter_number=$chapter_number&transcribed_text=" . urlencode($transcribed_text));
    exit();
} else {
    die("Invalid request. Missing parameters.");
}
?>
