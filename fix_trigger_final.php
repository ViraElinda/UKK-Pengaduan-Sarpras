<?php

$pdo = new PDO('mysql:host=localhost;dbname=pengaduan_sarpras', 'root', '');

echo "🔧 Memperbaiki Trigger - Izinkan insert jika yang lama sudah Selesai/Ditolak...\n\n";

try {
    // 1. Drop trigger lama untuk INSERT
    echo "1️⃣ Drop trigger: cek_lokasi_item_sebelum_insert\n";
    $pdo->exec("DROP TRIGGER IF EXISTS cek_lokasi_item_sebelum_insert");
    echo "   ✅ Dropped\n\n";
    
    // 2. Buat trigger baru untuk INSERT - HANYA cek yang sedang dalam proses
    echo "2️⃣ Buat trigger baru: cek_lokasi_item_sebelum_insert\n";
    $sql = "
    CREATE TRIGGER cek_lokasi_item_sebelum_insert 
    BEFORE INSERT ON pengaduan 
    FOR EACH ROW 
    BEGIN
        DECLARE existing_count INT;
        
        -- Cek HANYA jika ada pengaduan dengan LOKASI dan ITEM yang SAMA
        -- dan statusnya BELUM SELESAI (sedang dalam proses)
        IF NEW.id_item IS NOT NULL THEN
            SELECT COUNT(*) INTO existing_count
            FROM pengaduan
            WHERE id_lokasi = NEW.id_lokasi
            AND id_item = NEW.id_item
            AND status IN ('Diajukan', 'Disetujui', 'Diproses');
            
            IF existing_count > 0 THEN
                SIGNAL SQLSTATE '45000'
                SET MESSAGE_TEXT = 'Pengaduan dengan lokasi dan item yang sama sedang dalam proses! Silakan tunggu hingga selesai.';
            END IF;
        END IF;
    END
    ";
    $pdo->exec($sql);
    echo "   ✅ Created\n\n";
    
    // 3. Drop trigger lama untuk UPDATE
    echo "3️⃣ Drop trigger: cek_lokasi_item_sebelum_update\n";
    $pdo->exec("DROP TRIGGER IF EXISTS cek_lokasi_item_sebelum_update");
    echo "   ✅ Dropped\n\n";
    
    // 4. Buat trigger baru untuk UPDATE - HANYA cek yang sedang dalam proses
    echo "4️⃣ Buat trigger baru: cek_lokasi_item_sebelum_update\n";
    $sql = "
    CREATE TRIGGER cek_lokasi_item_sebelum_update 
    BEFORE UPDATE ON pengaduan 
    FOR EACH ROW 
    BEGIN
        DECLARE existing_count INT;
        
        -- Cek HANYA jika ada pengaduan LAIN dengan LOKASI dan ITEM yang SAMA
        -- dan statusnya BELUM SELESAI (sedang dalam proses)
        IF NEW.id_item IS NOT NULL THEN
            SELECT COUNT(*) INTO existing_count
            FROM pengaduan
            WHERE id_lokasi = NEW.id_lokasi
            AND id_item = NEW.id_item
            AND id_pengaduan != OLD.id_pengaduan
            AND status IN ('Diajukan', 'Disetujui', 'Diproses');
            
            IF existing_count > 0 THEN
                SIGNAL SQLSTATE '45000'
                SET MESSAGE_TEXT = 'Pengaduan dengan lokasi dan item yang sama sedang dalam proses! Silakan tunggu hingga selesai.';
            END IF;
        END IF;
    END
    ";
    $pdo->exec($sql);
    echo "   ✅ Created\n\n";
    
    echo "✅ SELESAI! Trigger berhasil diperbaiki.\n\n";
    
    echo "📋 Logika Trigger yang BENAR:\n";
    echo "   ❌ Lokasi SAMA + Item SAMA + Status (Diajukan/Disetujui/Diproses) → DITOLAK\n";
    echo "   ✅ Lokasi SAMA + Item SAMA + Status (Selesai/Ditolak) → BOLEH (bisa lapor lagi)\n";
    echo "   ✅ Lokasi SAMA + Item BEDA → BOLEH\n";
    echo "   ✅ Item NULL (temporary/baru) → SELALU BOLEH\n\n";
    
    // Test dengan data yang ada
    echo "🧪 Test dengan data existing:\n";
    echo str_repeat("=", 70) . "\n";
    
    $stmt = $pdo->query("
        SELECT id_pengaduan, id_lokasi, id_item, status, nama_pengaduan
        FROM pengaduan 
        WHERE id_item IS NOT NULL
        ORDER BY id_pengaduan DESC 
        LIMIT 5
    ");
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "ID: {$row['id_pengaduan']} | ";
        echo "Lokasi: {$row['id_lokasi']} | ";
        echo "Item: {$row['id_item']} | ";
        echo "Status: {$row['status']}\n";
    }
    
    echo "\n💡 Sekarang coba buat pengaduan baru dengan lokasi+item yang SUDAH SELESAI!\n";
    
} catch (PDOException $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
