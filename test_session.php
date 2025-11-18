<?php
/**
 * Test Session Data after Login
 * 
 * Script ini untuk test data session yang tersimpan
 * Akses via: http://localhost/test_session.php
 */

session_start();

echo "<h2>🔍 Session Data Test</h2>";
echo "<hr>";

if (empty($_SESSION)) {
    echo "<p style='color:red;'>❌ No session data found. Please login first!</p>";
    echo "<p><a href='" . ($_SERVER['HTTP_HOST'] ?? 'localhost') . "/auth/login'>Go to Login</a></p>";
    exit;
}

echo "<h3>📦 All Session Data:</h3>";
echo "<table border='1' cellpadding='10' style='border-collapse:collapse;'>";
echo "<tr><th>Key</th><th>Value</th></tr>";

foreach ($_SESSION as $key => $value) {
    if (is_array($value)) {
        $valueStr = '<pre>' . print_r($value, true) . '</pre>';
    } else {
        $valueStr = htmlspecialchars($value);
    }
    echo "<tr><td><strong>" . htmlspecialchars($key) . "</strong></td><td>" . $valueStr . "</td></tr>";
}

echo "</table>";

echo "<br><h3>✅ Specific Checks:</h3>";
echo "<ul>";

// Check username
if (isset($_SESSION['username'])) {
    echo "<li>✅ Username: <strong>" . htmlspecialchars($_SESSION['username']) . "</strong></li>";
} else {
    echo "<li>❌ Username: NOT FOUND</li>";
}

// Check nama_pengguna
if (isset($_SESSION['nama_pengguna'])) {
    echo "<li>✅ Nama Pengguna: <strong>" . htmlspecialchars($_SESSION['nama_pengguna']) . "</strong></li>";
} else {
    echo "<li>❌ Nama Pengguna: NOT FOUND</li>";
}

// Check role
if (isset($_SESSION['role'])) {
    echo "<li>✅ Role: <strong>" . htmlspecialchars($_SESSION['role']) . "</strong></li>";
} else {
    echo "<li>❌ Role: NOT FOUND</li>";
}

// Check foto (IMPORTANT!)
if (isset($_SESSION['foto'])) {
    echo "<li>✅ Foto: <strong>" . htmlspecialchars($_SESSION['foto']) . "</strong></li>";
    
    // Check if file exists
    $fotoPath = __DIR__ . '/public/uploads/foto_user/' . $_SESSION['foto'];
    if (file_exists($fotoPath)) {
        echo "<li>✅ Foto file exists at: public/uploads/foto_user/" . htmlspecialchars($_SESSION['foto']) . "</li>";
        echo "<li><img src='/uploads/foto_user/" . htmlspecialchars($_SESSION['foto']) . "' style='width:100px;height:100px;object-fit:cover;border-radius:50%;' alt='Preview'></li>";
    } else {
        echo "<li>⚠️ Foto file NOT FOUND at: " . htmlspecialchars($fotoPath) . "</li>";
    }
} else {
    echo "<li>❌ Foto: NOT FOUND IN SESSION</li>";
    echo "<li style='color:red;'><strong>This is the problem! Foto should be saved in session during login.</strong></li>";
}

echo "</ul>";

echo "<br><hr>";
echo "<h3>🔧 Solution:</h3>";
echo "<p>If 'foto' is missing from session:</p>";
echo "<ol>";
echo "<li>Check LoginController.php - ensure foto is added to sessionData</li>";
echo "<li>Re-login to refresh session with new data</li>";
echo "<li>Clear browser cache and cookies</li>";
echo "</ol>";

echo "<br>";
echo "<p><a href='/auth/logout'>Logout and Re-login</a></p>";
?>
