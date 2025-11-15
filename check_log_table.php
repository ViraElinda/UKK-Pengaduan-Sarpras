<?php
// Direct MySQL connection to check log_pengaduan table
$mysqli = new mysqli("localhost", "root", "", "pengaduan_sarpras");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Check if log_pengaduan table exists
$result = $mysqli->query("SHOW TABLES LIKE 'log_pengaduan'");

if ($result->num_rows == 0) {
    echo "✗ Table 'log_pengaduan' does NOT exist.\n";
    echo "The triggers are trying to insert into a non-existent table.\n";
} else {
    echo "✓ Table 'log_pengaduan' exists.\n\n";
    
    // Show table structure
    $result = $mysqli->query("DESCRIBE log_pengaduan");
    echo "Table structure:\n";
    while ($row = $result->fetch_assoc()) {
        echo "  - " . $row['Field'] . " (" . $row['Type'] . ")\n";
    }
    
    // Show number of records
    $result = $mysqli->query("SELECT COUNT(*) as total FROM log_pengaduan");
    $row = $result->fetch_assoc();
    echo "\nTotal records in log_pengaduan: " . $row['total'] . "\n";
}

$mysqli->close();
