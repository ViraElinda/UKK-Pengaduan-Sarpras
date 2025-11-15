<?php

// Script untuk update foto_balasan di pengaduan ID 160 dengan file yang benar-benar ada

$host = 'localhost';
$dbname = 'pengaduan_sarpras';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "📊 File foto_balasan yang ada di folder:\n";
    $files = [
        'balasan_160_1762587928.jpeg',
        'balasan_160_1762588191.jpg',
        'balasan_160_1762588503.png',
        'balasan_160_1762588749.jpg',
        'balasan_160_1762588987.jpg'
    ];
    
    foreach ($files as $i => $file) {
        echo ($i + 1) . ". $file\n";
    }
    
    echo "\n📝 Menggunakan file terbaru: balasan_160_1762588987.jpg\n\n";
    
    // Update dengan file yang benar-benar ada
    $sql = "UPDATE pengaduan SET foto_balasan = ? WHERE id_pengaduan = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['balasan_160_1762588987.jpg', 160]);
    
    echo "✅ Database updated!\n\n";
    
    // Verify
    $sql = "SELECT id_pengaduan, foto_balasan FROM pengaduan WHERE id_pengaduan = 160";
    $stmt = $pdo->query($sql);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    echo "🔍 Data sekarang:\n";
    echo "ID: " . $result['id_pengaduan'] . "\n";
    echo "Foto Balasan: " . $result['foto_balasan'] . "\n";
    
    // Check file exists
    $filePath = __DIR__ . '/public/uploads/foto_balasan/' . $result['foto_balasan'];
    if (file_exists($filePath)) {
        $fileSize = filesize($filePath);
        echo "✅ File exists! Size: " . number_format($fileSize / 1024, 2) . " KB\n";
    } else {
        echo "❌ File tidak ditemukan di: $filePath\n";
    }
    
    echo "\n✅ Sekarang refresh halaman user detail pengaduan ID 160!\n";
    
} catch (PDOException $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
