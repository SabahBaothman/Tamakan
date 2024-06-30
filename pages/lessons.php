<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../../style.css">
    <title>Chapters</title>
</head>

<?php
include('./nav.php');
?>

<body>
    <div class="paddContainer">

        <!-- HEADER -->
        <div class="header">
            <div class="pageTitle">
                <h2>Lessons</h2>
            </div>
            <div class="pageSubtitle">
                <p><span>Database and Database users</span></p>
            </div>
        </div>

        <!-- LESSONS -->
        <div>
            <div class="lessonCard">
                <div class="leftContent">
                    <div class="checked">
                        <div class="checkmark"></div>
                    </div>
                    <p>Introduction to Databases</p>
                </div>

                <div class="rigthContent">
                    <button id="scoreBtn" type="button">View Score</button>
                    <button type="button">Explain</button>
                </div>
            </div>

            <div class="lessonCard">
                <div class="leftContent">
                    <div class="uncheck"></div>
                    <p>The Role of Database Management Systems (DBMS)</p>
                </div>

                <div class="rigthContent">
                    <button type="button">Explain</button>
                </div>
            </div>
        </div>
        
    </div>
</body>
</html>