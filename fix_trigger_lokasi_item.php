<?php

$pdo = new PDO('mysql:host=localhost;dbname=pengaduan_sarpras', 'root', '');

echo "🔧 Mengupdate Trigger untuk cek lokasi + item yang sama...\n\n";

try {
    // 1. Drop trigger lama untuk INSERT
    echo "1️⃣ Drop trigger: cek_lokasi_item_sebelum_insert\n";
    $pdo->exec("DROP TRIGGER IF EXISTS cek_lokasi_item_sebelum_insert");
    echo "   ✅ Dropped\n\n";
    
    // 2. Buat trigger baru untuk INSERT
    echo "2️⃣ Buat trigger baru: cek_lokasi_item_sebelum_insert\n";
    $sql = "
    CREATE TRIGGER cek_lokasi_item_sebelum_insert 
    BEFORE INSERT ON pengaduan 
    FOR EACH ROW 
    BEGIN
        DECLARE existing_count INT;
        
        -- Cek apakah ada pengaduan dengan LOKASI dan ITEM yang SAMA
        -- Hanya cek jika id_item tidak NULL (jika NULL berarti item baru/temporary)
        IF NEW.id_item IS NOT NULL THEN
            SELECT COUNT(*) INTO existing_count
            FROM pengaduan
            WHERE id_lokasi = NEW.id_lokasi
            AND id_item = NEW.id_item
            AND status IN ('Diajukan', 'Disetujui', 'Diproses'); -- Hanya cek yang belum selesai
            
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
    
    // 4. Buat trigger baru untuk UPDATE
    echo "4️⃣ Buat trigger baru: cek_lokasi_item_sebelum_update\n";
    $sql = "
    CREATE TRIGGER cek_lokasi_item_sebelum_update 
    BEFORE UPDATE ON pengaduan 
    FOR EACH ROW 
    BEGIN
        DECLARE existing_count INT;
        
        -- Cek apakah ada pengaduan LAIN dengan LOKASI dan ITEM yang SAMA
        -- Hanya cek jika id_item tidak NULL
        IF NEW.id_item IS NOT NULL THEN
            SELECT COUNT(*) INTO existing_count
            FROM pengaduan
            WHERE id_lokasi = NEW.id_lokasi
            AND id_item = NEW.id_item
            AND id_pengaduan != OLD.id_pengaduan
            AND status IN ('Diajukan', 'Disetujui', 'Diproses'); -- Hanya cek yang belum selesai
            
            IF existing_count > 0 THEN
                SIGNAL SQLSTATE '45000'
                SET MESSAGE_TEXT = 'Pengaduan dengan lokasi dan item yang sama sedang dalam proses! Silakan tunggu hingga selesai.';
            END IF;
        END IF;
    END
    ";
    $pdo->exec($sql);
    echo "   ✅ Created\n\n";
    
    echo "✅ SELESAI! Trigger berhasil diupdate.\n\n";
    
    echo "📋 Logika Trigger Baru:\n";
    echo "   ✅ Lokasi SAMA + Item SAMA + Status (Diajukan/Disetujui/Diproses) → DITOLAK\n";
    echo "   ✅ Lokasi SAMA + Item BEDA → BOLEH\n";
    echo "   ✅ Lokasi SAMA + Item SAMA tapi yang lama sudah Selesai/Ditolak → BOLEH\n";
    echo "   ✅ Item NULL (temporary/baru) → SELALU BOLEH\n\n";
    
} catch (PDOException $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
