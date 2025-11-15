<?php
// Script untuk memperbaiki struktur tabel migrations
require_once 'preload.php';

$db = \Config\Database::connect();

echo "🔧 Memperbaiki struktur tabel migrations untuk CI4\n";
echo str_repeat("=", 50) . "\n";

try {
    // Drop dan recreate tabel migrations dengan struktur yang benar
    $db->query("DROP TABLE IF EXISTS migrations_backup");
    $db->query("CREATE TABLE migrations_backup AS SELECT * FROM migrations");
    
    echo "✅ Backup data migrations dibuat\n";
    
    // Drop tabel asli
    $db->query("DROP TABLE migrations");
    
    // Buat tabel baru dengan struktur CI4 yang benar
    $createQuery = "
    CREATE TABLE migrations (
        id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        version VARCHAR(255) NOT NULL,
        class VARCHAR(255) NOT NULL,
        `group` VARCHAR(255) NOT NULL DEFAULT 'default',
        namespace VARCHAR(255) NOT NULL DEFAULT 'App',
        time INT NOT NULL,
        batch INT UNSIGNED NOT NULL
    )";
    
    $db->query($createQuery);
    echo "✅ Tabel migrations dibuat dengan struktur CI4 yang benar\n";
    
    // Restore data dari backup (sesuaikan kolom)
    $backupData = $db->query("SELECT * FROM migrations_backup")->getResultArray();
    
    foreach ($backupData as $row) {
        $db->table('migrations')->insert([
            'version'   => $row['version'] ?? $row['migration'],
            'class'     => $row['class'] ?? 'Unknown',
            'group'     => 'default',
            'namespace' => $row['namespace'] ?? 'App', 
            'time'      => time(),
            'batch'     => $row['batch'] ?? 1
        ]);
    }
    
    echo "✅ Data berhasil di-restore\n";
    echo "🗑️  Menghapus backup...\n";
    
    $db->query("DROP TABLE migrations_backup");
    
    echo "\n🎉 Struktur tabel migrations berhasil diperbaiki!\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
?>