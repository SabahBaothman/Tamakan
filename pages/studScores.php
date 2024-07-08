<?php

header('Cache-Control: no cache'); //no cache
session_cache_limiter('private_no_expire'); // works

session_start();
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}
include('../db/db_conn.php');

$user_id = $_SESSION['id'];
$user_type = $_SESSION['user_type'];
$course_id = $_POST['course_id'];
$chapter_number = $_POST['chapter_number'];
$lesson_title = $_POST['lesson_title'];
$lesson_number = $_POST['lesson_number'];

// Fetch all students IDs for a specific course under a specific teacher
$sql1 = "SELECT student_id FROM enrollment WHERE teacher_id = ? AND course_id = ?";
$stmt1 = $conn -> prepare($sql1);
$stmt1 -> bind_param("is", $user_id, $course_id);
$stmt1 -> execute();
$result = $stmt1->get_result();
$studentIDs = [];
while($row = $result->fetch_assoc()) {
    $studentIDs[] = $row['student_id']; // Store student IDs in an array
}
$stmt1 -> close();

// Fetch students information using their IDs
$studInfo = [];
if(count($studentIDs) > 0) {
    foreach($studentIDs as $student) {
        $sql2 = "SELECT id, name FROM users WHERE id = ?";
        $stmt2 = $conn -> prepare($sql2);
        $stmt2 -> bind_param("i", $student);
        $stmt2 -> execute();
        $temp = $stmt2 -> get_result();
        while ($row = $temp->fetch_assoc()) {
            // Fetch explanation data (done and total score) for each student
            $sql3 = "SELECT done, total_score FROM explanation WHERE student_id = ? AND course_id = ? AND chapter_number = ? AND lesson_number = ?";
            $stmt3 = $conn->prepare($sql3);
            $stmt3->bind_param("isii", $student, $course_id, $chapter_number, $lesson_number);
            $stmt3->execute();
            $explanation = $stmt3->get_result()->fetch_assoc();
            $stmt3->close();

            $studInfo[] = [
                'id' => $row['id'],
                'name' => $row['name'],
                'done' => $explanation? $explanation['done'] : 0,
                'total_score' => $explanation? $explanation['total_score'] : 0
            ];
        }
        $stmt2 -> close();
    }
}

// Sort $studInfo array to display students with done=1 first
usort($studInfo, function($a, $b) {
    return $b['done'] - $a['done'];
});

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
            <h2 class="pageTitle">Scores</h2>
            <div class="pageSubtitle">
                <p><span><?php echo htmlspecialchars($course_id)?> / CH<?php echo htmlspecialchars($chapter_number)?> - <?php echo htmlspecialchars($lesson_title) ?> </span></p>
            </div>
        </div>

        <!-- STUDENTS' SCORES -->
        <div>
            <?php if(count($studInfo) > 0):
                foreach($studInfo as $stud) :?>
            <div class="lessonCard">
                <div class="leftContent">
                    <div class="<?php echo ($stud['done']==1) ? 'checked' : 'uncheck'; ?>">
                        <?php if($stud['done']==1){ ?>
                        <div class="checkmark"></div>
                        <?php } ?>
                    </div>
                    <div class="<?php echo ($stud['done']==1 ? 'studScoreCheck' : ''); ?>">
                        <p><?php echo $stud['id'] ?> | <?php echo $stud['name'] ?></p>
                        <?php if($stud['done']==1){ ?>
                        <span>have completed the explanation</span>
                        <?php } ?>
                    </div>
                </div>

                <?php if($stud['done']==1){ ?>
                <div class="rigthContent">
                    <div id="totalScore" style="font-size: 10px; background-color: white;">
                        <p><span><?php echo htmlspecialchars($stud['total_score'])?></span>/100</p>
                    </div>
                </div>
                <?php } ?>
            </div> 
                <?php endforeach; ?>
            <?php else: ?>
            <div class="no-content">
                <img src="../images/noContent.png" alt="No Content" width="400">
                <h2>No Content Found</h2>
            </div>
            <?php endif; ?>

        </div>

    </div>
</body>

</html>
