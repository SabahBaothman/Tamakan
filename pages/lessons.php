<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}
include('../db/db_conn.php');

$user_id = $_SESSION['id'];
$user_type = $_SESSION['user_type'];
$chapter_title = $_POST['chapter_title'];
$course_id = $_POST['course_id'];
$chapter_number = $_POST['chapter_number'];

// Function to check if the lesson is explained or not
function isLessonExplained($conn, $student_id, $course_id, $chapter_number, $lesson_number){
    $done=0;
    $sql3 = "SELECT done FROM explanation WHERE student_id = ? AND course_id = ? AND chapter_number = ? AND lesson_number = ?";
    $stmt3 = $conn -> prepare($sql3);
    $stmt3 -> bind_param("isii", $student_id, $course_id, $chapter_number, $lesson_number);
    $stmt3 -> execute();
    $stmt3 -> bind_result($done);
    $stmt3 -> fetch();
    $stmt3 -> close();
    return $done;
}

// Prepare SQL Queries
if ($user_type=='t') {  // User: Teacher
    $sql = "SELECT * FROM lessons WHERE teacher_id = ? AND course_id = ? AND chapter_number = ?";
    $stmt = $conn -> prepare($sql);
    $stmt -> bind_param("isi", $user_id, $course_id, $chapter_number);
    $stmt -> execute();
    $lessons = $stmt -> get_result();

} else { // User: Student

    // Fetch teacher_id from enrollment table
    $sql1 = "SELECT teacher_id FROM enrollment WHERE student_id = ? AND course_id = ?";
    $stmt1 = $conn -> prepare($sql1);
    $stmt1 -> bind_param("is", $user_id, $course_id);
    $stmt1 -> execute();
    $stmt1 -> bind_result($teacher_id);
    $stmt1 -> fetch();
    $stmt1 -> close();

    // Fetch Lessons
    $sql2 = "SELECT * FROM lessons WHERE teacher_id = ? AND course_id = ? AND chapter_number = ?";
    $stmt2 = $conn -> prepare($sql2);
    $stmt2 -> bind_param("isi", $teacher_id, $course_id, $chapter_number);
    $stmt2 -> execute();
    $lessons = $stmt2 -> get_result();
    $stmt2 -> close();
}

// $data = [];
// while ($row = $lessons->fetch_assoc()) {
//     $data[] = $row;
// }
// echo "<pre>";
// print_r($data);
// echo "</pre>";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../../style.css">
    <title>Lessons</title>
</head>

<?php
include('./nav.php');
?>

<body>
    <div class="paddContainer">

        <!-- HEADER -->
        <div class="header">
            <h2 class="pageTitle">Lessons</h2>
            <div class="pageSubtitle">
                <p><span><?php echo htmlspecialchars($course_id) ?> / CH<?php echo htmlspecialchars($chapter_number) ?> 
                - <?php echo htmlspecialchars($chapter_title) ?></span></p>
            </div>
        </div>

        <!-- LESSONS -->
        <div>
            <?php
            $xxx = 1;
            while ($lesson = $lessons -> fetch_assoc()){
                if($user_type=='s'){
                    $done = isLessonExplained($conn, $user_id, $course_id, $chapter_number, $lesson['number']);
                }
            ?>
            <div class="lessonCard">
                <div class="leftContent">
                    <?php if($user_type=='s') { ?>
                    <div class="<?php echo ($done==1) ? 'checked' : 'uncheck'; ?>">
                        <?php if($done==1){ ?>
                        <div class="checkmark"></div>
                        <?php } ?>
                    </div>
                    <?php } ?>
                    <p><?php echo htmlspecialchars($lesson['title']); ?></p>
                </div>

                <div class="rigthContent">
                    <?php
                    if($user_type=='s' && $done==1){
                    ?>
                    <button id="scoreBtn" type="button" class="button">View Score</button>
                    <?php
                    }
                    ?>
                    <?php $buttonTitle = $user_type=='t'? 'View' : ($done==1? 'Re-Explain' : 'Explain') ?>
                    <form action="explian.php" method="POST" style="display: contents">
                        <input type="hidden" name="course_id" value="<?php echo htmlspecialchars($course_id) ?>">
                        <input type="hidden" name="chapter_number" value="<?php echo htmlspecialchars($chapter_number) ?>">
                        <input type="hidden" name="lesson_number" value="<?php echo htmlspecialchars($lesson['number']) ?>">
                        <input type="hidden" name="teacher_id" value="<?php echo htmlspecialchars($lesson['teacher_id']) ?>">
                        <button type="button" class="button" onclick="this.closest('form').submit(); return false;"><?= $buttonTitle ?></button>
                    </form>
                </div>
            </div>
            <?php } ?>

        </div>
        
    </div>
</body>
</html>

<!-- <?php
$conn->close();
?> -->