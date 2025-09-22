<?php
// Database connection
$host = "localhost";
$user = "root";
$pass = "Aditi007#";
$dbname = "crop_advisory";

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get user message
$userMessage = strtolower($_POST['message'] ?? "");
$selectedLang = $_POST['lang'] ?? "en-US"; // Default English
$reply = "Welcome, how can i help you?";

// Determine which column to use based on language
$column = $selectedLang === "kn-IN" ? "response_kn" : "response_en";

// Fetch response from DB
if ($userMessage != "") {
    $sql = "SELECT $column FROM chatbot WHERE ? LIKE CONCAT('%', keyword, '%') LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $userMessage);
    $stmt->execute();
    $stmt->bind_result($response);

    if ($stmt->fetch()) {
        $reply = $response;
    }
    $stmt->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Talking PHP Chatbot</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; background: #f8f9fa; }
        .chatbox { width: 500px; margin: auto; border: 1px solid #ccc; padding: 10px; background: #fff; }
        .user { color: blue; margin: 5px 0; }
        .bot { color: green; margin: 5px 0; }
        input[type=text] { width: 70%; padding: 5px; }
        button { padding: 6px 12px; }
        select { padding: 5px; margin-bottom: 10px; }
    </style>
</head>
<body>
<div class="chatbox">
    <h2>Smart Crop Advisor Chatbot (English/Kannada)</h2>

    <form method="POST">
        <label>Select Language for Speech:</label>
        <select name="lang">
            <option value="en-US" <?= $selectedLang === "en-US" ? "selected" : "" ?>>English</option>
            <option value="kn-IN" <?= $selectedLang === "kn-IN" ? "selected" : "" ?>>Kannada</option>
        </select>

        <?php if ($userMessage): ?>
            <p class="user"><b>You:</b> <?= htmlspecialchars($userMessage) ?></p>
            <p class="bot"><b>Bot:</b> <?= htmlspecialchars($reply) ?></p>
        <?php endif; ?>

        <input type="text" name="message" placeholder="Type your question..." required>
        <button type="submit">Send</button>
    </form>
</div>

<script>
// Get bot message
const botMessage = "<?php echo addslashes($reply); ?>";

if (botMessage.trim() !== "") {
    const langSelect = document.querySelector('select[name="lang"]');
    const msg = new SpeechSynthesisUtterance();
    msg.text = botMessage;
    msg.lang = langSelect.value;
    window.speechSynthesis.speak(msg);
}
</script>
</body>
</html>