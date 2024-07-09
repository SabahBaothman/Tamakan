import openai
#from openai import OpenAI
from tenacity import retry, wait_exponential, stop_after_attempt, wait_fixed

# OpenAI API key
openai.api_key = 'sk-proj-ICuOpnqJgu2aGoKrDzacT3BlbkFJmCsf03Bc68Elugkxllmn'

# Function to call GPT-4 with retries
@retry(wait=wait_exponential(multiplier=1, min=2, max=10), stop=stop_after_attempt(100))
def call_gpt(prompt, model_engine="gpt-4-turbo"):
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


