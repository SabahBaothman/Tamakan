from flask import Flask, send_from_directory, request, jsonify
import os
from faster_whisper import WhisperModel

app = Flask(__name__)

# Serve the index.php file
@app.route('/')
def index():
    return send_from_directory(os.path.dirname(__file__), 'index.php')

# Serve the input.js file
@app.route('/input.js')
def js_file():
    return send_from_directory(os.path.dirname(__file__), 'input.js')

@app.route('/transcribe', methods=['POST'])
def transcribe_audio():
    try:
        # Receive audio file from the client
        audio_file = request.files['audio']

        # Save the audio file to a temporary location
        audio_file.save('temp_audio.webm')

        # Transcribe the audio using the WhisperModel
        model_size = "medium.en"
        model = WhisperModel(model_size, device="cpu", compute_type="int8")
        segments, _ = model.transcribe('temp_audio.webm')
        transcribed_text = ''.join(segment.text for segment in segments)

        # Return the transcribed text as a JSON response
        response_data = {'transcription': transcribed_text}
        return jsonify(response_data)
    
    except Exception as e:
        return jsonify({'error': str(e)})

if __name__ == '__main__':
    app.run(debug=True)