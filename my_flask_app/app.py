from flask import Flask, request, jsonify
from flask_cors import CORS
from transformers import pipeline
from pdfextraction_PyPDF2 import summaries_from_pdf
import PyPDF2


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

if __name__ == '__main__':
    app.run(host='0.0.0.0', port=5000)
