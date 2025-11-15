<?php

$db = new PDO('mysql:host=localhost;dbname=pengaduan_sarpras', 'root', '');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

echo "╔════════════════════════════════════════════════════════════════╗\n";
echo "║             TEST TRIGGER: CEK LOKASI + ITEM                    ║\n";
echo "╚════════════════════════════════════════════════════════════════╝\n\n";

// Get sample data
$stmt = $db->query("SELECT id_lokasi, nama_lokasi FROM lokasi LIMIT 2");
$lokasi = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt = $db->query("SELECT id_item, nama_item FROM items LIMIT 2");
$items = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Cari user yang ada
$stmt = $db->query("SELECT id_user, username FROM user LIMIT 1");
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    echo "❌ Tidak ada user di database!\n";
    exit(1);
}

$id_user = $user['id_user'];
echo "🔑 Menggunakan user: {$user['username']} (ID: {$id_user})\n\n";

echo "📋 SKENARIO TEST:\n";
echo str_repeat("-", 70) . "\n\n";

// TEST 1: Insert pengaduan pertama
echo "TEST 1: Insert pengaduan pertama\n";
echo "  Lokasi: {$lokasi[0]['nama_lokasi']} (ID: {$lokasi[0]['id_lokasi']})\n";
echo "  Item: {$items[0]['nama_item']} (ID: {$items[0]['id_item']})\n";

try {
    $stmt = $db->prepare("
        INSERT INTO pengaduan (nama_pengaduan, deskripsi, id_lokasi, id_item, id_user, status, tgl_pengajuan)
        VALUES (?, ?, ?, ?, ?, 'Diajukan', NOW())
    ");
    $stmt->execute([
        'Test Pengaduan 1',
        'Deskripsi test 1',
        $lokasi[0]['id_lokasi'],
        $items[0]['id_item'],
        $id_user
    ]);
    $id_pengaduan_1 = $db->lastInsertId();
    echo "  ✅ BERHASIL - ID Pengaduan: {$id_pengaduan_1}\n\n";
} catch (PDOException $e) {
    echo "  ❌ GAGAL: " . $e->getMessage() . "\n\n";
}

// TEST 2: Insert dengan lokasi SAMA, item BEDA (HARUS BERHASIL)
echo "TEST 2: Lokasi SAMA, Item BEDA (harus BERHASIL)\n";
echo "  Lokasi: {$lokasi[0]['nama_lokasi']} (ID: {$lokasi[0]['id_lokasi']}) - SAMA\n";
echo "  Item: {$items[1]['nama_item']} (ID: {$items[1]['id_item']}) - BEDA\n";

try {
    $stmt = $db->prepare("
        INSERT INTO pengaduan (nama_pengaduan, deskripsi, id_lokasi, id_item, id_user, status, tgl_pengajuan)
        VALUES (?, ?, ?, ?, ?, 'Diajukan', NOW())
    ");
    $stmt->execute([
        'Test Pengaduan 2',
        'Deskripsi test 2',
        $lokasi[0]['id_lokasi'],
        $items[1]['id_item'],
        $id_user
    ]);
    $id_pengaduan_2 = $db->lastInsertId();
    echo "  ✅ BERHASIL - ID Pengaduan: {$id_pengaduan_2} (SESUAI HARAPAN)\n\n";
} catch (PDOException $e) {
    echo "  ❌ GAGAL: " . $e->getMessage() . " (TIDAK SESUAI!)\n\n";
}

// TEST 3: Insert dengan lokasi SAMA, item SAMA (HARUS GAGAL)
echo "TEST 3: Lokasi SAMA, Item SAMA (harus DITOLAK)\n";
echo "  Lokasi: {$lokasi[0]['nama_lokasi']} (ID: {$lokasi[0]['id_lokasi']}) - SAMA\n";
echo "  Item: {$items[0]['nama_item']} (ID: {$items[0]['id_item']}) - SAMA\n";

try {
    $stmt = $db->prepare("
        INSERT INTO pengaduan (nama_pengaduan, deskripsi, id_lokasi, id_item, id_user, status, tgl_pengajuan)
        VALUES (?, ?, ?, ?, ?, 'Diajukan', NOW())
    ");
    $stmt->execute([
        'Test Pengaduan 3 (Duplikat)',
        'Deskripsi test 3',
        $lokasi[0]['id_lokasi'],
        $items[0]['id_item'],
        $id_user
    ]);
    echo "  ❌ BERHASIL INSERT - Trigger GAGAL! (TIDAK SESUAI!)\n\n";
} catch (PDOException $e) {
    echo "  ✅ DITOLAK oleh trigger (SESUAI HARAPAN)\n";
    echo "  Pesan: " . $e->getMessage() . "\n\n";
}

// TEST 4: Insert dengan lokasi BEDA, item SAMA (HARUS BERHASIL)
echo "TEST 4: Lokasi BEDA, Item SAMA (harus BERHASIL)\n";
echo "  Lokasi: {$lokasi[1]['nama_lokasi']} (ID: {$lokasi[1]['id_lokasi']}) - BEDA\n";
echo "  Item: {$items[0]['nama_item']} (ID: {$items[0]['id_item']}) - SAMA\n";

try {
    $stmt = $db->prepare("
        INSERT INTO pengaduan (nama_pengaduan, deskripsi, id_lokasi, id_item, id_user, status, tgl_pengajuan)
        VALUES (?, ?, ?, ?, ?, 'Diajukan', NOW())
    ");
    $stmt->execute([
        'Test Pengaduan 4',
        'Deskripsi test 4',
        $lokasi[1]['id_lokasi'],
        $items[0]['id_item'],
        $id_user
    ]);
    $id_pengaduan_4 = $db->lastInsertId();
    echo "  ✅ BERHASIL - ID Pengaduan: {$id_pengaduan_4} (SESUAI HARAPAN)\n\n";
} catch (PDOException $e) {
    echo "  ❌ GAGAL: " . $e->getMessage() . " (TIDAK SESUAI!)\n\n";
}

echo str_repeat("=", 70) . "\n";
echo "HASIL TEST:\n";
echo str_repeat("=", 70) . "\n\n";

// Tampilkan data test
$stmt = $db->query("
    SELECT 
        p.id_pengaduan,
        p.nama_pengaduan,
        l.nama_lokasi,
        i.nama_item
    FROM pengaduan p
    LEFT JOIN lokasi l ON l.id_lokasi = p.id_lokasi
    LEFT JOIN items i ON i.id_item = p.id_item
    WHERE p.nama_pengaduan LIKE 'Test Pengaduan%'
    ORDER BY p.id_pengaduan DESC
");
$test_data = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (count($test_data) > 0) {
    echo "Pengaduan yang berhasil tersimpan:\n\n";
    foreach ($test_data as $row) {
        echo "  ID {$row['id_pengaduan']}: {$row['nama_pengaduan']}\n";
        echo "    └─ {$row['nama_lokasi']} → {$row['nama_item']}\n\n";
    }
}

// Cleanup - hapus data test
echo "\n🧹 Membersihkan data test...\n";
$db->exec("DELETE FROM pengaduan WHERE nama_pengaduan LIKE 'Test Pengaduan%'");
echo "✅ Data test dihapus\n\n";

echo "═══════════════════════════════════════════════════════════════\n";
echo "✅ TEST SELESAI!\n";
echo "═══════════════════════════════════════════════════════════════\n";
