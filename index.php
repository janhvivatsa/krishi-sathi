<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Smart Crop Advisory</title>
 <link rel="stylesheet" href="css\index.css">

</head>
<body>
  <div class="container">
    <h1>🌱 Smart Crop Advisory System</h1>

    <iframe src="chatbot.php" width="100%" height="400"></iframe>

    <!-- Crop Advisory Form -->
    <form action="advisory.php" method="POST">
      <h2>Get Crop Advisory</h2>
      <label>Crop:</label>
      <input type="text" name="crop" required>

      <label>Soil Type:</label>
      <select name="soilType">
        <option value="loam">Loam</option>
        <option value="clay">Clay</option>
        <option value="sandy">Sandy</option>
      </select>

      <button type="submit">Get Advisory</button>
    </form>

    <!-- Market Price -->
    <form action="market.php" method="GET">
      <h2>Check Market Price</h2>
      <label>Crop:</label>
      <input type="text" name="crop" required>
      <button type="submit">Get Price</button>
    </form>

    <!-- Pest Detection -->
    <form action="pest.php" method="POST" enctype="multipart/form-data">
      <h2>Pest / Disease Detection</h2>
      <label>Upload from gallery or take a photo:</label>
      <input type="file" name="image" accept="image/*" capture="environment" required>
      <button type="submit">Upload & Detect</button>
    </form>
  </div>
</body>
</html>