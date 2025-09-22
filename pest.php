<?php
if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $targetDir = "uploads/";
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true);
    }
    $fileName = time() . "_" . basename($_FILES['image']['name']);
    $targetFile = $targetDir . $fileName;
    move_uploaded_file($_FILES['image']['tmp_name'], $targetFile);

    // Mock pest detection
    $detections = [
        ["pest" => "Aphids", "advice" => "Spray neem oil or biological control."],
        ["pest" => "Leaf Rust", "advice" => "Remove infected leaves, apply fungicide."],
        ["pest" => "Healthy", "advice" => "No action needed."]
    ];
    $result = $detections[array_rand($detections)];

    echo "<div style='padding:20px; font-family:Arial'>";
    echo "<h2>🔍 Pest Detection Result</h2>";
    echo "<p><strong>Pest:</strong> {$result['pest']}</p>";
    echo "<p><strong>Advice:</strong> {$result['advice']}</p>";
    echo "<p><img src='$targetFile' alt='Uploaded Image' style='max-width:300px; margin-top:10px;'></p>";
    echo "<br><a href='index.php'>⬅ Back</a>";
    echo "</div>";
} else {
    echo "Error uploading file.";
}
?>