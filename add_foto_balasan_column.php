<?php
/**
 * Script untuk menambahkan kolom foto_balasan ke tabel pengaduan
 * Mengganti foto_before dan foto_after dengan foto_balasan
 */

try {
    $pdo = new PDO('mysql:host=localhost;dbname=pengaduan_sarpras', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "🔍 Mengecek struktur tabel pengaduan...\n\n";
    
    // Cek kolom yang ada
    $stmt = $pdo->query("DESCRIBE pengaduan");
    $columns = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    echo "Kolom yang ada:\n";
    foreach ($columns as $col) {
        echo "  - $col\n";
    }
    echo "\n";
    
    // Tambah kolom foto_balasan jika belum ada
    if (!in_array('foto_balasan', $columns)) {
        echo "➕ Menambahkan kolom foto_balasan...\n";
        $pdo->exec("ALTER TABLE pengaduan ADD COLUMN foto_balasan VARCHAR(255) NULL AFTER saran_petugas");
        echo "✅ Kolom foto_balasan berhasil ditambahkan!\n\n";
    } else {
        echo "✅ Kolom foto_balasan sudah ada!\n\n";
    }
    
    // Info: Kolom foto_before dan foto_after tetap ada tapi tidak digunakan
    echo "📌 Note: Kolom foto_before dan foto_after masih ada di database\n";
    echo "   tetapi tidak lagi digunakan dalam sistem.\n";
    echo "   Petugas sekarang hanya upload foto_balasan.\n\n";
    
    echo "🎉 Selesai!\n";
    
} catch (PDOException $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    exit(1);
}
