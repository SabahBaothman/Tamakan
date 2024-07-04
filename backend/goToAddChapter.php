<?php
session_start();

if (isset($_POST['course_id'])) {
    $_SESSION['course_id'] = $_POST['course_id'];
    header("Location: ../pages/addChapter.php");
    exit();
} else {
    header("Location:  ../pages/chapters.php");
    exit();
}
?>
