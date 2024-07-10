import openai
from tenacity import retry, wait_exponential, stop_after_attempt
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
            f"You are evaluating a student's explanation for a chapter based on the most important points "
            f"from the chapter and the lesson-learning outcomes (LOs). The student’s explanation should be "
            f"thorough, clear, and aligned with the learning outcomes. You will provide a score out of 100, "
            f"short comments justifying the score, and short specific suggestions for improvement.\n\n"
            f"Chapter Summary:\n{slide_summaries}\n\n"
            f"Learning Outcome: {lo}\n\n"
            f"Student Explanation:\n{student_explanation}\n\n"
            f"Evaluation Criteria:\n"
            f"1. Coverage of Key Points: Does the explanation include all the most important points from the chapter?\n"
            f"2. Alignment with Learning Outcomes: Does the explanation reflect an understanding of the lesson-learning outcomes?\n"
            f"3. Clarity and Organization: Is the explanation clear, well-organized, and logically structured?\n"
            f"4. Depth of Understanding: Does the explanation demonstrate a deep understanding of the material?\n"
            f"5. Examples and Applications: Are there relevant examples or applications included to illustrate the points?\n\n"
            f"Provide a score out of 100, comments justifying the score, and specific suggestions for improvement."
        )
        response = call_gpt(prompt)

        if response:
            results.append(response.strip())
        else:
            results.append("An error occurred during evaluation.")

    return results


student_explanation = (
    "A Convolutional Neural Network is a special type of deep neural network designed to process visual data. "
    "It uses convolutional layers with filters that can detect important features like edges and shapes in images. "
    "This helps reduce the number of parameters compared to traditional neural networks. "
    "After the convolutional layers extract features, pooling layers reduce the size of the feature maps, making the network more efficient. "
    "Finally, fully connected layers classify the images based on the extracted features. "
    "Training a CNN involves using back-propagation to adjust the weights and minimize the error. "
    "Despite its advantages, CNNs require large datasets and careful tuning to avoid overfitting, but techniques like data augmentation and dropout can help address these challenges."
)

