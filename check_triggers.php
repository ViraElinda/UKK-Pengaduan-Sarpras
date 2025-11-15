<?php
// Direct MySQL connection to check triggers
$mysqli = new mysqli("localhost", "root", "", "pengaduan_sarpras");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Check for triggers
$result = $mysqli->query("SHOW TRIGGERS");

if (!$result) {
    die("Query failed: " . $mysqli->error);
}

if ($result->num_rows == 0) {
    echo "✓ No triggers found in the database.\n";
    echo "The database is clean - no triggers need to be removed.\n";
} else {
    echo "Found " . $result->num_rows . " trigger(s):\n\n";
    while ($trigger = $result->fetch_assoc()) {
        echo "Trigger Name: " . $trigger['Trigger'] . "\n";
        echo "Table: " . $trigger['Table'] . "\n";
        echo "Event: " . $trigger['Event'] . " " . $trigger['Timing'] . "\n";
        echo "Statement: " . $trigger['Statement'] . "\n";
        echo str_repeat("-", 80) . "\n\n";
    }
}

$mysqli->close();
