<?php
session_start();

if (isset($_POST['course_id'])) {
    $_SESSION['course_id'] = $_POST['course_id'];
    header("Location: chapters.php");
    exit();
} else {
    header("Location: courses.php");
    exit();
}
?>
