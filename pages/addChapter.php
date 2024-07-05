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

    header("Location: chapters.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Chapter</title>
    <link rel="stylesheet" href="../style.css">
</head>
<?php include('nav.php'); ?>
<body>
    <main class="paddContainer">
        <!-- Header -->
        <div class="header">
            <div class="headContent">
                <h2 class="pageTitle">Add Chapter</h2>
                <div></div>
            </div>
        </div>

        <form class="add-chapter-form" method="POST" enctype="multipart/form-data">
            <!-- Form Fields -->
            <div id="add-chapter">
                <!-- Chapter Number -->
                <div class="input-block">
                    <label for="chapter-number">Chapter Number:</label>
                    <input type="text" id="chapter-number" name="chapter_number" placeholder="Enter Chapter Number" required>
                </div>
                
                <!-- Chapter Title -->
                <div class="input-block">
                    <label for="chapter-title">Chapter Title:</label>
                    <input type="text" id="chapter-title" name="chapter_title" placeholder="Enter Chapter Title" required>
                </div>

                <!-- Number of Lessons -->
                <div class="input-block">
                    <label for="main-lessons">Chapter Main Lessons:</label>
                    <input type="number" id="main-lessons" name="main_lessons" placeholder="Enter Number of Main Lessons" required>
                </div>

                <!-- LLOs Section -->
                <div id="add-llos">
                    <!-- Initial Lesson 1 Input Block -->
                    <div class="input-block">
                        <label for="lesson-title-1">Lesson 1:</label>
                        <input type="text" id="lesson-title-1" name="lesson_title_1" placeholder="Enter Lesson 1 Title" required>
                    </div>
                    <div class="input-block">
                        <label for="slides-number-1">Slides Number:</label>
                        <div class="slides-block">
                            <input type="number" id="slides-from-1" name="slides_from_1" class="slides-input" placeholder="From" required>
                            <input type="number" id="slides-to-1" name="slides_to_1" class="slides-input" placeholder="To" required>
                        </div>
                    </div>
                    <div class="input-block">
                        <label for="llo-1">Lesson Learning Outcomes (LLOs) 1:</label>
                        <input type="text" id="llo-1" name="llo_1" placeholder="Add LLOs for Lesson 1" required>
                    </div>
                </div>

            </div> 
            
            <!-- Upload File -->
            <div class="file-upload">
                <img id="upload" src="../images/uploadFile.png" alt="upload file" width="50">
                <p></p>
                <input type="file" id="upload-chapter" name="upload_chapter" required>
                <label for="upload-chapter"><u>Click to Upload Chapter</u></label>
            </div>
            
            <button type="submit" class="button">Submit</button>
        </form>
    </main>
    
    <script>
        document.getElementById('main-lessons').addEventListener('input', function() {
    const numLessons = parseInt(this.value);
    const addLlos = document.getElementById('add-llos');
    const currentLessonCount = addLlos.children.length / 3;

    if (!isNaN(numLessons) && numLessons > currentLessonCount) {
        for (let i = currentLessonCount + 1; i <= numLessons; i++) {
            const lessonTitleDiv = document.createElement('div');
            lessonTitleDiv.classList.add('input-block');

            const lessonTitleLabel = document.createElement('label');
            lessonTitleLabel.setAttribute('for', 'lesson-title-' + i);
            lessonTitleLabel.textContent = 'Lesson ' + i + ':';

            const lessonTitleInput = document.createElement('input');
            lessonTitleInput.setAttribute('type', 'text');
            lessonTitleInput.setAttribute('id', 'lesson-title-' + i);
            lessonTitleInput.setAttribute('name', 'lesson_title_' + i);
            lessonTitleInput.setAttribute('placeholder', 'Enter Lesson ' + i + ' Title');

            lessonTitleDiv.appendChild(lessonTitleLabel);
            lessonTitleDiv.appendChild(lessonTitleInput);

            addLlos.appendChild(lessonTitleDiv);

            const slidesDiv = document.createElement('div');
            slidesDiv.classList.add('input-block');

            const slidesLabel = document.createElement('label');
            slidesLabel.setAttribute('for', 'slides-number-' + i);
            slidesLabel.textContent = 'Slides Number:';

            const slidesBlockDiv = document.createElement('div');
            slidesBlockDiv.classList.add('slides-block');

            const slidesFromInput = document.createElement('input');
            slidesFromInput.setAttribute('type', 'number');
            slidesFromInput.setAttribute('id', 'slides-from-' + i);
            slidesFromInput.setAttribute('name', 'slides_from_' + i);
            slidesFromInput.setAttribute('placeholder', 'From');
            slidesFromInput.classList.add('slides-input');

            const slidesToInput = document.createElement('input');
            slidesToInput.setAttribute('type', 'number');
            slidesToInput.setAttribute('id', 'slides-to-' + i);
            slidesToInput.setAttribute('name', 'slides_to_' + i);
            slidesToInput.setAttribute('placeholder', 'To');
            slidesToInput.classList.add('slides-input');

            slidesBlockDiv.appendChild(slidesFromInput);
            slidesBlockDiv.appendChild(slidesToInput);

            slidesDiv.appendChild(slidesLabel);
            slidesDiv.appendChild(slidesBlockDiv);
            addLlos.appendChild(slidesDiv);

            const lloDiv = document.createElement('div');
            lloDiv.classList.add('input-block');

            const lloLabel = document.createElement('label');
            lloLabel.setAttribute('for', 'llo-' + i);
            lloLabel.textContent = 'Lesson Learning Outcomes (LLOs) ' + i + ':';

            const lloInput = document.createElement('input');
            lloInput.setAttribute('type', 'text');
            lloInput.setAttribute('id', 'llo-' + i);
            lloInput.setAttribute('name', 'llo_' + i);
            lloInput.setAttribute('placeholder', 'Add LLOs for Lesson ' + i);

            lloDiv.appendChild(lloLabel);
            lloDiv.appendChild(lloInput);

            addLlos.appendChild(lloDiv);
        }
    }
});


    </script>
</body>
</html>