# Define summarized slides
slide_summaries = (
    "Summary of Slide 1: Ch.6 Deep neural network Ch.9 Convolutional Neural Network (CONVOLUTIONAL NEURAL NETWORK) Ch.10 Deep convolutional neural network (DNN)",
    "Summary of Slide 2: In this article, we look at how deep learning can be used to improve computer vision. We also look at some of the challenges that lie ahead for the next generation of computer vision systems.",
    "Summary of Slide 3: Deep learning (DL) is a subset of machine learning that uses multi-layered neural networks. DL can be either supervised, semi-supervised, or unsupervised. “Deep\" refers to the use of multiple layers in the network.",
    "Summary of Slide 4: A deep neural network (DNN) is an artificial neural network with multiple layers between the input and output layers. It is a type of neural network that can be used to build complex computer programs.",
    "Summary of Slide 5: Deep neural networks are trained in a similar manner to artificial neural networks. They include parameter initialization, feedforward, back-propagation, and feedforward. Deep neural networks can also be used to train other types of networks.",
    "Summary of Slide 6: Fjodor van Veen is an author and professor at the Asimov Institute. He has written several books on the subject of artificial neural networks. His most recent book is called \"The Brain and the Brain\"",
    "Summary of Slide 7: Lack of reasoning. Many training parameters, (such as size: number of layers and number of units per layer, the learning rate, and initial weights). Exploring the parameter space to find the optimal parameters may not be feasible due to the cost in time and computational resources.",
    "Summary of Slide 8: The size of the matrix is equal to the number of pixels in the image here 22 X 16. Images in numbers or the pixel values, denote the intensity or brightness of the pixel. Smaller numbers (closer to zero) represent black, and larger numbers (Closer to 255) denote white.",
    "Summary of Slide 9: In colored images we have three matrices for the three-color channels – Red, Green, and Blue. The three channels are superimposed to form a colored image. In colored images, the three colors are combined to form one image.",
    "Summary of Slide 10: Most common features extraction algorithms: Scale-Invariant Feature Transform (SURF), Histogram of Gradients (HoG), Speeded-Up Robust Features (SIFT). Add on top of this machine learning model for classification, prediction, or recognition. Feature extraction: SIFT, HoG... ML model. Train ML model.",
    "Summary of Slide 11: Build features automatically based on training data. Combine feature extraction and classification. Deep learning model is based on a computer’s vision pipeline. It uses a combination of machine learning and deep learning to build features.",
    "Summary of Slide 12: How many parameters do I need to estimate? 22x16352352109. How many parameters should I use to estimate the number of parameters I need?",
    "Summary of Slide 13: 32X3230723072N Large number. How many parameters I need to estimate? 3072∗10= 30720.",
    "Summary of Slide 14: Convolutional Neural Networks (CNN) are the most popular deep learning architecture in computer vision. The most important feature to classify images is the shape. To extract the shape features we need to extract the edges.","Summary of Slide 15: Convolutions have been used for a long time in image processing to blur and sharpen images. A convolution operation is an element-wise matrix multiplication operation. The output of this is the final convoluted image.",
    "Summary of Slide 16: Sharpening kernel, edge detection kernels, smoothing kernel edges, and smoothing kernel kernels. KERNELS https://www.saama.com/different-kinds-of-convolutional-filters.",
    "Summary of Slide 17: Note: This is element-wise multiplication, not dot product. EDGE DETECTION KERNEL EXAMPLE. Let’s take a 6X6 image of black and gray sections. To extract the edge and lower the dimension 55500055500055500055500055500055500010-110-110-1*=0.",
    "Summary of Slide 18: Let's take a 6X6 image of black and gray sections. To extract the edge and lower the dimension 10-110-110.1*=015555000555000555000555000555000555000.",
    "Summary of Slide 19: Let's take a 6X6 image of black and gray sections. To extract the edge and lower the dimension 10-110-110,110-1*=015150555000555000555000555000555000555000.",
    "Summary of Slide 20: 6X6 Input 555000555000500055 5000555000555555000 5550005555000555550005500055005550004X4 convolved feature. Feature map. 6X6 image of black and gray sections. To extract the edge and lower the dimension 10-110-110.1*=015150015150015 1500151500 151503x3 filter/kernel/feature detector.",
    "Summary of Slide 21: The main building block of CNN is the convolutional layer. The primary purpose of the convolution layer is to extract features from the input. Each convolution filter acts as a detector for a particular feature.",
    "Summary of Slide 22: Performing multiple convolutions on an input using different filters resulting in distinct feature maps. Feature map is the output of a convolutional layer. Features (ACTIVATION) MAP. Feature map is an example of a feature map.",
    "Summary of Slide 23: We stack these up to get a “new image” of size 28x28x6! http://cs231n.stanford.edu/. Convolution Layer Features maps 62828. FOR EXAMPLE, IF WE HAD 6 5X5 FILTERS, WE’LL GET 6 SEPARATE FEATURES MAPS.",
    "Summary of Slide 24: Lecture 7-27 Jan 2016…. 102424. http://cs231n.stanford.edu/. 6 features maps 10 features map. 6 5x5x3 filters 28x28. 6 CONV, ReLU, e.g. 10 5 x5x6 filters CONV.",
    "Summary of Slide 25: Fei-Fei Li & Andrej Karpathy & Justin Johnson will give a lecture on the topic. The lecture will be held in New York City on January 27th. For more information, visit their website: http://www.cnn.com/.",
    "Summary of Slide 26: Either with zeros or the values on the edge. PADDING To maintain the dimension of output as in input, we add padding to the input matrix. => Padding is added to the matrix to maintain the same dimension as in the input.",
    "Summary of Slide 27: Stride specifies how much the convolution filter is moved at each step (by default the value is 1). 7X7 images with 3X3 Filter and 1 Stride will be 5x5.",
    "Summary of Slide 28: 7X7 images with 3X3 Filter and Stride 2. The output will be 3x3. 7X7 with Stride 1 and 2 is 3x2. 7x7 with 2x2 is 4x4. 6x6 with 3x4 is 2x6.",
    "Summary of Slide 29: 7X7 images with 3X3 Filter and Stride 3.0 cannot apply 3x3 filter on 7x7 input with stride 3.5. 7X7 images with Stride 2.0 can apply a 3x2 filter on 7x6 images with stride 2.",
    "Summary of Slide 30: To compute the size of features map: (N + 2P - F) / stride +1. e.g., N = 7, F =3, P = 0: stride 1 => (7 + 0–3)/1 + 1 =5.",
    "Summary of Slide 31: It comes between two convolutional layers to reduce the dimensionality of the feature space. Average Pooling, Max Pooling, and Min Pooling are used in the network. CS231n Convolutional Neural Network.",
    "Summary of Slide 32: A CNN model can be thought of as a combination of two components: feature extraction and classification. The convolution and pooling layers perform feature extraction. The fully connected layers act as a classifier on top of these features.","Summary of Slide 33: Convolutional Networks are made up of only three types of layers: CONV, POOL (we assume Max pool unless stated otherwise), and FC (short for fully-connected).",
    "Summary of Slide 34: The conv layers should use small filters (e.g. 3x3 or at most 5x5) at first, using a stride of S=1. Padding the input volume with zeros to not alter the spatial dimensions of the input. The most common setting is to use max-pooling with 2x2 receptive fields (i.e., F=2).",
    "Summary of Slide 35: CNN is trained the same way as ANN, back-propagation with gradient descent. CNN is trained like ANN in a similar way to the way ANN is trained. CNN training is available on CNN.com for free.",
    "Summary of Slide 36: 4 convolution + pooling layers, followed by 2 fully connected layers. The input is an image of size (150, 150, 3) and the output is binary. Architecture: 4 convolved layers, 2 connected layers, and a dropout.",
    "Summary of Slide 37: CNN.com will feature iReporter photos in a weekly Travel Snapshots gallery. Visit CNN.com/Travel each week for a new gallery of snapshots. Visit http://www.dailymail.co.uk/travel/features/trending-trends-in-travel-pictures.",
    "Summary of Slide 38: Transfer learning is the reuse of a previously learned model on a new problem. The weights of a Neural Network created for a particular problem are used for another such problem. You need a lot of data if you want to train/use CNNs.",
    "Summary of Slide 39: CNN.com will feature iReporter photos in a weekly Travel Snapshots gallery. Please submit your best shots of the U.S. for next week. Visit CNN.com/Travel next Wednesday for a new gallery.",
    "Summary of Slide 40: Freeze layers so they do not change during training. Add new trainable layers. Train the new layers on the dataset with a large learning rate. Improve the model via fine-tuning the pre-trained model.",
    "Summary of Slide 41: Training from scratch can work just as well as training from a pre-trained model for object detection. But it takes 2-3x as long to train. Collecting more data is better than fine-tuning on a related task."
)

# Define Learning Objectives (LOs)
LOs = [
    "LO1: Understand the basic structure and components of a Convolutional Neural Network.",
    "LO2: Explain the role of convolutional layers in feature extraction.",
    #"LO3: Describe the purpose of pooling layers and how they reduce dimensionality.",
    #"LO4: Illustrate the process of training a CNN, including the use of back-propagation.",
    #"LO5: Identify common challenges in training CNNs and the techniques to mitigate these challenges."
]

evaluate_with_gpt(slide_summaries, student_explanation, LOs)

print(evaluate_with_gpt)
