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
        <h5>Database and Database users</h5>
        <ul>
            <li><a href="#item1">Introduction to Databases</a></li>
            <li><a href="#item2">Component of Database Systems</a></li>
            <li><a href="#item3">Introduction to Databases</a></li>
        </ul>
        </div>
    <div id="explin_container">
        <div id="pdf-container">
            <canvas id="pdf-canvas"></canvas>
            <div id="navigation-controls">
                <button id="prev-page"><i class="fas fa-arrow-left"></i></button>
                <span id="page-num"></span> / <span id="page-count"></span>
                <button id="next-page"><i class="fas fa-arrow-right"></i></button>
            </div>
            <div class="recording-controls">
        <button id="toggleRecord"><i class="fas fa-microphone-slash"></i></button>
      </div>
      <div class="submit-button">
      <button type="button">Submit</button>
      </div>
        </div>
    </div>
    <script>
        var url = '../../CPCS433_Deep_learning_Network_Convolutional_Neural_Networks.pdf'; // URL to the PDF file

        var pdfDoc = null,
            pageNum = 1,
            pageRendering = false,
            pageNumPending = null,
            scale = 1.5,
            canvas = document.getElementById('pdf-canvas'),
            ctx = canvas.getContext('2d');

        pdfjsLib.getDocument(url).promise.then(function (pdfDoc_) {
            pdfDoc = pdfDoc_;
            document.getElementById('page-count').textContent = pdfDoc.numPages;
            renderPage(pageNum);
        });

        function renderPage(num) {
            pageRendering = true;
            pdfDoc.getPage(num).then(function (page) {
                var viewport = page.getViewport({ scale: scale });
                canvas.height = viewport.height;
                canvas.width = viewport.width;

                var renderContext = {
                    canvasContext: ctx,
                    viewport: viewport
                };
                var renderTask = page.render(renderContext);

                renderTask.promise.then(function () {
                    pageRendering = false;
                    if (pageNumPending !== null) {
                        renderPage(pageNumPending);
                        pageNumPending = null;
                    }
                });
            });

            document.getElementById('page-num').textContent = num;
        }

        function queueRenderPage(num) {
            if (pageRendering) {
                pageNumPending = num;
            } else {
                renderPage(num);
            }
        }

        document.getElementById('prev-page').addEventListener('click', function () {
            if (pageNum <= 1) {
                return;
            }
            pageNum--;
            queueRenderPage(pageNum);
        });

        document.getElementById('next-page').addEventListener('click', function () {
            if (pageNum >= pdfDoc.numPages) {
                return;
            }
            pageNum++;
            queueRenderPage(pageNum);
        });
    </script>
        <script src="../VoiceModel/input.js"></script>
</body>
</html>
