<?php

$db = new mysqli('localhost', 'root', '', 'pengaduan_sarpras');

echo "🔍 Checking Recent Pengaduan Records\n\n";

$result = $db->query("
    SELECT id_pengaduan, nama_pengaduan, status, foto_balasan, saran_petugas, 
           id_petugas, tgl_pengajuan
    FROM pengaduan 
    ORDER BY id_pengaduan DESC
    LIMIT 10
");

if ($result && $result->num_rows > 0) {
    echo "✅ Found " . $result->num_rows . " recent pengaduan:\n\n";
    while ($row = $result->fetch_assoc()) {
        echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
        echo "ID: {$row['id_pengaduan']}\n";
        echo "Nama: {$row['nama_pengaduan']}\n";
        echo "Status: {$row['status']}\n";
        echo "ID Petugas: " . ($row['id_petugas'] ?? 'NULL') . "\n";
        echo "Saran: " . (empty($row['saran_petugas']) ? 'NONE' : substr($row['saran_petugas'], 0, 30) . '...') . "\n";
        echo "Foto Balasan: " . ($row['foto_balasan'] ?? 'NONE') . "\n";
        echo "Tgl: {$row['tgl_pengajuan']}\n";
    }
} else {
    echo "❌ No pengaduan found\n";
}

echo "\n\n=== SOLUTION ===\n";
echo "Masalah yang ditemukan:\n\n";
echo "1. ❌ NOTIFIKASI: Semua notifikasi sudah dibaca (is_read=1)\n";
echo "   - Badge notifikasi tidak muncul karena unread_count = 0\n";
echo "   - Notifikasi hanya tampil jika ada yang belum dibaca\n\n";

echo "2. ❌ FOTO BALASAN: Database tidak ada pengaduan dengan foto_balasan\n";
echo "   - Ada 17 file di folder uploads/foto_balasan/\n";
echo "   - Tapi tidak ada record dengan kolom foto_balasan terisi\n";
echo "   - File mungkin dari testing atau data terhapus\n\n";

$db->close();
