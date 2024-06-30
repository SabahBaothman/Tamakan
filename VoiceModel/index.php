<!DOCTYPE html>
<html lang="en">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OpenAI Whisper API</title>
    <style>
      .recording-controls button {
            background-color: #CBDBC5;
            border: none;
            border-radius: 30px;
            padding: 10px 15px;
            margin-right: 10px;
            color: #254558;
        }

        .recording-controls button i {
    font-size: 24px; /* Adjust the size of the icon as needed */
    color: black;
}

        .recording-controls audio {
            display: block;
            margin-top: 10px;
        }


    </style>
</head>

<body>
    <div class="container">
        <div class="recording-controls">
                <button id="toggleRecord"><i class="fas fa-microphone-slash"></i></button>
        </div>

    </div>

    <script src="input.js"></script>
</body>

</html>