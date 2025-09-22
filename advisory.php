<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>CROP DETAILS</title>
 <link rel="stylesheet" href="css\advisory.css">

</head>
<?php
$soilType = $_POST['soilType'] ?? 'loam';
$crop = $_POST['crop'] ?? 'wheat';

// Mock fertilizer recommendations
$recommendations = [
    "loam" => "Apply N:80kg/ha, P:40kg/ha, K:40kg/ha",
    "clay" => "Apply N:60kg/ha, P:50kg/ha, K:60kg/ha",
    "sandy" => "Apply N:100kg/ha, P:20kg/ha, K:30kg/ha"
];

// Crop specific data simulation
$cropDetails = [
    "wheat" => [
        "duration" => "120 days",
        "season" => "November to April",
        "waterRequirement" => "450-650 mm during growing season",
        "seedVarieties" => "HD 2967, PBW 343"
    ],
    // Add other crops here
];

// Soil health
$soilHealth = [
    "loam" => [
        "pH" => "6.0-7.5",
        "organicManure" => "Apply well decomposed FYM at 4 tons/ha",
        "preparation" => "Plough twice, followed by harrowing and leveling"
    ],
    // Add other soils here
];

// Weather alert simulation
$weatherAlert = (rand(1, 10) > 8) ? "⚠ Heavy rains expected. Delay fertilizer application." : "No weather alerts.";

// Pest & disease management
$pestDisease = [
    "wheat" => [
        "commonPests" => "Aphids, Armyworm",
        "symptoms" => "Yellowing leaves, defoliation",
        "control" => "Use neem oil spray or recommended chemical pesticides"
    ]
];

// Fertilizer & nutrients
$fertilizerDetails = [
    "wheat" => "Apply nitrogen in three stages: sowing, tillering, and booting. Zinc and sulfur recommended as micronutrients."
];

// Irrigation
$irrigationSchedule = [
    "wheat" => [
        "criticalStages" => "Tillering, flowering, grain filling",
        "methods" => "Flood irrigation recommended"
    ]
];


// Government schemes (mock)
$govSchemes = "PMFBY crop insurance available; fertilizer subsidies apply in this state.";

// Farmer tips
$farmerTips = "Intercrop wheat with mustard; practice weed removal every 15 days; store grains in cool dry place post-harvest.";

// Prepare output
$fDetails = $recommendations[$soilType] ?? $recommendations["loam"];
$cDetails = $cropDetails[$crop] ?? [];
$sHealth = $soilHealth[$soilType] ?? [];
$pestInfo = $pestDisease[$crop] ?? [];
$fertDetail = $fertilizerDetails[$crop] ?? "";
$irrigate = $irrigationSchedule[$crop] ?? [];
$price = $marketPrice[$crop] ?? "";
$cost = $costEst[$crop] ?? "";

echo "<div style='padding:20px; font-family:Arial'>";
echo "<h2>🌱 Crop Advisory for " . ucfirst($crop) . "</h2>";
echo "<p><strong>Soil Type:</strong> $soilType</p>";
echo "<p><strong>Fertilizer Recommendation:</strong> $fDetails</p>";
echo "<p><strong>Crop Duration:</strong> " . ($cDetails["duration"] ?? "N/A") . "</p>";
echo "<p><strong>Sowing/Harvesting Season:</strong> " . ($cDetails["season"] ?? "N/A") . "</p>";
echo "<p><strong>Water Requirement:</strong> " . ($cDetails["waterRequirement"] ?? "N/A") . "</p>";
echo "<p><strong>Recommended Seed Varieties:</strong> " . ($cDetails["seedVarieties"] ?? "N/A") . "</p>";
echo "<p><strong>Soil pH Required:</strong> " . ($sHealth["pH"] ?? "N/A") . "</p>";
echo "<p><strong>Organic Manure Recommendation:</strong> " . ($sHealth["organicManure"] ?? "N/A") . "</p>";
echo "<p><strong>Land Preparation Steps:</strong> " . ($sHealth["preparation"] ?? "N/A") . "</p>";
echo "<p><strong>Weather Alert:</strong> $weatherAlert</p>";
echo "<h3>Pest & Disease Management</h3>";
echo "<p><strong>Common Pests:</strong> " . ($pestInfo["commonPests"] ?? "N/A") . "</p>";
echo "<p><strong>Early Detection Symptoms:</strong> " . ($pestInfo["symptoms"] ?? "N/A") . "</p>";
echo "<p><strong>Control Methods:</strong> " . ($pestInfo["control"] ?? "N/A") . "</p>";
echo "<h3>Fertilizer & Nutrient Management</h3>";
echo "<p>$fertDetail</p>";
echo "<h3>Irrigation Schedule</h3>";
echo "<p><strong>Critical Stages:</strong> " . ($irrigate["criticalStages"] ?? "N/A") . "</p>";
echo "<p><strong>Recommended Method:</strong> " . ($irrigate["methods"] ?? "N/A") . "</p>";
echo "<h3>Government Schemes & Subsidies</h3>";
echo "<p>$govSchemes</p>";
echo "<h3>Farmer Tips</h3>";
echo "<p>$farmerTips</p>";
echo "<br><a href='index.php'>⬅ Back</a>";
echo "</div>";
?>