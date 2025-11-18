<?php

try {
    $db = new mysqli('localhost', 'root', '', 'pengaduan_sarpras');
    
    if ($db->connect_error) {
        die("Connection failed: " . $db->connect_error);
    }
    
    echo "🔍 Checking notif/notifikasi table...\n\n";
    
    // Check for 'notif' table
    $result = $db->query("SHOW TABLES LIKE 'notif'");
    if ($result && $result->num_rows > 0) {
        echo "✅ Table 'notif' exists\n";
        
        // Show structure
        $cols = $db->query("DESCRIBE notif");
        echo "\n📋 Structure of 'notif' table:\n";
        while ($col = $cols->fetch_assoc()) {
            echo "  - {$col['Field']}: {$col['Type']} ({$col['Null']}, {$col['Key']})\n";
        }
        
        // Count records
        $count = $db->query("SELECT COUNT(*) as total FROM notif")->fetch_assoc()['total'];
        echo "\n📊 Total records: $count\n";
        
        if ($count > 0) {
            echo "\n🔍 Sample records:\n";
            $samples = $db->query("SELECT * FROM notif ORDER BY created_at DESC LIMIT 3");
            while ($row = $samples->fetch_assoc()) {
                echo "\n  ID: {$row['id_notif']}\n";
                echo "  User ID: {$row['id_user']}\n";
                echo "  Judul: {$row['judul']}\n";
                echo "  Pesan: {$row['pesan']}\n";
                echo "  Tipe: {$row['tipe']}\n";
                echo "  Read: " . ($row['is_read'] ? 'Yes' : 'No') . "\n";
                echo "  Created: {$row['created_at']}\n";
            }
        }
    } else {
        echo "❌ Table 'notif' NOT FOUND\n";
        
        // Check for 'notifikasi' table
        $result2 = $db->query("SHOW TABLES LIKE 'notifikasi'");
        if ($result2 && $result2->num_rows > 0) {
            echo "✅ Table 'notifikasi' exists instead\n";
        } else {
            echo "❌ Table 'notifikasi' also NOT FOUND\n";
            echo "\n⚠️ Notifikasi table is missing! Need to create it.\n";
        }
    }
    
    $db->close();
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
