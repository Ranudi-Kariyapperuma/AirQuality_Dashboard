<?php
// aqi-data.php

// Database connection
$pdo = new PDO('mysql:host=localhost, dbname=laraveldb', 'root', 'password', [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
]);

// Query the AQI data
$stmt = $pdo->query("SELECT location, aqi_value, measured_at FROM your_aqi_table ORDER BY measured_at ASC");

// Prepare data
$datasets = [];
$colors = ['#4ED47F', '#01BFBC', '#3D246C', '#1C34FC', '#2060B3']; // Add more colors if needed
$colorIndex = 0;

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $label = $row['location'];
    $x = $row['measured_at']; // make sure it's in ISO format: 2025-04-22T18:53:44+00:00
    $y = (int)$row['aqi_value'];

    // Check if this label already exists
    if (!isset($datasets[$label])) {
        $datasets[$label] = [
            'label' => $label,
            'data' => [],
            'borderColor' => $colors[$colorIndex % count($colors)],
            'fill' => false
        ];
        $colorIndex++;
    }

    $datasets[$label]['data'][] = ['x' => $x, 'y' => $y];
}

echo json_encode(array_values($datasets));
?>
