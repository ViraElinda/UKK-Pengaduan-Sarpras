<?php

$pdo = new PDO('mysql:host=localhost;dbname=pengaduan_sarpras', 'root', '');

echo "🔧 Mengubah status pengaduan ID 166 menjadi Selesai...\n\n";

$pdo->exec("UPDATE pengaduan SET status = 'Selesai', tgl_selesai = NOW() WHERE id_pengaduan = 166");

echo "✅ Status diubah menjadi Selesai!\n";
echo "💡 Sekarang kamu BISA buat pengaduan baru dengan Lokasi: Ruang Kelas 1 + Item: kursi\n";
