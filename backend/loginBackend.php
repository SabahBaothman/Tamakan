<?php
session_start(); // Start the session

// Enable error reporting for debugging purposes
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include the database connection file
include('../db/db_conn.php');

// Check if the form data has been submitted
if (isset($_POST['id']) && isset($_POST['password'])) {

    // Function to validate and sanitize user input
    function validate($data) {
       $data = trim($data); // Remove whitespace from the beginning and end
       $data = stripslashes($data); // Remove backslashes
       $data = htmlspecialchars($data); // Convert special characters to HTML entities
       return $data;
    }

    // Validate and sanitize the form inputs
    $id = validate($_POST['id']);
    $password = validate($_POST['password']);

    // Check if the ID field is empty
    if (empty($id)) {
        header("Location: login.php?error=ID is required"); // Redirect to login page with error message
        exit();
    }
    // Check if the password field is empty
    else if (empty($password)) {
        header("Location: login.php?error=Password is required"); // Redirect to login page with error message
        exit();
    }
    else {
        // Prepare SQL query to check if the ID and password exist in the database
        $sql = "SELECT * FROM users WHERE id='$id' AND password='$password'";
        $result = mysqli_query($conn, $sql);

        // Check if there is exactly one matching record
        if (mysqli_num_rows($result) === 1) {
            $row = mysqli_fetch_assoc($result); // Fetch the record as an associative array

            // Verify that the ID and password match
            if ($row['id'] === $id && $row['password'] === $password) {
                echo "Logged in!"; // Indicate successful login

                // Store user ID in session variable
                $_SESSION['id'] = $row['id'];
                $_SESSION['user_type'] = $row['type'];

                // Redirect to the courses page
                header("Location: courses.php");
                exit();
            }
            else {
                // Redirect to login page with error message for incorrect ID or password
                header("Location: login.php?error=Incorect ID or password");
                exit();
            }
        }
        else {
            // Redirect to login page with error message for incorrect ID or password
            header("Location: login.php?error=Incorect ID or password");
            exit();
        }
    }
}
else {
    // Redirect to login page if form data is not submitted
    header("Location: login.php");
    exit();
}
?>
