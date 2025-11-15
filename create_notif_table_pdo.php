<?php
/**
 * Create notif table using direct PDO (for local/dev environments)
 * Run: php create_notif_table_pdo.php
 */
try {
    $pdo = new PDO('mysql:host=localhost;dbname=pengaduan_sarpras', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = file_get_contents(__DIR__ . '/database/sql/create_notif_table.sql');
    if ($sql === false) {
        throw new Exception('SQL file not found: database/sql/create_notif_table.sql');
    }

    // Execute SQL (multiple statements)
    $pdo->exec($sql);
    echo "✅ Tabel 'notif' berhasil dibuat (via PDO)!\n";
} catch (PDOException $e) {
    echo "❌ PDO Error: " . $e->getMessage() . "\n";
    exit(1);
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    exit(1);
}
