<?php
/**
 * Script test untuk melihat apakah foto_balasan masuk ke query
 */

try {
    $pdo = new PDO('mysql:host=localhost;dbname=pengaduan_sarpras', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "🔍 Testing Query Pengaduan dengan foto_balasan\n\n";
    
    // Cek struktur tabel
    echo "=== Kolom di tabel pengaduan ===\n";
    $stmt = $pdo->query("DESCRIBE pengaduan");
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    $hasFotoBalasan = false;
    foreach ($columns as $col) {
        if ($col['Field'] === 'foto_balasan') {
            echo "✅ foto_balasan: {$col['Type']} (Null: {$col['Null']})\n";
            $hasFotoBalasan = true;
        }
    }
    
    if (!$hasFotoBalasan) {
        echo "❌ Kolom foto_balasan TIDAK ditemukan!\n";
        exit(1);
    }
    
    echo "\n=== Sample Data Pengaduan ===\n";
    $stmt = $pdo->query("
        SELECT 
            id_pengaduan, 
            nama_pengaduan, 
            status,
            foto_balasan,
            CASE 
                WHEN foto_balasan IS NULL THEN '❌ Belum ada'
                WHEN foto_balasan = '' THEN '❌ Kosong'
                ELSE '✅ Ada foto'
            END as status_foto
        FROM pengaduan 
        ORDER BY tgl_pengajuan DESC 
        LIMIT 5
    ");
    
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (empty($results)) {
        echo "Tidak ada data pengaduan\n";
    } else {
        foreach ($results as $row) {
            echo "\nID: {$row['id_pengaduan']}\n";
            echo "Nama: {$row['nama_pengaduan']}\n";
            echo "Status: {$row['status']}\n";
            echo "Foto Balasan: {$row['status_foto']}\n";
            if (!empty($row['foto_balasan'])) {
                echo "File: {$row['foto_balasan']}\n";
            }
            echo "---\n";
        }
    }
    
    echo "\n✅ Query berhasil! Kolom foto_balasan siap digunakan.\n";
    
} catch (PDOException $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    exit(1);
}
