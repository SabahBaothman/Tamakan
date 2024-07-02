<?php
session_start();

// if (!isset($_SESSION['user_id'])) {
//     header("Location: login.php");
//     exit();
// }

include('../db/db_conn.php');

$user_id = $_SESSION['id'];
$sql = "SELECT id, name FROM course WHERE teacher_id = '2010332'";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$courses = $result->fetch_all(MYSQLI_ASSOC);

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Subjects</title>
    <link rel="stylesheet" href="../style.css">
</head>
<?php include('nav.php'); ?>
<body>
    <div class="subjects-container">
        <h4>Your Subjects</h4>
        <div class="hr-container">
            <hr id="subjects-line">
        </div>

        <?php if (count($courses) > 0): ?>
            <div class="slideshow-container">
                <div class="slides">
                    <?php
                    $slideIndex = 0;
                    foreach ($courses as $index => $course) {
                        if ($index % 3 == 0) {
                            if ($index > 0) ?> </div>
                             <div class="slide">
                             <?php $slideIndex++;
                        } ?>
                            <div class="subject-card">
                                <h4> <?php echo htmlspecialchars($course['name']); ?> </h4>
                                <p> <?php echo htmlspecialchars($course['id']); ?> </p>
                                <button>Go to Course</button>
                            </div>
                <?php } ?>
                        </div>
                    
                </div>

                <a class="prev" onclick="changeSlide(-1)">&#10094;</a>
                <a class="next" onclick="changeSlide(1)">&#10095;</a>
            </div>

            <div class="dots">
                <?php for ($i = 1; $i <= $slideIndex; $i++): ?>
                    <span class="dot" onclick="currentSlide(<?php echo $i; ?>)"></span>
                <?php endfor; ?>
            </div>
        <?php else: ?>
            <div class="no-content">
                <img src="../images/noContent.png" alt="No Content">
                <p>No Subjects Found</p>
            </div>
        <?php endif; ?>
    </div>

    <script>
        let slideIndex = 1;
        showSlides(slideIndex);

        function changeSlide(n) {
            showSlides(slideIndex += n);
        }

        function currentSlide(n) {
            showSlides(slideIndex = n);
        }

        function showSlides(n) {
            let slides = document.getElementsByClassName("slide");
            let dots = document.getElementsByClassName("dot");

            if (n > slides.length) slideIndex = 1;
            if (n < 1) slideIndex = slides.length;

            for (let i = 0; i < slides.length; i++) {
                slides[i].style.display = "none";
            }
            for (let i = 0; i < dots.length; i++) {
                dots[i].className = dots[i].className.replace(" active", "");
            }

            if (slides.length > 0) {
                slides[slideIndex - 1].style.display = "flex";
                dots[slideIndex - 1].className += " active";
            }
        }
    </script>
</body>
</html>
