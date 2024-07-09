<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../../style.css">
    <!-- Favicon icon-->
	<link rel="shortcut icon" type="images/x-icon" href="../images/blueLogo.ico" />
    <title>Evaluation</title>
</head>

<?php
include('./nav.php');
?>

<body>
    <div class="paddContainer">

        <!-- HEADER -->
        <div class="header">
            <div class="headContent">
                <h2 class="pageTitle">Evaluation</h2>
                <div></div>
            </div>

            <div id="totalContainer" class="pageSubtitle">
                <p><span>Total Score</span></p>
                <div id="totalScore">
                    <p><span>51</span>/100</p>
                </div>
            </div>
        </div>

        <!-- LLO Evaluation -->
        <div class="evalCard">
            <div class="upHalf">
                <h3>LLO 1</h3>
                <button class="scoreExplain">?</button>
            </div>
            
            <div class="downHalf">
                <div><p>Explain the characteristics that distinguish the database approach from the approach of programming with data files.</p></div>
                <div class="scoreContainer">
                    <div class="scoreBar">
                        <div class="scorePer" per="70%" style="max-width: 70%">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="evalCard">
            <div class="upHalf">
                <h3>LLO 1</h3>
                <button class="scoreExplain">?</button>
            </div>
            
            <div class="downHalf">
                <div><p>Identify major DBMS functions and describe their role in a database system.</p></div>
                <div class="scoreContainer">
                    <div class="scoreBar">
                        <div class="scorePer" per="40%" style="max-width: 40%">
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- POPUP WINDOW -->
    <div id="popup">
        <div class="popupContent">
            <h3>You Scored <span>40%</span> on <span>LLO 1</span></h3>
            <div class="separator"></div>
            <span class="close">&times;</span>
            <p>Here will be the explanation text.</p>
        </div>
    </div>

    <script src="../javascript/evaluation.js"></script>
</body>

</html>