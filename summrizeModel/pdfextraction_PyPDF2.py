import PyPDF2
from transformers import pipeline
import spacy

def extract_text_from_pdf(pdf_path):
    with open(pdf_path, 'rb') as file:
        reader = PyPDF2.PdfReader(file)
        slides = []
        for page_num in range(len(reader.pages)):
            page = reader.pages[page_num]
            text = page.extract_text()
            slides.append(text)
    return slides

# Example usage
pdf_path = 'CPCS433_Deep_learning_Network_Convolutional_Neural_Networks.pdf'
slides_text = extract_text_from_pdf(pdf_path)

# Initialize the summarization pipeline
summarizer = pipeline("summarization", model="facebook/bart-large-cnn")

# Summarize each slide
summaries = []
for slide_text in slides_text:
    if slide_text.strip():  # Check if the slide is not empty
        summary = summarizer(slide_text, max_length=150, min_length=40, do_sample=False)
        summaries.append(summary[0]['summary_text'])

# Print summaries
for i, summary in enumerate(summaries, 1):
    print(f"Summary of Slide {i}:\n{summary}\n")

################################################################################################
"""
def extract_text_from_pdf(pdf_path):
    with open(pdf_path, 'rb') as file:
        reader = PyPDF2.PdfReader(file)
        text = ""
        for page_num in range(len(reader.pages)):
            page = reader.pages[page_num]
            text += page.extract_text()
    return text

# Example usage
pdf_path = 'CPCS433_Deep_learning_Network_Convolutional_Neural_Networks.pdf'
extracted_text = extract_text_from_pdf(pdf_path)
print(extracted_text)


# Load pre-trained SpaCy model
nlp = spacy.load('en_core_web_sm')

def extract_entities(text):
    doc = nlp(text)
    entities = [(entity.text, entity.label_) for entity in doc.ents]
    return entities

extracted_text = "Your extracted text here"
entities = extract_entities(extracted_text)
print("pprriinntt", entities)

"""