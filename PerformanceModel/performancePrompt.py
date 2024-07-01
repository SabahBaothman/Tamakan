import openai
#from openai import OpenAI
from tenacity import retry, wait_exponential, stop_after_attempt, wait_fixed

# openai.api_key = '??'


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

#question="What is a subnet mask and why is it used in networking?"
#answer="A subnet mask is a 32-bit number that masks an IP address and divides the IP address into network and host addresses. The purpose of a subnet mask is to identify which part of an IP address is the network portion, and which part is the host portion. Using subnet masks allows network administrators to create subnetworks within a larger network, improving the efficiency of routing by reducing traffic congestion and increasing security by isolating network segments. It's a key tool in network design that helps in managing and optimizing network resources."
#prompt = f"From job interview given the candidate's response is: \"{answer}\"\nto the question: \"{question}\"\nprovide a just the score out of 10 based on the Correctness of the response's. give me just the score please\n"
#print(prompt)
#response = call_gpt(prompt)  # Call your GPT function
#print(response)
