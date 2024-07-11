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
                    <p><span id="totalScoreValue"></span>/100</p>
                </div>
            </div>
        </div>

        <?php
        if (isset($_GET['llos']) && isset($_GET['response'])) {
            $llos = json_decode($_GET['llos'], true);
            $response = $_GET['response'];

            // Replace \n with actual newline characters
            $response = str_replace('\\n', "\n", $response);

            if (!empty($response) && !empty($llos) && is_array($llos)) {
                // Split the response into sections for each LLO
                $responseSections = preg_split('/(?=Score: \d+)/', $response, -1, PREG_SPLIT_NO_EMPTY);

                $totalScore = 0;
                $numScores = 0;

                foreach ($llos as $index => $llo) {
                    if (isset($responseSections[$index])) {
                        $currentSection = $responseSections[$index+1];

                        // Extract the score from the current section
                        preg_match('/Score: (\d+)/', $currentSection, $matches);
                        $score = isset($matches[1]) ? (int)$matches[1] : 0;
                        $scorePer = $score * 10;

                        // Add to total score and increment the count of scores
                        $totalScore += $score;
                        $numScores++;

                        // Extract the comments from the current section
                        preg_match('/Comments:\n(.*?)\nImprovements:/s', $currentSection, $comments_matches);
                        $comments = isset($comments_matches[1]) ? trim($comments_matches[1]) : '';

                        // Extract the improvements from the current section
                        preg_match('/Improvements:\n(.*)/s', $currentSection, $improvements_matches);
                        $improvements = isset($improvements_matches[1]) ? trim($improvements_matches[1]) : '';

                        echo '
                        <div class="evalCard" comment="' . htmlspecialchars($comments) . '" data-explain="' . htmlspecialchars($improvements) . '">
                            <div class="upHalf">
                                <h3>LLO ' . ($index + 1) . '</h3>
                                <button class="scoreExplain">?</button>
                            </div>
                            <div class="downHalf">
                                <div><p>' . htmlspecialchars($llo) . '</p></div>
                                <div class="scoreContainer">
                                    <div class="scoreBar">
                                        <div class="scorePer" per="' . htmlspecialchars($scorePer) . '%" style="max-width: ' . htmlspecialchars($scorePer) . '%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>';
                    }
                }

                // Calculate the average score
                $averageScore = $numScores > 0 ? round(($totalScore / $numScores) * 10) : 0;
                echo '<script>
                        document.getElementById("totalScoreValue").textContent = ' . htmlspecialchars($averageScore) . ';
                      </script>';
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
