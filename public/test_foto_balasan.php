<!DOCTYPE html>
<html>
<head>
    <title>Test Foto Balasan</title>
    <style>
        body { font-family: Arial; padding: 20px; }
        .success { background: #d4edda; border: 1px solid #c3e6cb; padding: 15px; margin: 10px 0; border-radius: 5px; }
        .error { background: #f8d7da; border: 1px solid #f5c6cb; padding: 15px; margin: 10px 0; border-radius: 5px; }
        .info { background: #d1ecf1; border: 1px solid #bee5eb; padding: 15px; margin: 10px 0; border-radius: 5px; }
        img { max-width: 500px; border: 2px solid #ccc; margin-top: 10px; }
    </style>
</head>
<body>
    <h1>🔍 Test Foto Balasan - User Detail View</h1>
    
    <?php
    // Simulasi query yang sama dengan controller
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=pengaduan_sarpras', 'root', '');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $id_pengaduan = 160;
        $id_user = 55; // User yeni
        
        $stmt = $pdo->prepare("
            SELECT pengaduan.*, lokasi.nama_lokasi, items.nama_item
            FROM pengaduan
            LEFT JOIN lokasi ON lokasi.id_lokasi = pengaduan.id_lokasi
            LEFT JOIN items ON items.id_item = pengaduan.id_item
            WHERE pengaduan.id_pengaduan = :id 
            AND pengaduan.id_user = :user_id
        ");
        
        $stmt->execute(['id' => $id_pengaduan, 'user_id' => $id_user]);
        $pengaduan = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($pengaduan) {
            echo '<div class="success">';
            echo '<h2>✅ Data Pengaduan Ditemukan</h2>';
            echo '<p><strong>ID:</strong> ' . $pengaduan['id_pengaduan'] . '</p>';
            echo '<p><strong>Nama:</strong> ' . htmlspecialchars($pengaduan['nama_pengaduan']) . '</p>';
            echo '<p><strong>Status:</strong> ' . htmlspecialchars($pengaduan['status']) . '</p>';
            echo '<p><strong>Saran Petugas:</strong> ' . htmlspecialchars($pengaduan['saran_petugas'] ?: '-') . '</p>';
            echo '</div>';
            
            echo '<div class="info">';
            echo '<h3>📸 Status Foto Balasan:</h3>';
            echo '<p><strong>Kolom foto_balasan ada?</strong> ' . (isset($pengaduan['foto_balasan']) ? '✅ Ya' : '❌ Tidak') . '</p>';
            echo '<p><strong>Nilai foto_balasan:</strong> ' . ($pengaduan['foto_balasan'] ?: '❌ NULL/Empty') . '</p>';
            echo '<p><strong>empty() check:</strong> ' . (empty($pengaduan['foto_balasan']) ? '❌ Empty (akan tampil pesan belum ada)' : '✅ Ada data (akan tampil foto)') . '</p>';
            echo '</div>';
            
            if (!empty($pengaduan['foto_balasan'])) {
                echo '<div class="success">';
                echo '<h3>✅ Foto Balasan Ada!</h3>';
                echo '<p><strong>Nama File:</strong> ' . htmlspecialchars($pengaduan['foto_balasan']) . '</p>';
                
                $filePath = __DIR__ . '/public/uploads/foto_balasan/' . $pengaduan['foto_balasan'];
                $webPath = 'uploads/foto_balasan/' . $pengaduan['foto_balasan'];
                
                echo '<p><strong>Path:</strong> ' . $filePath . '</p>';
                echo '<p><strong>File Exist?</strong> ' . (file_exists($filePath) ? '❌ Tidak (dummy file)' : '❌ Tidak ada') . '</p>';
                
                echo '<h4>Preview (akan error karena file dummy):</h4>';
                echo '<img src="' . $webPath . '" alt="Foto Balasan" onerror="this.style.display=\'none\'; this.nextElementSibling.style.display=\'block\';">';
                echo '<div style="display:none; background: #fff3cd; border: 1px solid #ffc107; padding: 10px; margin-top: 10px;">⚠️ File tidak ditemukan (ini normal untuk testing dengan dummy data)</div>';
                echo '</div>';
            } else {
                echo '<div class="error">';
                echo '<h3>❌ Foto Balasan Kosong</h3>';
                echo '<p>Kolom foto_balasan NULL atau empty string</p>';
                echo '</div>';
            }
            
        } else {
            echo '<div class="error">';
            echo '<h2>❌ Data Tidak Ditemukan</h2>';
            echo '<p>Pengaduan ID ' . $id_pengaduan . ' untuk user ID ' . $id_user . ' tidak ada.</p>';
            echo '</div>';
        }
        
    } catch (PDOException $e) {
        echo '<div class="error">';
        echo '<h2>❌ Database Error</h2>';
        echo '<p>' . htmlspecialchars($e->getMessage()) . '</p>';
        echo '</div>';
    }
    ?>
    
    <hr>
    <p><strong>📌 Langkah Testing:</strong></p>
    <ol>
        <li>Login sebagai user: <code>yeni</code></li>
        <li>Buka menu "Riwayat"</li>
        <li>Klik detail pada pengaduan</li>
        <li>Scroll ke bagian "Dokumentasi Perbaikan"</li>
        <li>Harusnya muncul card ungu "Foto Balasan Petugas"</li>
    </ol>
</body>
</html>
