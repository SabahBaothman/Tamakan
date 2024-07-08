import PyPDF2
from transformers import PegasusForConditionalGeneration, PegasusTokenizer
from transformers import pipeline
import spacy

def extract_text_from_pdf(pdf_path, firstslide, lastslide):
    with open(pdf_path, 'rb') as file:
        reader = PyPDF2.PdfReader(file)
        slides = []
        for page_num in range(firstslide - 1, lastslide):
            page = reader.pages[page_num]
            text = page.extract_text()
            slides.append(text)
    return slides

def summarize_text(text, model, tokenizer):
    inputs = tokenizer(text, truncation=True, padding="longest", return_tensors="pt")
    summary_ids = model.generate(inputs["input_ids"], max_length=150, min_length=40, length_penalty=2.0, num_beams=4, early_stopping=True)
    return tokenizer.decode(summary_ids[0], skip_special_tokens=True)

def summarize(pdf_path, firstslide, lastslide):
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

    # Print summaries
    for i, summary in enumerate(summaries, 1):
        print(f"Summary of Slide {i}:\n{summary}\n")

def summaries_from_pdf(pdf_path, firstslide, lastslide):
    slides_text = extract_text_from_pdf(pdf_path, firstslide, lastslide)

    # Initialize the PEGASUS model and tokenizer
    model_name = "google/pegasus-xsum"
    tokenizer = PegasusTokenizer.from_pretrained(model_name)
    model = PegasusForConditionalGeneration.from_pretrained(model_name)

    # Summarize each slide
    summaries = []
    for slide_text in slides_text:
        if slide_text.strip():  # Check if the slide is not empty
            summary = summarize_text(slide_text, model, tokenizer)
            summaries.append(summary)

    # Print summaries
    for i, summary in enumerate(summaries, 1):
        print(f"Summary of Slide {i}:\n{summary}\n")

    return ' '.join(summaries)

# Example usage
pdf_path = 'C:\\Users\\hadee\\Downloads\\tm\\Tamakan\\uploads\\CPCS433_Deep_learning_Network_Convolutional_Neural_Networks.pdf'
firstslide = 1
lastslide = 3
summaries = summarize(pdf_path, firstslide, lastslide)
print("Combined Summaries:\n", summaries)
