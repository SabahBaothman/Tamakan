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
    print(f'Received request with path: {pdf_path}, start_page: {start_page}, end_page: {end_page}')
    
    if not pdf_path or start_page is None or end_page is None:
        return jsonify({'error': 'Missing parameters'}), 400

    try:
        summary = summaries_from_pdf(pdf_path, start_page, end_page)

        print(f'Summary: {summary}')
        return jsonify({'summary': summary})
    except Exception as e:
        print(f'Error: {e}')
        return jsonify({'error': str(e)}), 500
    
#-----------------------------------------------------------------------

# OpenAI API key
openai.api_key = 'sk-proj-ICuOpnqJgu2aGoKrDzacT3BlbkFJmCsf03Bc68Elugkxllmn'

@retry(wait=wait_exponential(multiplier=1, min=2, max=10), stop=stop_after_attempt(100))
def call_gpt(prompt, model_engine="gpt-4-turbo"):
    try:
        chat_completion = openai.ChatCompletion.create(
            model=model_engine,
            messages=[{"role": "user", "content": prompt}],
            max_tokens=1000,
            temperature=0.0
        )
        return chat_completion.choices[0].message.content
    except Exception as e:
        print(f"An error occurred: {e}")
        return None

    
    
def evaluate_with_gpt(slide_summaries, student_explanation, LOs):
    slide_summaries_str = "\n".join(slide_summaries) if isinstance(slide_summaries, list) else slide_summaries
    student_explanation_str = "\n".join(student_explanation) if isinstance(student_explanation, list) else student_explanation
    LOs_str = "\n".join(LOs) if isinstance(LOs, list) else LOs
    prompt = (
        "Generate a Score for the given Student Explanation: \"" + student_explanation_str + "\"\n"
        "Evaluate this based on important points from the slides \"" + slide_summaries_str + "\" \n"
        "And these lesson-learning outcomes (LOs): \"" + LOs_str + "\"\n"
        "Provide a score out of 10 for each LOs\n"
        "Print the output in this format just print the Scores without anthing and without Bold font:\n"
        "Score: #\n"
    )
    # prompt = (
    #     "Generate a performance report for the given Student Explanation: \"" + student_explanation_str + "\"\n"
    #     "Evaluate this based on important points from the slides \"" + slide_summaries_str + "\" \n"
    #     "And these lesson-learning outcomes (LOs): \"" + LOs_str + "\"\n"
    #     "Criteria:\n"
    #     "1. Clarity of Explanation: How clear and easy to understand is the provided information? Was the explanation clear and easy to understand? Did the student use simple and understandable words?\n"
    #     "2. Content Organization: How logically and smoothly are the ideas and information arranged? Were the ideas logically and easily followed? Was the transition between topics smooth?\n"
    #     "3. Use of Examples: How well does the student use real-life or illustrative examples to simplify concepts? Did the student use illustrative examples when explaining complex concepts? Were the examples helpful in clarifying the idea?\n\n"
    #     "Provide a score out of 10 for each LOs, along with brief comments justifying the score and short specific suggestions for improvement.\n"
    #     "Print the output in this format:\n"
    #     "Score: #\n"
    #     "Comments:\n"
    #     "1. Clarity of Explanation:\n"
    #     "2. Content Organization:\n"
    #     "3. Use of Examples:\n"
    #     "Improvements:\n"
    #     "1. Improvement Title: Explanation\n"
    #     "2. Improvement Title: Explanation\n"
    #     "3. Improvement Title: Explanation\n"
    # )
    print("\n",prompt,"\n")
    response = call_gpt(prompt)
    print (response)
    prompt2 = (
        "Generate a performance report for the given Student Explanation: \"" + student_explanation_str + "\"\n"
        "And "
        "And this the important points from the slides \"" + slide_summaries_str + "\" \n"
        "And these lesson-learning outcomes (LOs): \"" + LOs_str + "\"\n"
        "This is the score for each LOs \"" + prompt + "\"\n"
        "Evaluate this based on these Criteria:\n"
        "1. Clarity of Explanation: How clear and easy to understand is the provided information? Was the explanation clear and easy to understand? Did the student use simple and understandable words?\n"
        "2. Content Organization: How logically and smoothly are the ideas and information arranged? Were the ideas logically and easily followed? Was the transition between topics smooth?\n"
        "3. Use of Examples: How well does the student use real-life or illustrative examples to simplify concepts? Did the student use illustrative examples when explaining complex concepts? Were the examples helpful in clarifying the idea?\n\n"
        "Provide a brief comments justifying the score and short specific suggestions for improvement.\n"
        "Print the output in this format without Bold font for each LOs:\n"
        "Score: #\n"
        "Comments:\n"
        "1. Clarity of Explanation:\n"
        "2. Content Organization:\n"
        "3. Use of Examples:\n"
        "Improvements:\n"
        "1. Improvement Title: Explanation\n"
        "2. Improvement Title: Explanation\n"
        "3. Improvement Title: Explanation\n"
    )

    response = call_gpt(prompt2)
    print("\n",prompt2,"\n")
    return response

@app.route('/evaluate', methods=['POST'])
def evaluate():
    data = request.json
    slide_summaries = data.get('summarize')
    student_explanation = data.get('transcribed_text')
    LOs = data.get('llos')
    
    print(f"Received data: {data}")  # Debugging: Print received data
    evaluation_results = evaluate_with_gpt(slide_summaries, student_explanation, LOs)
    print(f"Evaluation results: {evaluation_results}")  # Debugging: Print results
    return jsonify(evaluation_results)

#-----------------------------------------------------------------------
if __name__ == '__main__':
    app.run(host='0.0.0.0', port=5000)
