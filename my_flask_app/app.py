from flask import Flask, request, jsonify
from flask_cors import CORS
from transformers import pipeline
from pdfextraction_PyPDF2 import summaries_from_pdf
import PyPDF2
import openai
from tenacity import retry, wait_exponential, stop_after_attempt


app = Flask(__name__)
CORS(app)


@app.route('/summarize', methods=['POST'])
def summarize():
    data = request.json
    pdf_path = data.get('pdf_path')
    start_page = data.get('start_page')
    end_page = data.get('end_page')
    print(f'Received request with path: {pdf_path}, start_page: {
          start_page}, end_page: {end_page}')

    if not pdf_path or start_page is None or end_page is None:
        return jsonify({'error': 'Missing parameters'}), 400

    try:
        summary = summaries_from_pdf(pdf_path, start_page, end_page)

        print(f'Summary: {summary}')
        return jsonify({'summary': summary})
    except Exception as e:
        print(f'Error: {e}')
        return jsonify({'error': str(e)}), 500

# -----------------------------------------------------------------------


# OpenAI API key
openai.api_key = 'sk-proj-ICuOpnqJgu2aGoKrDzacT3BlbkFJmCsf03Bc68Elugkxllmn'


@retry(wait=wait_exponential(multiplier=1, min=2, max=10), stop=stop_after_attempt(100))
def call_gpt(prompt, model_engine="gpt-4-turbo"):
    openai.api_key = 'sk-proj-ICuOpnqJgu2aGoKrDzacT3BlbkFJmCsf03Bc68Elugkxllmn'

    try:
        chat_completion = openai.ChatCompletion.create(
            model=model_engine,
            messages=[{"role": "user", "content": prompt}],
            max_tokens=300,
            temperature=0.0
        )
        return chat_completion.choices[0].message.content
    except Exception as e:
        print(f"An error occurred: {e}")
        return None


def evaluate_with_gpt(slide_summaries, student_explanation, LOs):
    results = []
    for lo in LOs:
        prompt = (
            "You are evaluating a student's explanation. Please provide a thorough evaluation based on the following guidelines:\n\n"

            "- Provide a title for each improvement paragraph, but do not use the word 'Title' itself.\n"
            "- Summarize the comments for each Learning Objective (LO) in no more than 60 words.\n"
            "- Summarize the improvements for each Learning Objective (LO) in no more than 60 words.\n"
            "- Evaluate the score of each Learning Objective separately and provide logical, varied scores.\n\n"

            f"Slide Summaries:\n{slide_summaries}\n\n"
            f"Student's Explanation:\n{student_explanation}\n\n"
            f"Learning Objective: {lo}\n\n"
            "Evaluate the student's explanation based on the slide summaries and the learning objective. "
            "Provide a score out of 100 along with brief comments justifying the score and suggest specific improvements (in points).\n"
            "Print the output in this format:\n"
            "Score: #\n"
            "Comments:\n"
            "1. Comment 1\n"
            "2. Comment 2\n"
            "3. Comment 3\n"
            "Improvements:\n"
            "1. Improvement Title: Explanation\n"
            "2. Improvement Title: Explanation\n"
            "3. Improvement Title: Explanation\n"
        )

        response = call_gpt(prompt)

        if response:
            results.append(response.strip())
        else:
            results.append("An error occurred during evaluation.")

    return results


@app.route('/evaluate', methods=['POST'])
def evaluate():
    data = request.json
    slide_summaries = data.get('summarize')
    student_explanation = data.get('transcribed_text')
    LOs = data.get('llos')

    print(f"Received data: {data}")  # Debugging: Print received data
    evaluation_results = evaluate_with_gpt(
        slide_summaries, student_explanation, LOs)
    # Debugging: Print results
    print(f"Evaluation results: {evaluation_results}")
    return jsonify(evaluation_results)


# -----------------------------------------------------------------------
if __name__ == '__main__':
    app.run(host='0.0.0.0', port=5000)
