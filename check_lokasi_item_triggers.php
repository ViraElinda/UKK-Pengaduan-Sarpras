<?php
// Check for existing delete confirmations in lokasi and item views
$mysqli = new mysqli("localhost", "root", "", "pengaduan_sarpras");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Check triggers on lokasi table
echo "=== Triggers on 'lokasi' table ===\n";
$result = $mysqli->query("SHOW TRIGGERS WHERE `Table` = 'lokasi'");
if ($result->num_rows == 0) {
    echo "✓ No triggers found\n";
} else {
    while ($trigger = $result->fetch_assoc()) {
        echo "- " . $trigger['Trigger'] . " (" . $trigger['Timing'] . " " . $trigger['Event'] . ")\n";
    }
}

echo "\n=== Triggers on 'item' table ===\n";
$result = $mysqli->query("SHOW TRIGGERS WHERE `Table` = 'item'");
if ($result->num_rows == 0) {
    echo "✓ No triggers found\n";
} else {
    while ($trigger = $result->fetch_assoc()) {
        echo "- " . $trigger['Trigger'] . " (" . $trigger['Timing'] . " " . $trigger['Event'] . ")\n";
    }
}

$mysqli->close();
