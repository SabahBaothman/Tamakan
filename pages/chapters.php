<?php 
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

include('../db/db_conn.php');

$user_id = $_SESSION['id'];
$course_id = $_SESSION['course_id'];

// Fetch course name
$sql_course = "SELECT name FROM course WHERE id = ?";
$stmt_course = $conn->prepare($sql_course);
$stmt_course->bind_param("i", $course_id);
$stmt_course->execute();
$result_course = $stmt_course->get_result();
$course = $result_course->fetch_assoc();

// Fetch chapters
$sql_chapters = "SELECT number, title, file FROM chapter WHERE course_id = ?";
$stmt_chapters = $conn->prepare($sql_chapters);
$stmt_chapters->bind_param("i", $course_id);
$stmt_chapters->execute();
$result_chapters = $stmt_chapters->get_result();
$chapters = $result_chapters->fetch_all(MYSQLI_ASSOC);

$stmt_course->close();
$stmt_chapters->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../../style.css">
    <title>Chapters</title>
</head>

<?php
include('./nav.php');
?>

<body>
    <div class="paddContainer">

        <!-- HEADER -->
        <div class="header">
            <h2 class="pageTitle">Chapters</h2>
            <div class="pageSubtitle">
                <p><span><?php echo htmlspecialchars($course['name']); ?> / <?php echo htmlspecialchars($course_id); ?></span></p>
                <?php   if($_SESSION['user_type'] == 't'):?>
                    <form action="../backend/goToAddChapter.php" method="post" class="chaptersBtn">
                        <input type="hidden" name="course_id" value="<?php echo htmlspecialchars($course_id); ?>">
                        <button type="submit" class="button">Add Chapter</button>
                    </form>
                <?php endif; ?>
            </div>
        </div>

        <!-- CHAPTERS -->
        <?php if (count($chapters) > 0): ?>
        <div id="chapters">
                <?php foreach ($chapters as $chapter): ?>
                    <a href="<?php echo htmlspecialchars($chapter['file']); ?>" class="chapterCard" target="_blank">
                        <h1>CH<?php echo htmlspecialchars($chapter['number']); ?></h1>
                        <div>
                            <p><?php echo htmlspecialchars($chapter['title']); ?></p>
                        </div>
                    </a>
                <?php endforeach; ?>
        </div>
        <?php else: ?>
                <div class="no-content">
                    <img src="../images/noContent.png" alt="No Content" width="400">
                    <h2>No Content Found</h2>
                </div>
            <?php endif; ?>

    </div>
</body>

</html>
