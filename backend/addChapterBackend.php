<?php
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

include('../db/db_conn.php');

$user_id = $_SESSION['id'];
$course_id = $_SESSION['course_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $chapter_number = $_POST['chapter_number'];
    $chapter_title = $_POST['chapter_title'];
    $main_lessons = $_POST['main_lessons'];
    $lessons = [];
    $llos = [];
    
    for ($i = 1; $i <= $main_lessons; $i++) {
        $lessons[] = [
            'number' => $i,
            'title' => $_POST['lesson_title_' . $i],
            'firstSlide' => $_POST['slides_from_' . $i],
            'lastSlide' => $_POST['slides_to_' . $i]
        ];
        $llos[] = [
            'lesson_number' => $i,
            'llos_content' => $_POST['llo_' . $i]
        ];
    }

    // Handle file upload
    $file = $_FILES['upload_chapter'];
    $upload_dir = '../uploads/';
    $file_path = $upload_dir . basename($file['name']);
    move_uploaded_file($file['tmp_name'], $file_path);

    // Insert chapter into the database
    $stmt = $conn->prepare("INSERT INTO chapter (number, title, course_id, teacher_id, file) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("issis", $chapter_number, $chapter_title, $course_id, $user_id, $file_path);
    $stmt->execute();
    $stmt->close();

    // Insert lessons into the database
    foreach ($lessons as $lesson) {
        $stmt = $conn->prepare("INSERT INTO lessons (chapter_number, course_id, teacher_id, number, title, firstSlide, lastSlide) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("isiisii", $chapter_number, $course_id, $user_id, $lesson['number'], $lesson['title'], $lesson['firstSlide'], $lesson['lastSlide']);
        $stmt->execute();
        $stmt->close();
    }

    // Insert LLOs into the database
    foreach ($llos as $llo) {
        $stmt = $conn->prepare("INSERT INTO llos (course_id, chapter_number, lesson_number, teacher_id, llos_content) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("siiis", $course_id, $chapter_number, $llo['lesson_number'], $user_id, $llo['llos_content']);
        $stmt->execute();
        $stmt->close();
    }

   // Redirect to summarization.php
   header("Location: summarization.php?chapter_number=$chapter_number&course_id=$course_id&teacher_id=$user_id");
   exit();
}
?>