import os
import io
import numpy as np
import tensorflow as tf
from PIL import Image
from flask import Flask, request, jsonify
from flask_cors import CORS

# Suppress TensorFlow informational messages
os.environ['TF_CPP_MIN_LOG_LEVEL'] = '1'

# initializing flask
app = Flask(__name__)
CORS(app)

# loading model and class names
print("Loading trained model...")
model = tf.keras.models.load_model('best_model.h5')

class_names = [
    'Apple_Apple_scab',
    'Apple_Black_rot',
    'Apple_Cedar_apple_rust',
    'Apple_healthy',
    'Blueberry_healthy',
    'Cherry_(including_sour)___healthy',
    'Cherry_(including_sour)___Powdery_mildew',
    'Corn_(maize)___Cercospora_leaf_spot Gray_leaf_spot',
    'Corn_(maize)___Common_rust_',
    'Corn_(maize)___healthy',
    'Corn_(maize)___Northern_Leaf_Blight',
    'Grape___Black_rot',
    'Grape___Esca_(Black_Measles)',
    'Grape___healthy',
    'Grape___Leaf_blight_(Isariopsis_Leaf_Spot)',
    'Orange___Haunglongbing_(Citrus_greening)',
    'Peach___Bacterial_spot',
    'Peach___healthy',
    'Pepper,_bell___Bacterial_spot',
    'Pepper,_bell___healthy',
    'Potato___Early_blight',
    'Potato___healthy',
    'Potato___Late_blight',
    'Raspberry___healthy',
    'Soybean___healthy',
    'Squash___Powdery_mildew',
    'Strawberry___healthy',
    'Strawberry___Leaf_scorch',
    'Tomato___Bacterial_spot',
    'Tomato___Early_blight',
    'Tomato___healthy',
    'Tomato___Late_blight',
    'Tomato___Leaf_Mold',
    'Tomato___Septoria_leaf_spot',
    'Tomato___Spider_mites Two-spotted_spider_mite',
    'Tomato___Target_Spot',
    'Tomato___Tomato_mosaic_virus',
    'Tomato___Tomato_Yellow_Leaf_Curl_Virus'
]

# image preprocessing
def preprocess_image(image_bytes):
    """
    Preprocesses the image to the format the model expects.
    - Opens the image from bytes
    - Resizes it to 224x224 pixels
    - Converts it to a NumPy array
    - Adds a batch dimension
    """
    img = Image.open(io.BytesIO(image_bytes)).convert('RGB')
    img = img.resize((224, 224))
    img_array = tf.keras.utils.img_to_array(img)
    img_array = np.expand_dims(img_array, axis=0) # Create a batch
    return img_array

# api endpoint for prediction
@app.route('/predict', methods=['POST'])
def predict():
    """
    Handles the POST request with an image file and returns the prediction.
    """
    # Check if a file was sent
    if 'file' not in request.files:
        return jsonify({'error': 'no file provided'}), 400

    file = request.files['file']

    # Check if the file is empty
    if file.filename == '':
        return jsonify({'error': 'no file selected'}), 400

    try:
        # Read the image file as bytes
        image_bytes = file.read()

        # Preprocess the image and get a prediction
        processed_image = preprocess_image(image_bytes)
        prediction = model.predict(processed_image)
        
        # Get the class name with the highest score
        predicted_class_index = np.argmax(prediction)
        predicted_class_name = class_names[predicted_class_index]
        confidence = float(np.max(prediction))

        # Return the result as JSON
        return jsonify({
            'predicted_disease': predicted_class_name,
            'confidence': confidence
        })

    except Exception as e:
        return jsonify({'error': f'error processing file: {e}'}), 500

if __name__ == '__main__':

    app.run(debug=True, port=5000)