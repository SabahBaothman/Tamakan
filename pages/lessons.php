<?php
header('Cache-Control: no cache'); //no cache
session_cache_limiter('private_no_expire'); // works
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
$user_type = $_SESSION['user_type'];
$chapter_title = $_POST['chapter_title'];
$course_id = $_POST['course_id'];
$chapter_number = $_POST['chapter_number'];

// Prepare SQL Queries
if ($user_type=='t') {  // User: Teacher
    $sql = "SELECT * FROM lessons WHERE teacher_id = ? AND course_id = ? AND chapter_number = ?";
    $stmt = $conn -> prepare($sql);
    $stmt -> bind_param("isi", $user_id, $course_id, $chapter_number);
    $stmt -> bind_param("isi", $user_id, $course_id, $chapter_number);
    $stmt -> execute();
    $lessons = $stmt -> get_result();

} else { // User: Student

    // Fetch teacher_id from enrollment table
    $sql1 = "SELECT teacher_id FROM enrollment WHERE student_id = ? AND course_id = ?";
    $stmt1 = $conn -> prepare($sql1);
    $stmt1 -> bind_param("is", $user_id, $course_id);
    $stmt1 -> bind_param("is", $user_id, $course_id);
    $stmt1 -> execute();
    $stmt1 -> bind_result($teacher_id);
    $stmt1 -> fetch();
    $stmt1 -> close();

    // Fetch Lessons
    $sql2 = "SELECT * FROM lessons WHERE teacher_id = ? AND course_id = ? AND chapter_number = ?";
    $stmt2 = $conn -> prepare($sql2);
    $stmt2 -> bind_param("isi", $teacher_id, $course_id, $chapter_number);
    $stmt2 -> bind_param("isi", $teacher_id, $course_id, $chapter_number);
    $stmt2 -> execute();
    $lessons = $stmt2 -> get_result();
    $stmt2 -> close();

    // Fetch all explanation entries
    $sql3 = "SELECT * FROM explanation WHERE student_id = ? AND course_id = ? AND chapter_number = ?";
    $stmt3 = $conn -> prepare($sql3);
    $stmt3 -> bind_param("isi", $user_id, $course_id, $chapter_number);
    $stmt3 -> execute();
    $exps = $stmt3 -> get_result();
    $stmt3 -> close();

    // Store results in an associative array
    $lessons_done = [];
    while ($row = $exps->fetch_assoc()) {
        $lessons_done[$row['lesson_number']] = $row['done'];
    }
}

// $data = [];
// while ($row = $exps->fetch_assoc()) {
//     $data[] = $row;
// }
// echo "<pre>";
// print_r($data);
// echo "</pre>";

// ?>

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
            while ($lesson = $lessons -> fetch_assoc()){
                if($user_type=='s'){
                    if (isset($lessons_done[$lesson['number']])) { // Retrieve the 'done' status for the current lesson number
                        $done = $lessons_done[$lesson['number']];
                    } else {
                        $done = 0; 
                    }
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

                    <?php if($user_type=='s'){ ?>
                        <?php $buttonTitle = $done == 1 ? 'Re-Explain' : 'Explain'; ?>
                        <form action="explian.php" method="POST" style="display: contents">
                            <input type="hidden" name="course_id" value="<?php echo htmlspecialchars($course_id) ?>">
                            <input type="hidden" name="chapter_number" value="<?php echo htmlspecialchars($chapter_number) ?>">
                            <input type="hidden" name="lesson_number" value="<?php echo htmlspecialchars($lesson['number']) ?>">
                            <input type="hidden" name="teacher_id" value="<?php echo htmlspecialchars($lesson['teacher_id']) ?>">
                            <button type="button" class="button" onclick="this.closest('form').submit(); return false;"><?= $buttonTitle ?></button>
                        </form>
                    <?php } else { ?>
                        <?php $buttonTitle = 'Scores'; ?>
                        <form action="studScores.php" method="POST" style="display: contents">
                            <input type="hidden" name="course_id" value="<?php echo htmlspecialchars($course_id) ?>">
                            <input type="hidden" name="chapter_number" value="<?php echo htmlspecialchars($chapter_number) ?>">
                            <input type="hidden" name="lesson_title" value="<?php echo htmlspecialchars($lesson['title']) ?>">
                            <input type="hidden" name="lesson_number" value="<?php echo htmlspecialchars($lesson['number']) ?>">
                            <button type="button" class="button" onclick="this.closest('form').submit(); return false;"><?= $buttonTitle ?></button>
                        </form>
                    <?php } ?>
                </div>
            </div>
            <?php } ?>

        </div>
        
    </div>
</body>
</html>
