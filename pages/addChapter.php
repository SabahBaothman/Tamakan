

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Chapter</title>
    <link rel="stylesheet" href="../style.css">
    <!-- Favicon icon-->
	<link rel="shortcut icon" type="images/x-icon" href="../images/blueLogo.ico" />
    <script src="../javascript/addChapter.js" defer></script>
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

        <form class="add-chapter-form" method="POST" enctype="multipart/form-data" action="../backend/addChapterBackend.php">
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
                <span id="file-name" class="hidden"></span>
            </div>
            
   

            <button type="submit" class="button">Submit</button>
        </form>
    </main>
</body>

<script>

document.getElementById('upload-chapter').addEventListener('change', function(event) {
    const fileName = document.getElementById('file-name');

    if (event.target.files[0]) {
        // Show the file name 
        fileName.textContent = event.target.files[0].name;
        fileName.classList.remove('hidden');
    }
});
</script>

</html>
