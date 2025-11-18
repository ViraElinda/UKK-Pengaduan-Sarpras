<?php

/**
 * Test Validasi Item Baru Duplikat
 * 
 * Script ini untuk test apakah validasi item baru duplikat bekerja
 * Upload ke root directory dan akses via browser
 */

// Simple database connection
$host = 'localhost';
$dbname = 'pengaduan_sarpras';
$username = 'root';
$password = '';

try {
    $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "<h2>🧪 Test Validasi Item Baru Duplikat</h2>";
    echo "<hr>";
    
    // 1. Cek temporary_item
    echo "<h3>1. Data di temporary_item:</h3>";
    $stmt = $db->query("SELECT * FROM temporary_item ORDER BY id_temporary DESC LIMIT 10");
    $tempItems = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (empty($tempItems)) {
        echo "<p>Tidak ada data temporary_item</p>";
    } else {
        echo "<table border='1' cellpadding='5' style='border-collapse:collapse;'>";
        echo "<tr><th>ID</th><th>Nama Barang</th><th>Lokasi</th><th>Status</th></tr>";
        foreach ($tempItems as $item) {
            echo "<tr>";
            echo "<td>" . $item['id_temporary'] . "</td>";
            echo "<td>" . htmlspecialchars($item['nama_barang_baru']) . "</td>";
            echo "<td>" . htmlspecialchars($item['lokasi_barang_baru']) . "</td>";
            echo "<td>" . htmlspecialchars($item['status']) . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    }
    
    // 2. Cek pengaduan dengan id_temporary
    echo "<br><h3>2. Pengaduan dengan Item Baru:</h3>";
    $stmt = $db->query("
        SELECT p.id_pengaduan, p.nama_pengaduan, p.status, p.id_temporary, 
               t.nama_barang_baru, t.lokasi_barang_baru
        FROM pengaduan p
        LEFT JOIN temporary_item t ON p.id_temporary = t.id_temporary
        WHERE p.id_temporary IS NOT NULL
        ORDER BY p.id_pengaduan DESC
        LIMIT 10
    ");
    $pengaduanItems = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (empty($pengaduanItems)) {
        echo "<p>Tidak ada pengaduan dengan item baru</p>";
    } else {
        echo "<table border='1' cellpadding='5' style='border-collapse:collapse;'>";
        echo "<tr><th>ID Pengaduan</th><th>Nama Pengaduan</th><th>Status</th><th>Item Baru</th><th>Lokasi</th></tr>";
        foreach ($pengaduanItems as $p) {
            $statusColor = ($p['status'] == 'Selesai') ? 'green' : 'orange';
            echo "<tr>";
            echo "<td>" . $p['id_pengaduan'] . "</td>";
            echo "<td>" . htmlspecialchars($p['nama_pengaduan']) . "</td>";
            echo "<td style='color:" . $statusColor . ";font-weight:bold;'>" . htmlspecialchars($p['status']) . "</td>";
            echo "<td>" . htmlspecialchars($p['nama_barang_baru']) . "</td>";
            echo "<td>" . htmlspecialchars($p['lokasi_barang_baru']) . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    }
    
    // 3. Simulasi validasi
    echo "<br><h3>3. Simulasi Validasi:</h3>";
    echo "<p>Cek item baru yang masih aktif (status != Selesai):</p>";
    
    foreach ($tempItems as $item) {
        $idTemp = $item['id_temporary'];
        $namaBarang = $item['nama_barang_baru'];
        $lokasiBarang = $item['lokasi_barang_baru'];
        
        // Cek apakah ada pengaduan aktif dengan id_temporary ini
        $stmt = $db->prepare("
            SELECT * FROM pengaduan 
            WHERE id_temporary = ? 
            AND status != 'Selesai'
            LIMIT 1
        ");
        $stmt->execute([$idTemp]);
        $activePengaduan = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($activePengaduan) {
            echo "<p style='color:red;'>❌ <strong>BLOCKED:</strong> Item \"" . htmlspecialchars($namaBarang) . "\" di lokasi " . htmlspecialchars($lokasiBarang) . " masih aktif (ID Pengaduan: " . $activePengaduan['id_pengaduan'] . ", Status: " . $activePengaduan['status'] . ")</p>";
        } else {
            echo "<p style='color:green;'>✅ <strong>ALLOWED:</strong> Item \"" . htmlspecialchars($namaBarang) . "\" di lokasi " . htmlspecialchars($lokasiBarang) . " bisa diajukan (tidak ada pengaduan aktif)</p>";
        }
    }
    
    echo "<br><hr>";
    echo "<h3>✅ Kesimpulan:</h3>";
    echo "<ul>";
    echo "<li>Validasi akan <strong>memblokir</strong> pengajuan item baru yang sama jika masih ada pengaduan aktif (status != Selesai)</li>";
    echo "<li>Validasi akan <strong>mengizinkan</strong> pengajuan item baru yang sama jika pengaduan sebelumnya sudah Selesai</li>";
    echo "<li>Error message: \"Item [nama] di lokasi [lokasi] sudah pernah dilaporkan dan masih dalam proses...\"</li>";
    echo "</ul>";
    
    echo "<br>";
    echo "<p><strong>Test dengan cara:</strong></p>";
    echo "<ol>";
    echo "<li>Login ke aplikasi</li>";
    echo "<li>Buat pengaduan dengan item baru (misal: \"Meja Rusak\" di \"Kelas 12 A\")</li>";
    echo "<li>Coba buat pengaduan lagi dengan item yang sama</li>";
    echo "<li>Seharusnya muncul error dan tidak bisa submit</li>";
    echo "<li>Ubah status pengaduan pertama jadi \"Selesai\"</li>";
    echo "<li>Sekarang bisa buat pengaduan baru dengan item yang sama</li>";
    echo "</ol>";
    
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
