<?php
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

// Increase maximum execution time to 300 seconds (5 minutes)
set_time_limit(300);

include('../db/db_conn.php');

if (isset($_GET['teacher_id'], $_GET['course_id'], $_GET['chapter_number'])) {
    $teacher_id = $_GET['teacher_id'];
    $course_id = $_GET['course_id'];
    $chapter_number = $_GET['chapter_number'];

    // Fetch the PDF path from the chapter table
    $query1 = "SELECT file FROM chapter WHERE teacher_id = ? AND course_id = ? AND number = ?";
    $stmt1 = mysqli_prepare($conn, $query1);
    mysqli_stmt_bind_param($stmt1, "iii", $teacher_id, $course_id, $chapter_number);
    mysqli_stmt_execute($stmt1);
    $result1 = mysqli_stmt_get_result($stmt1);
    if ($row1 = mysqli_fetch_assoc($result1)) {
        $pdf_file = $row1['file'];
    } else {
        die("Chapter not found.");
    }

    // Fetch lessons from the lessons table
    $query2 = "SELECT number, firstSlide, lastSlide FROM lessons WHERE teacher_id = ? AND course_id = ? AND chapter_number = ?";
    $stmt2 = mysqli_prepare($conn, $query2);
    mysqli_stmt_bind_param($stmt2, "iii", $teacher_id, $course_id, $chapter_number);
    mysqli_stmt_execute($stmt2);
    $result2 = mysqli_stmt_get_result($stmt2);

    while ($row2 = mysqli_fetch_assoc($result2)) {
        $lesson_number = $row2['number'];
        $first_slide = $row2['firstSlide'];
        $last_slide = $row2['lastSlide'];

        // Convert relative PDF path to absolute path
        $absolute_pdf_file = realpath($pdf_file);
        echo "Absolute PDF Path: $absolute_pdf_file, Start Page: $first_slide, End Page: $last_slide<br>";

        // Call Flask service for summarization in chunks
        $chunk_size = 5; // Number of pages per chunk
        $summaries = '';
        for ($i = $first_slide; $i <= $last_slide; $i += $chunk_size) {
            $chunk_end = min($i + $chunk_size - 1, $last_slide);

            $flask_service_url = 'http://localhost:5000/summarize';
            $data = array(
                'pdf_path' => $absolute_pdf_file,
                'start_page' => $i,
                'end_page' => $chunk_end
            );
            $options = array(
                'http' => array(
                    'header'  => "Content-Type: application/json\r\n",
                    'method'  => 'POST',
                    'content' => json_encode($data),
                    'timeout' => 120, // Increase timeout to 2 minutes
                ),
            );
            $context  = stream_context_create($options);
            $result = @file_get_contents($flask_service_url, false, $context);

            // Handle potential errors
            if ($result === FALSE) {
                $error = error_get_last();
                echo 'HTTP request failed. Error: ' . $error['message'];
                die('Error occurred while calling Flask service.');
            }

            $response_data = json_decode($result, true);
            if (isset($response_data['error'])) {
                die('Flask service error: ' . $response_data['error']);
            }

            $summaries .= $response_data['summary'];
        }

        // Save summary in the database
        $query3 = "UPDATE lessons SET summarization = ? WHERE teacher_id = ? AND course_id = ? AND chapter_number = ? AND number = ?";
        $stmt3 = mysqli_prepare($conn, $query3);
        mysqli_stmt_bind_param($stmt3, "siiii", $summaries, $teacher_id, $course_id, $chapter_number, $lesson_number);
        $stmt3->execute();
        $stmt3->close();
    }

    header("Location: ../pages/chapters.php");
    exit();

} else {
    die("Invalid request.");
}
?>
