<?php
// nav.php and lessons.php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../../style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Dashboard</title>
    <!-- Favicon icon-->
    <link rel="shortcut icon" type="images/x-icon" href="../images/blueLogo.ico" />
</head>
<?php include 'nav.php'; ?>

<body>
    <div class="d-flex justify-content-center align-items-center m-4">
        <iframe title="one student dashboard" width="1024" height="612" src="https://app.powerbi.com/view?r=eyJrIjoiMDNiNzY5MzEtZDY2YS00N2EwLThhOTAtOGE0MGZlZWYyYzNlIiwidCI6IjJkMzE5NGUzLTE2NTQtNDZiZC1iYWUyLWFkMzdiYTExYjBhZSIsImMiOjl9&pageName=d8dad3d3237978042e14" frameborder="0" allowFullScreen="true"></iframe>
    </div>
</body>

</html>