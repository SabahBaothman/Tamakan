<?php
// nav.php and lessons.php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
;
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

include('../db/db_conn.php');

// Fetch the user's name from the database
$user_id = $_SESSION['id'];
$user_type = $_SESSION['user_type'];
$sql_user = "SELECT name FROM users WHERE id = ?";
$stmt_user = $conn->prepare($sql_user);
$stmt_user->bind_param("i", $user_id);
$stmt_user->execute();
$result_user = $stmt_user->get_result();
$user = $result_user->fetch_assoc();
$stmt_user->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Navbar</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <!-- Navigation bar -->
    <nav class="navbar">
        <div class="nav-left">
            <a href="courses.php" id="nav-logo-holder">
                <img id="logo" src="../images/logo.png" alt="Logo" width="80">
            </a>
            <a href="courses.php" id="nav-home-link">Home</a>
            <?php if ($user_type == 's'): ?>
                <span class="vertical-bar">|</span>
                <a href="dashboard.php" id="nav-scores-link">Dashboard</a>
            <?php endif; ?>
        </div>
        <div class="nav-right">
            <span><?php echo htmlspecialchars($user['name']); ?></span>
            <span class="vertical-bar">|</span>
            <a href="../backend/logout.php" id="nav-logout-link">Log Out</a>
        </div>
    </nav>
</body>
</html>
