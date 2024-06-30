<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Subjects</title>
    <link rel="stylesheet" href="../style.css">
     
</head>
<?php
    include('nav.php');
?>
<body>
    
    
    <!-- Main Container -->
    <div class="subjects-container">
        <h4>Your Subjects</h4>
        <div class="hr-container">
            <hr id="subjects-line">
        </div>

        <!-- Slideshow -->
        <div class="slideshow-container">
            <div class="slides">

                <!-- First Slide -->
                <div class="slide">
                    <div class="subject-card">
                        <h4>Computer System Security</h4>
                        <p>CPCS-463</p>
                        <button>Go to Course</button>
                    </div>

                    <div class="subject-card">
                        <h4>Database</h4>
                        <p>CPCS-241</p>
                        <button>Go to Course</button>
                    </div>

                    <div class="subject-card">
                        <h4>Professional Computing Issues</h4>
                        <p>CPIS-428</p>
                        <button>Go to Course</button>
                    </div>
                </div>

                <!-- Second Slide -->
                <div class="slide">
                    <div class="subject-card">
                        <h4>Subject 4</h4>
                        <p>CODE-004</p>
                        <button>Go to Course</button>
                    </div>
                    <div class="subject-card">
                        <h4>Subject 5</h4>
                        <p>CODE-005</p>
                        <button>Go to Course</button>
                    </div>
                    <div class="subject-card">
                        <h4>Subject 6</h4>
                        <p>CODE-006</p>
                        <button>Go to Course</button>
                    </div>
                </div>

            </div>

            <!-- Navigation arrows -->
            <a class="prev" onclick="changeSlide(-1)">&#10094;</a>
            <a class="next" onclick="changeSlide(1)">&#10095;</a>
        </div>

        <!-- Dots for slide indicators -->
        <div class="dots">
            <span class="dot" onclick="currentSlide(1)"></span>
            <span class="dot" onclick="currentSlide(2)"></span>
        </div>
    </div>

    <script>
        // Initialize slideIndex to track current slide
        let slideIndex = 1;
        showSlides(slideIndex); // Display initial slide

        // Function to change slides
        function changeSlide(n) {
            showSlides(slideIndex += n); // Update slideIndex by n and show slides
        }

        // Function to switch to a specific slide
        function currentSlide(n) {
            showSlides(slideIndex = n); // Set slideIndex to n and show slides
        }

        // Function to display slides based on slideIndex
        function showSlides(n) {
            let slides = document.getElementsByClassName("slide");
            let dots = document.getElementsByClassName("dot");

            // Reset slideIndex if it goes beyond the number of slides
            if (n > slides.length) {
                slideIndex = 1;
            }
            if (n < 1) {
                slideIndex = slides.length;
            }

            // Hide all slides and deactivate all dots
            for (let i = 0; i < slides.length; i++) {
                slides[i].style.display = "none";
            }
            for (let i = 0; i < dots.length; i++) {
                dots[i].className = dots[i].className.replace(" active", "");
            }

            // Display the current slide and activate the corresponding dot
            slides[slideIndex - 1].style.display = "flex";
            dots[slideIndex - 1].className += " active";
        }
    </script>
</body>
</html>
