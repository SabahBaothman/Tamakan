<?php
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

// Function to check if the lesson is explained or not
function isLessonExplained($conn, $student_id, $course_id, $chapter_number, $lesson_number){
    $done=0;
    $total_score = 0;
    $sql3 = "SELECT done, total_score FROM explanation WHERE student_id = ? AND course_id = ? AND chapter_number = ? AND lesson_number = ?";
    $stmt3 = $conn -> prepare($sql3);
    $stmt3 -> bind_param("iiii", $student_id, $course_id, $chapter_number, $lesson_number);
    $stmt3 -> execute();
    // Bind result to both 'done' and 'total_score'
    $stmt3->bind_result($done, $total_score);
    $stmt3->fetch();
    $stmt3->close();
    // Return both 'done' and 'total_score'
    return array('done' => $done, 'total_score' => $total_score);
}

// Fetch all students IDs for a specific course under a specific teacher
$sql1 = "SELECT student_id FROM enrollment WHERE teacher_id = ? AND course_id = ?";
$stmt1 = $conn -> prepare($sql1);
$stmt1 -> bind_param("ii", $user_id, $course_id);
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
        while($row = $temp -> fetch_assoc()) {
            $studInfo[] = [
                'id' => $row['id'],
                'name' => $row['name']
            ]; // Store IDs and names in an array of associative arrays
        }
        $stmt2 -> close();
    }
}

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
            <?php foreach($studInfo as $stud) { 
                $explanation = isLessonExplained($conn, $stud['id'], $course_id, $chapter_number, $lesson_number);
            ?>
            <div class="lessonCard">
                <div class="leftContent">
                    <div class="<?php echo ($explanation['done']==1) ? 'checked' : 'uncheck'; ?>">
                        <?php if($explanation['done']==1){ ?>
                        <div class="checkmark"></div>
                        <?php } ?>
                    </div>
                    <div class="<?php echo ($explanation['done']==1 ? 'studScoreCheck' : ''); ?>">
                        <p><?php echo $stud['name'] ?></p>
                        <?php if($explanation['done']==1){ ?>
                        <span>have completed the explanation</span>
                        <?php } ?>
                    </div>
                </div>

                <?php if($explanation['done']==1){ ?>
                <div class="rigthContent">
                    <div id="totalScore" style="font-size: 10px; background-color: white;">
                        <p><span><?php echo htmlspecialchars($explanation['total_score'])?></span>/100</p>
                    </div>
                </div>
                <?php } ?>
            </div> 
            <?php } ?>

        </div>

    </div>
</body>

</html>

<?php
$conn->close();
?>