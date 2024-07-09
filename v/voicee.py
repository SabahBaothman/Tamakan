import whisper
import os

# Set the correct working directory if needed
os.chdir(os.path.dirname(os.path.abspath(__file__)))

# Print the current working directory for verification
print("Current working directory:", os.getcwd())

# Specify the path to your audio file
audio_file_path = 'u.wav'

# Check if the file exists
if not os.path.isfile(audio_file_path):
    print(f"File not found: {audio_file_path}")
else:
    # Load the Whisper model
    model = whisper.load_model("large")

    # Transcribe the audio file
    result = model.transcribe(audio_file_path)

    # Save the transcribed text to a file
    with open("transcription.txt", "w") as file:
        file.write(result["text"])

    print("Transcription saved to transcription.txt")
