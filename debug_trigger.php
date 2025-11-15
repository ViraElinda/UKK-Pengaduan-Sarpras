<?php

$pdo = new PDO('mysql:host=localhost;dbname=pengaduan_sarpras', 'root', '');

echo "🔍 Debug: Cek pengaduan yang mungkin blocking...\n";
echo str_repeat("=", 80) . "\n\n";

// Ambil input terakhir yang user coba (asumsi dari form)
echo "Masukkan id_lokasi yang dicoba: ";
$id_lokasi = trim(fgets(STDIN));

echo "Masukkan id_item yang dicoba: ";
$id_item = trim(fgets(STDIN));

echo "\n📊 Pengaduan dengan lokasi=$id_lokasi dan item=$id_item:\n";
echo str_repeat("-", 80) . "\n";

$stmt = $pdo->prepare("
    SELECT 
        id_pengaduan, 
        nama_pengaduan,
        id_lokasi, 
        id_item, 
        status,
        tgl_pengajuan
    FROM pengaduan 
    WHERE id_lokasi = ? AND id_item = ?
    ORDER BY id_pengaduan DESC
");
$stmt->execute([$id_lokasi, $id_item]);
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (empty($results)) {
    echo "✅ Tidak ada pengaduan dengan kombinasi ini. BOLEH insert!\n\n";
} else {
    foreach ($results as $row) {
        $icon = in_array($row['status'], ['Diajukan', 'Disetujui', 'Diproses']) ? '❌' : '✅';
        echo "$icon ID: {$row['id_pengaduan']} | Status: {$row['status']} | {$row['nama_pengaduan']}\n";
    }
    
    echo "\n";
    
    // Cek yang masih proses
    $stmt2 = $pdo->prepare("
        SELECT COUNT(*) as total
        FROM pengaduan 
        WHERE id_lokasi = ? 
        AND id_item = ? 
        AND status IN ('Diajukan', 'Disetujui', 'Diproses')
    ");
    $stmt2->execute([$id_lokasi, $id_item]);
    $count = $stmt2->fetch(PDO::FETCH_ASSOC);
    
    if ($count['total'] > 0) {
        echo "❌ TIDAK BOLEH INSERT! Ada {$count['total']} pengaduan yang masih dalam proses.\n";
        echo "💡 Tunggu hingga pengaduan tersebut Selesai atau Ditolak.\n";
    } else {
        echo "✅ BOLEH INSERT! Semua pengaduan dengan kombinasi ini sudah Selesai/Ditolak.\n";
    }
}

echo "\n" . str_repeat("=", 80) . "\n";
echo "🔍 Cek trigger yang active:\n\n";

$stmt = $pdo->query("SHOW CREATE TRIGGER cek_lokasi_item_sebelum_insert");
$trigger = $stmt->fetch(PDO::FETCH_ASSOC);
echo $trigger['SQL Original Statement'] . "\n";
