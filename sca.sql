-- 1️⃣ Create Database
CREATE DATABASE IF NOT EXISTS crop_advisory;
USE crop_advisory;

-- 2️⃣ Create Chatbot Table
CREATE TABLE IF NOT EXISTS chatbot (
    id INT AUTO_INCREMENT PRIMARY KEY,
    keyword VARCHAR(100) NOT NULL,
    response_en TEXT NOT NULL,
    response_kn TEXT NOT NULL
);

-- 3️⃣ Insert Sample Data
INSERT INTO chatbot (keyword, response_en, response_kn) VALUES
('hi', 'Hello farmer! How can I help you today?', 'ನಮಸ್ಕಾರ! ನಾನು ನಿಮ್ಮ ಕೃಷಿ ಸಲಹೆಗಾರನಿದ್ದೇನೆ. ಹೇಗೆ ಸಹಾಯ ಮಾಡಬಹುದು?'),
('hello', 'Hi there! What crop advice do you need?', 'ಹಾಯ್! ನಿಮಗೆ ಯಾವ ಬೆಳೆಯ ಸಲಹೆ ಬೇಕಾಗಿದೆ?'),
('crop', 'You can grow wheat, rice, or maize depending on soil and weather.', 'ನೀವು ಹವಾಮಾನ ಮತ್ತು ಮಣ್ಣು ಅವಲಂಬಿಸಿ ಗೋಧಿ, ಅಕ್ಕಿ ಅಥವಾ ಜೋಳ ಬೆಳೆಯಬಹುದು.'),
('fertilizer', 'Apply urea, DAP, or organic compost depending on your soil test results.', 'ನಿಮ್ಮ ಮಣ್ಣು ಪರೀಕ್ಷೆಯ ಫಲಿತಾಂಶದ ಪ್ರಕಾರ ಯುರಿಯಾ, ಡಿಎಪಿ ಅಥವಾ אורಗ್ಯಾನಿಕ್ ಕಾಂಪೋಸ್ಟ್ ಬಳಸಿ.'),
('pest', 'Upload a pest image or use neem-based organic spray for common infestations.', 'ಸಾಧಾರಣ ಹಾನಿ ಮಾಡುವ ಕೀಟಗಳಿಗೆ ಹಸಿರು ನೀಮ್ ಆಧಾರಿತ ಸ್ಪ್ರೇ ಅಥವಾ ಹಾನಿ ಮಾಡುವ ಕೀಟದ ಚಿತ್ರ ಅಪ್ಲೋಡ್ ಮಾಡಿ.'),
('market', 'Today’s mandi price for wheat is ₹2200/quintal.', 'ಇಂದು ಗೋಧಿಯ ಮಾರುಕಟ್ಟೆ ಬೆಲೆ ₹2200/ಕುಂಟಲ್.'),
('bye', 'Goodbye! Wishing you good harvests!', 'ವಿದಾಯ! ಉತ್ತಮ ಬಿತ್ತನೆಗೆ ಶುಭವಾಗಲಿ!');

-- 4️⃣ Optional: View Table
SELECT * FROM chatbot;