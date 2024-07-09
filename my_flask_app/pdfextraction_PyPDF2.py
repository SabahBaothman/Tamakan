import PyPDF2
from transformers import pipeline

def extract_text_from_pdf(pdf_path, firstslide, lastslide):
    with open(pdf_path, 'rb') as file:
        reader = PyPDF2.PdfReader(file)
        slides = []
        for page_num in range(firstslide - 1, lastslide):
            page = reader.pages[page_num]
            text = page.extract_text()
            slides.append(text)
    return slides

def summaries_from_pdf(pdf_path, firstslide, lastslide):
    # Example usage
    slides_text = extract_text_from_pdf(pdf_path, firstslide, lastslide)

    # Initialize the summarization pipeline
    summarizer = pipeline("summarization", model="facebook/bart-large-cnn")

    # Summarize each slide
    summaries = []
    for slide_text in slides_text:
        if slide_text.strip():  # Check if the slide is not empty
            summary = summarizer(slide_text, max_length=150, min_length=40, do_sample=False)
            summaries.append(summary[0]['summary_text'])

    # Format summaries
    formatted_summaries = ""
    for i, summary in enumerate(summaries, 1):
        formatted_summaries += f"Summary of Slide {i}:\n{summary}\n\n"

    print (formatted_summaries)
    
    return formatted_summaries
    
    
    #return ' '.join(summaries)
