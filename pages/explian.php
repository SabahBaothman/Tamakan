<?php

include('../db/db_conn.php');

$pdf_file = ''; // Initialize an empty variable
$lessons = []; // Initialize an empty array for lessons

if (isset($_POST['teacher_id'], $_POST['course_id'], $_POST['chapter_number'], $_POST['lesson_number'])) {
    $teacher_id = $_POST['teacher_id'];
    $course_id = $_POST['course_id'];
    $chapter_number = $_POST['chapter_number'];
    $lesson_number = $_POST['lesson_number'];

    // First query to fetch the PDF path from the chapters table
    $query1 = "SELECT file,title FROM chapter WHERE teacher_id = ? AND course_id = ? AND number = ?";
    $stmt1 = mysqli_prepare($conn, $query1);
    mysqli_stmt_bind_param($stmt1, "iii", $teacher_id, $course_id, $chapter_number);
    mysqli_stmt_execute($stmt1);
    $result1 = mysqli_stmt_get_result($stmt1);
    if ($row1 = mysqli_fetch_assoc($result1)) {
        $pdf_file = $row1['file'];
        $chapter_name = $row1['title'];
    } else {
        die("Chapter not found.");
    }
    // Second query to fetch the lessons from the lessons table
    $query2 = "SELECT title,firstSlide,lastSlide FROM lessons WHERE teacher_id = ? AND course_id = ? AND chapter_number = ?";
    $stmt2 = mysqli_prepare($conn, $query2);
    mysqli_stmt_bind_param($stmt2, "iii", $teacher_id, $course_id, $chapter_number);
    mysqli_stmt_execute($stmt2);
    $result2 = mysqli_stmt_get_result($stmt2);

    while ($row2 = mysqli_fetch_assoc($result2)) {
        $lessons[] = $row2['title'];
    }
    // Third query to fetch the first and last slide numbers from the lessons table
    $query3 = "SELECT firstSlide, lastSlide FROM lessons WHERE teacher_id = ? AND course_id = ? AND chapter_number = ? AND number = ?";
    $stmt3 = mysqli_prepare($conn, $query3);
    mysqli_stmt_bind_param($stmt3, "iiii", $teacher_id, $course_id, $chapter_number, $lesson_number);
    mysqli_stmt_execute($stmt3);
    $result3 = mysqli_stmt_get_result($stmt3);

    if ($row3 = mysqli_fetch_assoc($result3)) {
        $first_slide = $row3['firstSlide'];
        $last_slide = $row3['lastSlide'];
    } else {
        die("Lesson not found.");
    }
} else {
    die("Invalid request.");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Explian Page</title>
    <link rel="stylesheet" href="../../style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.9.359/pdf.min.js"></script>
</head>

<?php
include('nav.php');
?>

<body>
    <div id="lesson_menu">
        <h5><?php echo htmlspecialchars($chapter_name); ?></h5> <!-- Display the chapter name -->
        <ul>
            <?php foreach ($lessons as $lesson) : ?>
                <li><a href="#"><?php echo htmlspecialchars($lesson); ?></a></li>
            <?php endforeach; ?>
        </ul>
    </div>
    <div id="explin_container">
        <div id="pdf-container">
            <div id="navigation-controls">
                <button id="prev-page"><a onclick="changeSlide(-1)">&#10094;</a></button>
                <canvas id="pdf-canvas"></canvas>
                <button id="next-page"><a onclick="changeSlide(1)">&#10095;</a></button>
            </div>
            <div class="page-count">
                <span id="page-num"></span> / <span id="page-count"></span>
            </div>
            <div class="butnContainer" style="display: flex; flex-direction: row; justify-content: space-between; align-items: center; width: 100%;">
                <div class="recording-controls">
                    <button id="toggleRecord"><i class="fas fa-microphone-slash"></i></button>
                </div>
                <div class="submit-button" style="margin-left: auto;">
                    <button type="button" class="button">Submit</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var url = "<?php echo htmlspecialchars($pdf_file); ?>"; // URL to the PDF file
            var firstSlide = <?php echo $first_slide; ?>;
            var lastSlide = <?php echo $last_slide; ?>;

            var pdfDoc = null,
                pageNum = firstSlide,
                pageRendering = false,
                pageNumPending = null,
                scale = 1.5,
                canvas = document.getElementById('pdf-canvas'),
                ctx = canvas.getContext('2d');

            console.log('Document loaded');
            console.log('PDF URL:', url);
            console.log('First Slide:', firstSlide);
            console.log('Last Slide:', lastSlide);

            pdfjsLib.getDocument(url).promise.then(function(pdfDoc_) {
                pdfDoc = pdfDoc_;
                console.log('PDF loaded');
                document.getElementById('page-count').textContent = (lastSlide - firstSlide + 1);
                renderPage(pageNum);
            }).catch(function(error) {
                console.error('Error loading PDF:', error);
            });

            function renderPage(num) {
                console.log('Rendering page:', num);
                pageRendering = true;
                pdfDoc.getPage(num).then(function(page) {
                    var viewport = page.getViewport({
                        scale: scale
                    });
                    canvas.height = viewport.height;
                    canvas.width = viewport.width;

                    var renderContext = {
                        canvasContext: ctx,
                        viewport: viewport
                    };
                    var renderTask = page.render(renderContext);

                    renderTask.promise.then(function() {
                        pageRendering = false;
                        console.log('Page rendered:', num);
                        if (pageNumPending !== null) {
                            renderPage(pageNumPending);
                            pageNumPending = null;
                        }
                    });
                }).catch(function(error) {
                    console.error('Error rendering page:', error);
                });

                document.getElementById('page-num').textContent = (num - firstSlide + 1);
            }

            function queueRenderPage(num) {
                if (pageRendering) {
                    pageNumPending = num;
                } else {
                    renderPage(num);
                }
            }

            document.getElementById('prev-page').addEventListener('click', function() {
                if (pageNum <= firstSlide) {
                    return;
                }
                pageNum--;
                queueRenderPage(pageNum);
            });

            document.getElementById('next-page').addEventListener('click', function() {
                if (pageNum >= lastSlide) {
                    return;
                }
                pageNum++;
                queueRenderPage(pageNum);
            });
        });
    </script>
    <script src="../VoiceModel/input.js"></script>
</body>

</html>
