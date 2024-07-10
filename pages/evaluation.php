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

        <?php
        if (isset($_GET['llos']) && isset($_GET['response'])) {
            $llos = json_decode($_GET['llos'], true);
            $response = json_decode($_GET['response'], true);

            // Debug statements to check received data
            echo "<pre>";
            echo "Received LLOs: ";
            print_r($llos);
            echo "Received Response: ";
            print_r($response);
            echo "</pre>";

            if (!empty($response) && is_array($response) && !empty($llos) && is_array($llos)) {
                foreach ($llos as $index => $llo) {
                    if (isset($response[$index])) {
                        // Extract the score from the response
                        preg_match('/Score: (\d+)%/', $response[$index], $matches);
                        $score = isset($matches[1]) ? $matches[1] : 0;

                        // Extract the comments from the response
                        preg_match('/Comments:\n(.*?)\nImprovements:/s', $response[$index], $comments_matches);
                        $comments = isset($comments_matches[1]) ? $comments_matches[1] : '';

                        // Extract the improvements from the response
                        preg_match('/Improvements:\n(.*)/s', $response[$index], $improvements_matches);
                        $improvements = isset($improvements_matches[1]) ? $improvements_matches[1] : '';

                        echo '
                        <div class="evalCard" comment= "'.$comments.'" data-explain=" '.$improvements.'">
                            <div class="upHalf">
                                <h3>LLO '. ($index + 1) . '</h3>
                                <button class="scoreExplain">?</button>
                            </div>                           
                            <div class="downHalf">
                            <div><p>' . htmlspecialchars($llo). '</p> </div>
                                <div class="scoreContainer">
                                    <div class="scoreBar">
                                        <div class="scorePer" per="'. htmlspecialchars($score) . '%" style="max-width: '. htmlspecialchars($score) . '%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>';
                    }
                }
            } else {
                echo '<p>No evaluations found.</p>';
            }
        } else {
            echo '<p>Invalid request. No data received.</p>';
        }
        ?>
    </div>

    <!-- POPUP WINDOW -->
    <div id="popup">
        <div class="popupContent">
            <h3>You Scored <span>40%</span> on <span>LLO 1</span></h3>
            <div class="separator"></div>
            <span class="close">&times;</span>
            <p>Here will be the explanation text.</p>
            <p>Here will be the explanation text.</p>
        </div>
    </div>

    <script src="../javascript/evaluation.js"></script>
</body>

</html>
