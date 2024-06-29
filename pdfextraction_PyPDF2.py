import PyPDF2

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
