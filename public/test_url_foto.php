<!DOCTYPE html>
<html>
<head>
    <title>Test Foto Balasan URL</title>
</head>
<body>
    <h1>Test URL Foto Balasan</h1>
    
    <?php
    // Test langsung dengan CodeIgniter base_url
    echo "<h2>1. Dengan base_url() CodeIgniter:</h2>";
    echo "<p>URL: " . base_url('uploads/foto_balasan/balasan_160_1762590086.jpeg') . "</p>";
    echo '<img src="' . base_url('uploads/foto_balasan/balasan_160_1762590086.jpeg') . '" style="max-width:500px; border:3px solid red;">';
    
    echo "<hr>";
    
    // Test dengan path relatif biasa
    echo "<h2>2. Dengan path relatif biasa:</h2>";
    echo "<p>URL: /uploads/foto_balasan/balasan_160_1762590086.jpeg</p>";
    echo '<img src="/uploads/foto_balasan/balasan_160_1762590086.jpeg" style="max-width:500px; border:3px solid blue;">';
    
    echo "<hr>";
    
    // Test dengan full URL
    echo "<h2>3. Dengan full URL:</h2>";
    $fullUrl = 'http://localhost/pengaduan4/pengaduan4/public/uploads/foto_balasan/balasan_160_1762590086.jpeg';
    echo "<p>URL: $fullUrl</p>";
    echo '<img src="' . $fullUrl . '" style="max-width:500px; border:3px solid green;">';
    
    echo "<hr>";
    
    // Check file existence
    echo "<h2>4. File Check:</h2>";
    $path = __DIR__ . '/uploads/foto_balasan/balasan_160_1762590086.jpeg';
    echo "<p>Path: $path</p>";
    echo "<p>Exists: " . (file_exists($path) ? 'YES ✅' : 'NO ❌') . "</p>";
    ?>
</body>
</html>
