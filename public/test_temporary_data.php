<?php
// Test query temporary_item dari web browser
$db = \Config\Database::connect();

try {
    // Cek semua temporary items
    echo "<h2>🔍 Semua Temporary Items:</h2>";
    $allItems = $db->table('temporary_item')
        ->orderBy('created_at', 'DESC')
        ->limit(10)
        ->get()
        ->getResultArray();
    
    if (empty($allItems)) {
        echo "<p style='color:red'>❌ Tidak ada data di temporary_item</p>";
    } else {
        echo "<table border='1' style='border-collapse: collapse; width: 100%'>";
        echo "<tr><th>ID</th><th>Nama Barang</th><th>Lokasi</th><th>Status</th><th>Created</th></tr>";
        foreach ($allItems as $item) {
            $status_color = $item['status'] == 'pending' ? 'orange' : 
                           ($item['status'] == 'approved' ? 'green' : 'red');
            echo "<tr>";
            echo "<td>{$item['id_temporary']}</td>";
            echo "<td><strong>{$item['nama_barang_baru']}</strong></td>";
            echo "<td>{$item['lokasi_barang_baru']}</td>";
            echo "<td style='color: {$status_color}'>{$item['status']}</td>";
            echo "<td>{$item['created_at']}</td>";
            echo "</tr>";
        }
        echo "</table>";
    }
    
    // Cek hanya yang pending
    echo "<hr><h2>⏳ Hanya Yang Status Pending:</h2>";
    $pendingItems = $db->table('temporary_item')
        ->where('status', 'pending')
        ->orderBy('created_at', 'DESC')
        ->get()
        ->getResultArray();
    
    if (empty($pendingItems)) {
        echo "<p style='color:red'>❌ Tidak ada item dengan status pending</p>";
    } else {
        echo "<p style='color:green'>✅ Ditemukan " . count($pendingItems) . " item pending</p>";
        echo "<ul>";
        foreach ($pendingItems as $item) {
            echo "<li><strong>{$item['nama_barang_baru']}</strong> di <em>{$item['lokasi_barang_baru']}</em> (ID: {$item['id_temporary']})</li>";
        }
        echo "</ul>";
    }
    
} catch (Exception $e) {
    echo "<p style='color:red'>❌ Error: " . $e->getMessage() . "</p>";
}
?>