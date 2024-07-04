<?php
session_start();

if (isset($_POST['course_id'])) {
    $_SESSION['course_id'] = $_POST['course_id'];
    header("Location: addChapter.php");
    exit();
} else {
    header("Location: chapters.php");
    exit();
}
?>
