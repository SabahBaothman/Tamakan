<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Chapter</title>
    <link rel="stylesheet" href="../style.css">
     
</head>
<?php
    include('nav.php');
?>
<body>
    <main class="paddContainer">
        <!-- Header -->
        <div class="header">
            <div class="headContent">
                <h2 class="pageTitle">Add Chapter</h2>
                <div></div>
            </div>
        </div>

        <form class="add-chapter-form">

            <!-- Form Fields -->
            <div id="add-chapter">

                <!-- Chapter Number -->
                <div class="input-block">
                    <label for="chapter-number">Chapter Number:</label>
                    <input type="text" id="chapter-number" placeholder="Enter Chapter Number">
                </div>
                
                <!-- Chapter Title -->
                <div class="input-block">
                    <label for="chapter-title">Chapter Title:</label>
                    <input type="text" id="chapter-title" placeholder="Enter Chapter Title">
                </div>

                <!-- Number of Lessons -->
                <div class="input-block">
                    <label for="main-lessons">Chapter Main Lessons:</label>
                    <input type="text" id="main-lessons" placeholder="Enter Number of Main Lessons">
                </div>

                <!-- LLOs Section -->
                <div id="add-llos">
                    <!-- Initial Lesson 1 Input Block -->
                    <div class="input-block">
                        <label for="lesson-title-1">Lesson 1:</label>
                        <input type="text" id="lesson-title-1" placeholder="Enter Lesson 1 Title">
                    </div>
                    <div class="input-block">
                        <label for="llo-1">Lesson Learning Outcomes (LLOs) 1:</label>
                        <input type="text" id="llo-1" placeholder="Add LLOs for Lesson 1">
                    </div>
                </div>
            </div> 
            
            <!-- Upload File -->
            <div class="file-upload">
                <img id="upload" src="../images/uploadFile.png" alt="upload file" width="50">
                <p></p>
                <input type="file" id="upload-chapter">
                <label for="upload-chapter"><u>Click to Upload Chapter</u></label>
            </div>
            
            <button type="submit" class="button">Submit</button>
        </form>
    </main>
    
    <script>
        // Add event listener to the 'Chapter Main Lessons' input field
        document.getElementById('main-lessons').addEventListener('input', function() {
            // Parse the number of lessons entered by the user
            const numLessons = parseInt(this.value);
            // Get the container for the lessons
            const addLlos = document.getElementById('add-llos');
            // Get the current number of lesson input blocks
            const currentLessonCount = addLlos.children.length / 2;

            // Check if the entered value is a valid number and greater than the current number of lessons
            if (!isNaN(numLessons) && numLessons > currentLessonCount) {
                // Loop to create input fields for the additional lessons
                for (let i = currentLessonCount + 1; i <= numLessons; i++) {
                    // Create a div for lesson title input block
                    const lessonTitleDiv = document.createElement('div');
                    lessonTitleDiv.classList.add('input-block');

                    // Create label for lesson title
                    const lessonTitleLabel = document.createElement('label');
                    lessonTitleLabel.setAttribute('for', 'lesson-title-' + i);
                    lessonTitleLabel.textContent = 'Lesson ' + i + ':';

                    // Create input field for lesson title
                    const lessonTitleInput = document.createElement('input');
                    lessonTitleInput.setAttribute('type', 'text');
                    lessonTitleInput.setAttribute('id', 'lesson-title-' + i);
                    lessonTitleInput.setAttribute('placeholder', 'Enter Lesson ' + i + ' Title');

                    // Append label and input to the lesson title div
                    lessonTitleDiv.appendChild(lessonTitleLabel);
                    lessonTitleDiv.appendChild(lessonTitleInput);

                    // Append lesson title div to the container
                    addLlos.appendChild(lessonTitleDiv);

                    // Create a div for LLO input block
                    const lloDiv = document.createElement('div');
                    lloDiv.classList.add('input-block');

                    // Create label for LLO
                    const lloLabel = document.createElement('label');
                    lloLabel.setAttribute('for', 'llo-' + i);
                    lloLabel.textContent = 'Lesson Learning Outcomes (LLOs) ' + i + ':';

                    // Create input field for LLO
                    const lloInput = document.createElement('input');
                    lloInput.setAttribute('type', 'text');
                    lloInput.setAttribute('id', 'llo-' + i);
                    lloInput.setAttribute('placeholder', 'Add LLOs for Lesson ' + i);

                    // Append label and input to the LLO div
                    lloDiv.appendChild(lloLabel);
                    lloDiv.appendChild(lloInput);

                    // Append LLO div to the container
                    addLlos.appendChild(lloDiv);
                }
            }
        });
    </script>
</body>
</html>
