<?php
/**
 * Fix Permissions Script
 * Upload file ini ke root directory hosting, lalu akses via browser
 * Contoh: http://yourdomain.com/fix_permissions_web.php
 * 
 * PENTING: Hapus file ini setelah selesai!
 */

// Untuk keamanan, set password sederhana
define('FIX_PASSWORD', 'pengaduan2024'); // Ganti dengan password Anda

// Check password
if (!isset($_GET['pass']) || $_GET['pass'] !== FIX_PASSWORD) {
    die('❌ Akses ditolak! Tambahkan ?pass=pengaduan2024 di URL');
}

echo "<h2>🔧 Fix Permissions - Pengaduan Sarpras</h2>";
echo "<hr>";

$basePath = __DIR__;
$directories = [
    'writable',
    'writable/cache',
    'writable/logs',
    'writable/session',
    'writable/uploads',
    'public/uploads',
    'public/uploads/foto_pengaduan',
    'public/uploads/user'
];

echo "<h3>📁 Creating directories...</h3>";
foreach ($directories as $dir) {
    $fullPath = $basePath . '/' . $dir;
    
    if (!is_dir($fullPath)) {
        if (@mkdir($fullPath, 0755, true)) {
            echo "✅ Created: {$dir}<br>";
        } else {
            echo "❌ Failed to create: {$dir}<br>";
        }
    } else {
        echo "✓ Already exists: {$dir}<br>";
    }
}

echo "<br><h3>🔐 Setting permissions...</h3>";
foreach ($directories as $dir) {
    $fullPath = $basePath . '/' . $dir;
    
    if (is_dir($fullPath)) {
        if (@chmod($fullPath, 0777)) {
            echo "✅ Set 777 for: {$dir}<br>";
        } else {
            echo "❌ Failed to chmod: {$dir}<br>";
        }
    }
}

echo "<br><h3>📝 Creating index.html files...</h3>";
$indexContent = '<!DOCTYPE html><html><head><title>403 Forbidden</title></head><body><h1>Directory access is forbidden.</h1></body></html>';

foreach ($directories as $dir) {
    $fullPath = $basePath . '/' . $dir;
    $indexFile = $fullPath . '/index.html';
    
    if (is_dir($fullPath) && !file_exists($indexFile)) {
        if (@file_put_contents($indexFile, $indexContent)) {
            echo "✅ Created index.html in: {$dir}<br>";
        }
    }
}

echo "<br><h3>🧪 Testing write permissions...</h3>";
$testFile = $basePath . '/writable/cache/test_write.txt';
if (@file_put_contents($testFile, 'test')) {
    echo "✅ writable/cache is writable!<br>";
    @unlink($testFile);
} else {
    echo "❌ writable/cache is NOT writable!<br>";
    echo "<p style='color:red;'><strong>Solusi:</strong> Hubungi hosting support untuk set permission folder writable ke 777</p>";
}

$testFile2 = $basePath . '/writable/logs/test_write.txt';
if (@file_put_contents($testFile2, 'test')) {
    echo "✅ writable/logs is writable!<br>";
    @unlink($testFile2);
} else {
    echo "❌ writable/logs is NOT writable!<br>";
}

echo "<br><h3>📊 Current Permissions:</h3>";
echo "<table border='1' cellpadding='5' style='border-collapse:collapse;'>";
echo "<tr><th>Directory</th><th>Permission</th><th>Writable?</th></tr>";

foreach ($directories as $dir) {
    $fullPath = $basePath . '/' . $dir;
    if (is_dir($fullPath)) {
        $perms = substr(sprintf('%o', fileperms($fullPath)), -4);
        $writable = is_writable($fullPath) ? '✅ Yes' : '❌ No';
        echo "<tr><td>{$dir}</td><td>{$perms}</td><td>{$writable}</td></tr>";
    }
}
echo "</table>";

echo "<br><hr>";
echo "<p><strong>⚠️ PENTING:</strong> Setelah selesai, HAPUS file ini dari server!</p>";
echo "<p>File ini: <code>" . __FILE__ . "</code></p>";
echo "<br>";
echo "<h3>✅ Selesai!</h3>";
echo "<p>Jika masih error, hubungi hosting support untuk:</p>";
echo "<ul>";
echo "<li>Set folder <code>writable</code> dan semua subfolder ke permission 777</li>";
echo "<li>Set owner folder ke user web server (biasanya www-data atau apache)</li>";
echo "<li>Pastikan PHP memiliki akses write ke folder writable</li>";
echo "</ul>";
?>
