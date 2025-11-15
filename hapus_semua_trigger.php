<?php

$pdo = new PDO('mysql:host=localhost;dbname=pengaduan_sarpras', 'root', '');

echo "🔧 HAPUS SEMUA TRIGGER LOKASI-ITEM...\n\n";

try {
    // Drop semua trigger terkait lokasi-item
    echo "1️⃣ Drop trigger INSERT\n";
    $pdo->exec("DROP TRIGGER IF EXISTS cek_lokasi_item_sebelum_insert");
    echo "   ✅ Dropped\n\n";
    
    echo "2️⃣ Drop trigger UPDATE\n";
    $pdo->exec("DROP TRIGGER IF EXISTS cek_lokasi_item_sebelum_update");
    echo "   ✅ Dropped\n\n";
    
    echo "✅ SELESAI! Trigger sudah dihapus.\n";
    echo "💡 Sekarang user BEBAS melapor kombinasi apapun!\n\n";
    
    // Verify
    $stmt = $pdo->query("SHOW TRIGGERS WHERE `Trigger` LIKE '%cek_lokasi_item%'");
    $triggers = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (empty($triggers)) {
        echo "✅ Konfirmasi: Tidak ada trigger cek_lokasi_item\n";
    } else {
        echo "⚠️ Warning: Masih ada trigger:\n";
        foreach ($triggers as $t) {
            echo "   - {$t['Trigger']}\n";
        }
    }
    
} catch (PDOException $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
