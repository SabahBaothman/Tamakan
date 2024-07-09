<?php
include('../db/db_conn.php');

if (isset($_GET['teacher_id'], $_GET['course_id'], $_GET['chapter_number'], $_GET['lesson_number'], $_GET['transcribed_text'])) {
    $teacher_id = $_GET['teacher_id'];
    $course_id = $_GET['course_id'];
    $chapter_number = $_GET['chapter_number'];
    $lesson_number = $_GET['lesson_number'];
    $transcribed_text = $_GET['transcribed_text'];

    // Fetch the summarize from lessons table
    $query1 = "SELECT summarization FROM lessons WHERE teacher_id = ? AND course_id = ? AND chapter_number = ? AND number = ?";
    $stmt1 = mysqli_prepare($conn, $query1);
    mysqli_stmt_bind_param($stmt1, "iiii", $teacher_id, $course_id, $chapter_number, $lesson_number);
    mysqli_stmt_execute($stmt1);
    $result1 = mysqli_stmt_get_result($stmt1);
    $summarize = mysqli_fetch_assoc($result1)['summarization'];

    // Fetch the LLOs from llos table
    $query2 = "SELECT llos_content FROM llos WHERE teacher_id = ? AND course_id = ? AND chapter_number = ? AND lesson_number = ?";
    $stmt2 = mysqli_prepare($conn, $query2);
    mysqli_stmt_bind_param($stmt2, "iiii", $teacher_id, $course_id, $chapter_number, $lesson_number);
    mysqli_stmt_execute($stmt2);
    $result2 = mysqli_stmt_get_result($stmt2);
    $llos_string = mysqli_fetch_assoc($result2)['llos_content'];

    // Split the LLOs string into an array
    $llos_array = explode(',', $llos_string);

    // Prepare data to send to Python server
    $data = [
        'summarize' => $summarize,
        'transcribed_text' => $transcribed_text,
        'llos' => $llos_array
    ];


    // Prepare data to send to Python server
    $data = [
        'summarize' => $summarize,
        'transcribed_text' => $transcribed_text,
        'llos' => $llos_array
    ];

    // Call Flask service for evaluation
    $flask_service_url = 'http://localhost:5000/evaluate';
    $options = array(
        'http' => array(
            'header'  => "Content-Type: application/json\r\n",
            'method'  => 'POST',
            'content' => json_encode($data),
        ),
    );
    
    $context  = stream_context_create($options);
    $result = file_get_contents($flask_service_url, false, $context);

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

    echo '<pre>';
    print_r($response_data);
    echo '</pre>';
} else {
    echo json_encode(['error' => 'Invalid request.']);
}
?>