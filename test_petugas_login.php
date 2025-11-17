<?php

// Simple database connection
$host = 'localhost';
$dbname = 'pengaduan_sarpras';
$username = 'root';
$password = '';

try {
    $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "=== TEST PETUGAS LOGIN ===\n\n";
    
    // 1. Cek user dengan role petugas
    echo "1. Checking users with role 'petugas':\n";
    $stmt = $db->query("SELECT id_user, username, nama_pengguna, role FROM user WHERE role = 'petugas'");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (empty($users)) {
        echo "   ❌ No petugas users found!\n";
        exit(1);
    }
    
    foreach ($users as $user) {
        echo "   ✅ User ID: {$user['id_user']}, Username: {$user['username']}, Nama: {$user['nama_pengguna']}\n";
    }
    
    echo "\n2. Checking petugas table for these users:\n";
    
    // 2. Cek data di tabel petugas
    foreach ($users as $user) {
        $stmt = $db->prepare("SELECT * FROM petugas WHERE id_user = ?");
        $stmt->execute([$user['id_user']]);
        $petugas = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($petugas) {
            echo "   ✅ ID User {$user['id_user']} exists in petugas table (ID Petugas: {$petugas['id_petugas']}, Nama: {$petugas['nama']})\n";
        } else {
            echo "   ❌ ID User {$user['id_user']} NOT found in petugas table!\n";
        }
    }
    
    echo "\n3. Checking petugas table structure:\n";
    $stmt = $db->query("DESCRIBE petugas");
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "   Columns: ";
    $hasDeletedAt = false;
    foreach ($columns as $col) {
        echo $col['Field'] . ", ";
        if ($col['Field'] === 'deleted_at') {
            $hasDeletedAt = true;
        }
    }
    echo "\n";
    
    if ($hasDeletedAt) {
        echo "   ⚠️ WARNING: Table has 'deleted_at' column!\n";
    } else {
        echo "   ✅ Table does NOT have 'deleted_at' column (correct!)\n";
    }
    
    echo "\n=== TEST COMPLETE ===\n";
    echo "If all checks passed, login should work.\n";
    echo "Try logging in at: http://localhost:8080/auth/login\n";
    
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage() . "\n";
    exit(1);
}
