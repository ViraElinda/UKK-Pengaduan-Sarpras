<?php

echo "🔍 Testing Notification & Foto Balasan Issues\n\n";

try {
    $db = new mysqli('localhost', 'root', '', 'pengaduan_sarpras');
    
    if ($db->connect_error) {
        die("Connection failed: " . $db->connect_error);
    }
    
    echo "=== 1. NOTIFICATION TABLE CHECK ===\n";
    $result = $db->query("SELECT COUNT(*) as total FROM notif");
    $total = $result->fetch_assoc()['total'];
    echo "✅ Total notifications: $total\n";
    
    $unread = $db->query("SELECT COUNT(*) as unread FROM notif WHERE is_read = 0")->fetch_assoc()['unread'];
    echo "📬 Unread notifications: $unread\n\n";
    
    echo "=== 2. SAMPLE NOTIFICATIONS ===\n";
    $samples = $db->query("SELECT id_notif, id_user, judul, pesan, is_read, created_at FROM notif ORDER BY created_at DESC LIMIT 3");
    while ($row = $samples->fetch_assoc()) {
        echo "\nID: {$row['id_notif']}\n";
        echo "User: {$row['id_user']}\n";
        echo "Judul: {$row['judul']}\n";
        echo "Status: " . ($row['is_read'] ? '✅ Read' : '🔔 Unread') . "\n";
        echo "Time: {$row['created_at']}\n";
    }
    
    echo "\n\n=== 3. FOTO BALASAN DIRECTORY CHECK ===\n";
    $balasanDir = __DIR__ . '/public/uploads/foto_balasan/';
    if (!is_dir($balasanDir)) {
        echo "❌ Directory NOT found: $balasanDir\n";
        echo "Creating directory...\n";
        if (mkdir($balasanDir, 0755, true)) {
            echo "✅ Directory created successfully\n";
        } else {
            echo "❌ Failed to create directory\n";
        }
    } else {
        echo "✅ Directory exists: $balasanDir\n";
        $files = glob($balasanDir . '*');
        echo "📁 Total files: " . count($files) . "\n";
        if (count($files) > 0) {
            echo "\nSample files:\n";
            foreach (array_slice($files, 0, 5) as $file) {
                $size = filesize($file);
                echo "  - " . basename($file) . " (" . round($size/1024, 2) . " KB)\n";
            }
        }
    }
    
    echo "\n\n=== 4. PENGADUAN WITH FOTO BALASAN ===\n";
    $result = $db->query("
        SELECT id_pengaduan, nama_pengaduan, foto_balasan, status, saran_petugas
        FROM pengaduan 
        WHERE foto_balasan IS NOT NULL AND foto_balasan != ''
        ORDER BY tgl_pengajuan DESC
        LIMIT 3
    ");
    
    if ($result && $result->num_rows > 0) {
        echo "✅ Found " . $result->num_rows . " pengaduan with foto_balasan:\n";
        while ($row = $result->fetch_assoc()) {
            echo "\nID: {$row['id_pengaduan']}\n";
            echo "Nama Pengaduan: " . substr($row['nama_pengaduan'], 0, 50) . "\n";
            echo "Status: {$row['status']}\n";
            echo "Foto Balasan: {$row['foto_balasan']}\n";
            
            $filePath = $balasanDir . $row['foto_balasan'];
            if (is_file($filePath)) {
                echo "  ✅ File exists (" . round(filesize($filePath)/1024, 2) . " KB)\n";
            } else {
                echo "  ❌ File NOT FOUND on disk\n";
            }
        }
    } else {
        echo "⚠️ No pengaduan with foto_balasan found\n";
    }
    
    echo "\n\n=== 5. CHECK PETUGAS RESPONSES ===\n";
    $result = $db->query("
        SELECT COUNT(*) as total 
        FROM pengaduan 
        WHERE saran_petugas IS NOT NULL 
        AND saran_petugas != ''
    ");
    $totalResponses = $result->fetch_assoc()['total'];
    echo "✅ Total petugas responses: $totalResponses\n";
    
    $withPhotos = $db->query("
        SELECT COUNT(*) as total 
        FROM pengaduan 
        WHERE saran_petugas IS NOT NULL 
        AND foto_balasan IS NOT NULL 
        AND foto_balasan != ''
    ")->fetch_assoc()['total'];
    echo "📸 Responses with photos: $withPhotos\n";
    
    $withoutPhotos = $totalResponses - $withPhotos;
    echo "📝 Responses without photos: $withoutPhotos\n";
    
    $db->close();
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
