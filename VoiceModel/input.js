let chunks = [];
let mediaRecorder;
let toggleRecordButton = document.getElementById("toggleRecord");
let isRecording = false;

toggleRecordButton.addEventListener("click", () => {
    if (!mediaRecorder) {
        navigator.mediaDevices.getUserMedia({ audio: true }).then((stream) => {
            mediaRecorder = new MediaRecorder(stream, { mimeType: "audio/webm" });
            mediaRecorder.start();
            isRecording = true;
            toggleRecordButton.innerHTML = '<i class="fas fa-microphone"></i>';
            console.log("Recording started...");

            mediaRecorder.ondataavailable = (e) => {
                chunks.push(e.data);
            };

            mediaRecorder.onstop = (e) => {
                let blob = new Blob(chunks, { type: "audio/webm" });
                chunks = [];

                var formData = new FormData();
                var file = new File([blob], "user_audio.webm", {
                    type: "audio/webm",
                });
                formData.append("audio", file);

                console.log("Sending audio file to server...");

                fetch("../VoiceModel/whisper_send_data.php", {
                    method: "POST",
                    body: formData,
                })
                    .then((response) => {
                        if (!response.ok) {
                            throw new Error("HTTP error " + response.status);
                        }
                        return response.text();
                    })
                    .then((data) => {
                      console.log("Response from server:", data); // Log the response
                      // let whisper_received_data = JSON.parse(data);
                      // document.getElementById("whisper_response_display_area").textContent =
                      //     whisper_received_data.text;
                      // console.log("Response from server:", whisper_received_data);
                      document.getElementById('transcribed_text').value = data;
                    })
                    .catch(function (error) {
                        console.error("Error sending audio file to server:", error);
                    });

                isRecording = false;
                toggleRecordButton.innerHTML = '<i class="fas fa-microphone-slash"></i>';
                console.log("Recording stopped...");
            };
        });
    } else {
        mediaRecorder.stop();
        mediaRecorder = null;
    }
});
