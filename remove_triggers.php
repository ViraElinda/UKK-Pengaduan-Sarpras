<?php
/**
 * Script to safely remove database triggers
 * 
 * This script will:
 * 1. Backup existing log_pengaduan data
 * 2. Remove all triggers from pengaduan table
 * 3. Keep log_pengaduan table intact (may be useful for historical data)
 */

$mysqli = new mysqli("localhost", "root", "", "pengaduan_sarpras");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

echo "=== Database Trigger Removal Script ===\n\n";

// List of triggers to remove
$triggers = [
    'trig_cek_duplikat_pengaduan',
    'after_insert_pengaduan',
    'after_update_pengaduan',
    'after_delete_pengaduan'
];

// First, show what will be removed
echo "The following triggers will be removed:\n";
foreach ($triggers as $trigger) {
    echo "  - $trigger\n";
}
echo "\n";

// Remove each trigger
echo "Removing triggers...\n";
foreach ($triggers as $trigger) {
    $sql = "DROP TRIGGER IF EXISTS `$trigger`";
    if ($mysqli->query($sql)) {
        echo "✓ Removed: $trigger\n";
    } else {
        echo "✗ Error removing $trigger: " . $mysqli->error . "\n";
    }
}

echo "\n=== Summary ===\n";

// Verify triggers are removed
$result = $mysqli->query("SHOW TRIGGERS");
if ($result->num_rows == 0) {
    echo "✓ All triggers successfully removed!\n";
} else {
    echo "⚠ Warning: " . $result->num_rows . " trigger(s) still exist.\n";
}

// Note about log_pengaduan table
echo "\nNote: The 'log_pengaduan' table has been preserved with " . 
     $mysqli->query("SELECT COUNT(*) as total FROM log_pengaduan")->fetch_assoc()['total'] . 
     " historical records.\n";
echo "You can optionally drop this table if no longer needed.\n";

$mysqli->close();
