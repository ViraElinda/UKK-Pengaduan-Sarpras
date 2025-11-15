<!DOCTYPE html>
<html>
<head>
    <title>Test Query Foto Balasan</title>
    <style>
        body { font-family: monospace; padding: 20px; background: #f5f5f5; }
        .success { color: green; font-weight: bold; }
        .error { color: red; font-weight: bold; }
        .warning { color: orange; font-weight: bold; }
        pre { background: white; padding: 15px; border-radius: 5px; overflow: auto; }
    </style>
</head>
<body>
    <h1>🔍 Test Query Foto Balasan - Pengaduan ID 160</h1>
    
    <?php
    // Direct PDO test
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=pengaduan_sarpras', 'root', '');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $sql = "SELECT pengaduan.*, lokasi.nama_lokasi, items.nama_item 
                FROM pengaduan 
                LEFT JOIN lokasi ON lokasi.id_lokasi = pengaduan.id_lokasi 
                LEFT JOIN items ON items.id_item = pengaduan.id_item 
                WHERE pengaduan.id_pengaduan = 160";
        
        $stmt = $pdo->query($sql);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($result) {
            echo "<h2 class='success'>✅ Data Ditemukan!</h2>";
            
            echo "<h3>Data Penting:</h3>";
            echo "<pre>";
            echo "ID Pengaduan: " . $result['id_pengaduan'] . "\n";
            echo "Nama Pengaduan: " . $result['nama_pengaduan'] . "\n";
            echo "foto (user): " . ($result['foto'] ?? 'NULL') . "\n";
            echo "foto_balasan (petugas): " . ($result['foto_balasan'] ?? 'NULL') . "\n";
            echo "Status: " . $result['status'] . "\n";
            echo "</pre>";
            
            echo "<h3>Semua Kolom (" . count($result) . " total):</h3>";
            echo "<pre>";
            foreach (array_keys($result) as $key) {
                $value = $result[$key];
                if (is_null($value)) {
                    $value = 'NULL';
                } elseif ($value === '') {
                    $value = '(empty string)';
                } else {
                    $value = strlen($value) > 50 ? substr($value, 0, 50) . '...' : $value;
                }
                echo str_pad($key, 25) . " => " . $value . "\n";
            }
            echo "</pre>";
            
            // Check foto_balasan specifically
            if (array_key_exists('foto_balasan', $result)) {
                echo "<h3 class='success'>✅ Kolom 'foto_balasan' ADA di hasil query</h3>";
                
                if (!empty($result['foto_balasan'])) {
                    echo "<p class='success'>✅ foto_balasan punya nilai: <strong>" . $result['foto_balasan'] . "</strong></p>";
                    
                    // Check file
                    $filePath = __DIR__ . '/uploads/foto_balasan/' . $result['foto_balasan'];
                    if (file_exists($filePath)) {
                        echo "<p class='success'>✅ File FISIK ada di server (" . number_format(filesize($filePath)/1024, 2) . " KB)</p>";
                        
                        // Show image
                        $url = base_url('uploads/foto_balasan/' . $result['foto_balasan']);
                        echo "<h3>Preview Foto:</h3>";
                        echo "<img src='$url' style='max-width: 500px; border: 3px solid green;' onerror=\"this.style.border='3px solid red'; this.alt='❌ Gambar gagal dimuat!'\">";
                    } else {
                        echo "<p class='error'>❌ File TIDAK ADA di: $filePath</p>";
                    }
                } else {
                    echo "<p class='warning'>⚠️ foto_balasan kosong/NULL</p>";
                }
            } else {
                echo "<h3 class='error'>❌ Kolom 'foto_balasan' TIDAK ADA di hasil query!</h3>";
            }
            
        } else {
            echo "<h2 class='error'>❌ Data tidak ditemukan</h2>";
        }
        
    } catch (PDOException $e) {
        echo "<h2 class='error'>❌ Error: " . $e->getMessage() . "</h2>";
    }
    
    // Helper function
    function base_url($path = '') {
        $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
        $host = $_SERVER['HTTP_HOST'];
        $baseDir = dirname($_SERVER['SCRIPT_NAME']);
        return $protocol . '://' . $host . $baseDir . '/' . ltrim($path, '/');
    }
    ?>
</body>
</html>
