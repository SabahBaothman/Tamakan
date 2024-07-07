<?php
require 'vendor/autoload.php'; // Make sure you have the autoload for PDF parsing libraries
include('../db/db_conn.php');

$pdf_file = ''; // Initialize an empty variable

if (isset($_POST['teacher_id'], $_POST['course_id'], $_POST['chapter_number'], $_POST['lesson_number'])) {
    $teacher_id = $_POST['teacher_id'];
    $course_id = $_POST['course_id'];
    $chapter_number = $_POST['chapter_number'];
    $lesson_number = $_POST['lesson_number'];

    // First query to fetch the PDF path from the chapters table
    $query1 = "SELECT pdf FROM chapter WHERE teacher_id = ? AND course_id = ? AND number = ?";
    $stmt1 = mysqli_prepare($conn, $query1);
    mysqli_stmt_bind_param($stmt1, "iii", $teacher_id, $course_id, $chapter_number);
    mysqli_stmt_execute($stmt1);
    $result1 = mysqli_stmt_get_result($stmt1);

    if ($row1 = mysqli_fetch_assoc($result1)) {
        $pdf_file = $row1['pdf'];
    } else {
        die("Chapter not found.");
    }
}
?>

