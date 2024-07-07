
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Subjects</title>
    <link rel="stylesheet" href="../style.css">
    <script src="../javascript/courses.js" defer></script>
</head>

<?php include('../backend/fetchCourses.php'); ?>
<?php include('nav.php'); ?>
<body>
    <!-- Main Container -->
    <div class="paddContainer">
        <!-- Header -->
        <div class="header">
            <div class="headContent">
                <h2 class="pageTitle">Your Subjects</h2>
                <div></div>
            </div>
        </div>

        <?php if (count($courses) > 0): ?>
            <div class="slideshow-container">
                <div class="slides">
                    <?php
                    $slideIndex = 0;
                    foreach ($courses as $index => $course) {
                        if ($index % 3 == 0) {
                            if ($index > 0) echo '</div>';
                            echo '<div class="slide">';
                            $slideIndex++;
                        }
                    ?>
                            <div class="subject-card">
                                <h4><?php echo htmlspecialchars($course['name']); ?></h4>
                                <p><?php echo htmlspecialchars($course['id']); ?></p>
                                <form action="../backend/setCourse.php" method="post">
                                    <input type="hidden" name="course_id" value="<?php echo htmlspecialchars($course['id']); ?>">
                                    <button type="submit">Go to Course</button>
                                </form>
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
                <img src="../images/noContent.png" alt="No Content" width="400">
                <h2>No Subjects Found</h2>
            </div>
        <?php endif; ?>
    </div>

</body>
</html>
