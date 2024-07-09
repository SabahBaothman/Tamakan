<?php
// nav.php and lessons.php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

include('../db/db_conn.php');

$user_id = $_SESSION['id'];
$course_id = $_SESSION['course_id'];
$user_type = $_SESSION['user_type'];

// Fetch course name
$sql_course = "SELECT name FROM course WHERE id = ?";
$stmt_course = $conn->prepare($sql_course);
$stmt_course->bind_param("s", $course_id);
$stmt_course->execute();
$result_course = $stmt_course->get_result();
$course = $result_course->fetch_assoc();
$stmt_course->close();

// Fetch chapters based on user type
if ($user_type == 't') {
    $sql_chapters = "SELECT number, title, file FROM chapter WHERE course_id = ? AND teacher_id = ?";
    $stmt_chapters = $conn->prepare($sql_chapters);
    $stmt_chapters->bind_param("si", $course_id, $user_id);
} else {
    $sql_chapters = "SELECT ch.number, ch.title, ch.file 
                     FROM chapter ch
                     JOIN enrollment en ON ch.course_id = en.course_id
                     WHERE ch.course_id = ? AND en.student_id = ? AND ch.teacher_id = en.teacher_id";
    $stmt_chapters = $conn->prepare($sql_chapters);
    $stmt_chapters->bind_param("si", $course_id, $user_id);
}

$stmt_chapters->execute();
$result_chapters = $stmt_chapters->get_result();
$chapters = $result_chapters->fetch_all(MYSQLI_ASSOC);

$stmt_chapters->close();
$conn->close();
?>
