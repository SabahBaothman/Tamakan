<?php
// nav.php and lessons.php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


include('../db/db_conn.php');

$user_id = $_SESSION['id'];

if ($_SESSION['user_type'] == 't') {
    // If the user is a teacher
    $sql = "SELECT id, name FROM course WHERE teacher_id = ?";
} else {
    // If the user is a student
    $sql = "SELECT DISTINCT course.id, course.name 
            FROM course 
            JOIN enrollment ON course.id = enrollment.course_id 
            WHERE enrollment.student_id = ? AND course.teacher_id = enrollment.teacher_id";
}

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$courses = $result->fetch_all(MYSQLI_ASSOC);

$stmt->close();
$conn->close();
?>
