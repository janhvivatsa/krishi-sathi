<?php
$crop = strtolower($_GET['crop'] ?? 'wheat');

// Mock data for multiple mandi prices
$mandi_prices = [
    'delhi' => ['wheat' => 2100, 'rice' => 2650, 'maize' => 1900],
    'lucknow' => ['wheat' => 2150, 'rice' => 2600, 'maize' => 1950],
    'kanpur' => ['wheat' => 2080, 'rice' => 2620, 'maize' => 1920]
];

// Minimum Support Price (MSP)
$msp = [
    'wheat' => 2100,
    'rice' => 2320,
    'maize' => 1850
];

// Price trend for past 7 days (mock data)
$price_trends = [
    'wheat' => [2080, 2100, 2110, 2130, 2150, 2140, 2150],
    'rice' => [2550, 2560, 2580, 2600, 2610, 2640, 2650],
    'maize' => [1850, 1870, 1860, 1880, 1900, 1910, 1900]
];

// Demand & Supply info
$demand_supply = [
    'wheat' => "High demand this week",
    'rice' => "Moderate demand",
    'maize' => "Low arrival in mandis - prices may rise"
];

// Nearby mandi details
$mandi_details = [
    'delhi' => [
        'distance' => '15 km',
        'contact' => '+91 9876543210',
        'hours' => '9 AM to 6 PM'
    ],
    'lucknow' => [
        'distance' => '80 km',
        'contact' => '+91 9123456789',
        'hours' => '8 AM to 5 PM'
    ],
    'kanpur' => [
        'distance' => '70 km',
        'contact' => '+91 9112233445',
        'hours' => '8:30 AM to 5:30 PM'
    ]
];

// Quality/Grade-wise Prices
$grade_prices = [
    'wheat' => [
        'Grade A' => 2200,
        'Grade B' => 2000
    ],
    'rice' => [
        'Grade A' => 2700,
        'Grade B' => 2500
    ],
    'maize' => [
        'Grade A' => 1950,
        'Grade B' => 1800
    ]
];

// Export/Wholesale prices
$export_prices = [
    'wheat' => 2250,
    'rice' => 2750,
    'maize' => 2000
];

// Alerts & Notifications
$alerts = [
    'wheat' => "⚠ Prices expected to rise due to rain forecast",
    'rice' => "📢 Government announced MSP hike",
    'maize' => "No alerts"
];

// Filter mandis for the selected crop
$available_mandis = array_filter($mandi_prices, function($prices) use ($crop) {
    return isset($prices[$crop]);
});
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Market Prices for <?php echo htmlspecialchars($crop); ?></title>
<style>
    body {
        background-color: #d4edda;
        font-family: Arial, sans-serif;
        color: #155724;
        padding: 20px;
    }
    h2 {
        border-bottom: 2px solid #155724;
        padding-bottom: 5px;
    }
    .section {
        margin-bottom: 25px;
    }
    ul {
        list-style: none;
        padding-left: 0;
    }
    li {
        margin-bottom: 6px;
    }
</style>
</head>
<body>

<h2>💹 Market Price Comparison for <?php echo htmlspecialchars($crop); ?></h2>

<div class="section">
    <h3>1. Multiple Market Prices</h3>
    <ul>
    <?php foreach ($available_mandis as $mandi => $prices): ?>
        <li><?php echo ucfirst($mandi); ?> Mandi – ₹<?php echo $prices[$crop]; ?> per quintal</li>
    <?php endforeach; ?>
    </ul>
</div>

<div class="section">
    <h3>2. Price Trends (Last 7 days)</h3>
    <canvas id="priceTrendChart" width="600" height="300"></canvas>
</div>

<div class="section">
    <h3>3. Minimum Support Price (MSP)</h3>
    <p>₹<?php echo $msp[$crop] ?? 'N/A'; ?> per quintal</p>
</div>

<div class="section">
    <h3>4. Demand & Supply Info</h3>
    <p><?php echo $demand_supply[$crop] ?? 'No data'; ?></p>
</div>

<div class="section">
    <h3>5. Nearby Mandi Details</h3>
    <ul>
        <?php foreach ($available_mandis as $mandi => $prices): ?>
            <li><strong><?php echo ucfirst($mandi); ?> Mandi</strong>: Distance - <?php echo $mandi_details[$mandi]['distance']; ?>, Contact - <?php echo $mandi_details[$mandi]['contact']; ?>, Hours - <?php echo $mandi_details[$mandi]['hours']; ?></li>
        <?php endforeach; ?>
    </ul>
</div>

<div class="section">
    <h3>6. Quality/Grade-wise Prices</h3>
    <ul>
        <?php foreach ($grade_prices[$crop] ?? [] as $grade => $price): ?>
            <li><?php echo $grade; ?>: ₹<?php echo $price; ?> per quintal</li>
        <?php endforeach; ?>
    </ul>
</div>

<div class="section">
    <h3>7. Export/Wholesale Prices</h3>
    <p>₹<?php echo $export_prices[$crop] ?? 'N/A'; ?> per quintal</p>
</div>

<div class="section">
    <h3>8. Alerts & Notifications</h3>
    <p><?php echo $alerts[$crop] ?? 'No alerts'; ?></p>
</div>

<a href="index.php">⬅ Back</a>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('priceTrendChart').getContext('2d');
    const priceData = <?php echo json_encode($price_trends[$crop] ?? []); ?>;
    const labels = ['Day -6', 'Day -5', 'Day -4', 'Day -3', 'Day -2', 'Day -1', 'Today'];
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Price Trend (₹/quintal)',
                data: priceData,
                borderColor: '#155724',
                fill: false,
                tension: 0.3
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: false
                }
            }
        }
    });
</script>

</body>
</html>