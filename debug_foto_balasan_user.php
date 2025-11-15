<?php
/**
 * Debug script - Cek apakah foto_balasan masuk ke controller user
 */

try {
    $pdo = new PDO('mysql:host=localhost;dbname=pengaduan_sarpras', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "🔍 Debug: Cek data foto_balasan untuk user\n\n";

    // Ambil sample pengaduan dengan foto_balasan
    $stmt = $pdo->query("
        SELECT 
            p.id_pengaduan,
            p.nama_pengaduan,
            p.id_user,
            p.status,
            p.foto_balasan,
            u.username,
            u.nama_pengguna
        FROM pengaduan p
        LEFT JOIN user u ON p.id_user = u.id_user
        ORDER BY p.tgl_pengajuan DESC
        LIMIT 5
    ");

    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (empty($results)) {
    echo "❌ Tidak ada data pengaduan\n";
    exit;
}

echo "=== Data Pengaduan ===\n\n";

foreach ($results as $row) {
    echo "ID Pengaduan: {$row['id_pengaduan']}\n";
    echo "Nama: {$row['nama_pengaduan']}\n";
    echo "User: {$row['nama_pengguna']} ({$row['username']})\n";
    echo "Status: {$row['status']}\n";
    echo "Foto Balasan: " . ($row['foto_balasan'] ? "✅ {$row['foto_balasan']}" : "❌ Belum ada") . "\n";
    
    if ($row['foto_balasan']) {
        $filePath = FCPATH . 'uploads/foto_balasan/' . $row['foto_balasan'];
        if (file_exists($filePath)) {
            echo "File exists: ✅ Ya (Size: " . filesize($filePath) . " bytes)\n";
        } else {
            echo "File exists: ❌ Tidak ditemukan\n";
        }
    }
    
    echo "\n---\n\n";
}

    // Test query yang sama dengan controller
    echo "\n=== Test Query Controller ===\n\n";

    $testId = $results[0]['id_pengaduan'];
    $testUserId = $results[0]['id_user'];

    $stmt = $pdo->prepare("
        SELECT pengaduan.*, lokasi.nama_lokasi, items.nama_item
        FROM pengaduan
        LEFT JOIN lokasi ON lokasi.id_lokasi = pengaduan.id_lokasi
        LEFT JOIN items ON items.id_item = pengaduan.id_item
        WHERE pengaduan.id_pengaduan = :id 
        AND pengaduan.id_user = :user_id
    ");
    
    $stmt->execute(['id' => $testId, 'user_id' => $testUserId]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        echo "✅ Query berhasil!\n";
        echo "ID: {$result['id_pengaduan']}\n";
        echo "Nama: {$result['nama_pengaduan']}\n";
        echo "Foto Balasan: " . ($result['foto_balasan'] ?? '❌ NULL') . "\n";
        
        if (isset($result['foto_balasan']) && $result['foto_balasan']) {
            echo "✅ Kolom foto_balasan ADA di hasil query\n";
        } else {
            echo "⚠️ Kolom foto_balasan KOSONG atau NULL\n";
        }
    } else {
        echo "❌ Query gagal\n";
    }

    echo "\n✅ Debug selesai!\n";
    
} catch (PDOException $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
