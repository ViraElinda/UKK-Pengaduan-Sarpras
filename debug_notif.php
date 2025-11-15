<?php
// Debug script untuk notifikasi
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'pengaduan_sarpras';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

echo "===================================\n";
echo "DEBUG SISTEM NOTIFIKASI\n";
echo "===================================\n\n";

// 1. Cek tabel notif
echo "1. CEK TABEL NOTIF\n";
echo "-------------------\n";
$result = $conn->query("SHOW TABLES LIKE 'notif'");
if ($result->num_rows > 0) {
    echo "✓ Tabel 'notif' ada\n";
    
    // Cek struktur
    $structure = $conn->query("DESCRIBE notif");
    echo "  Kolom: ";
    $cols = [];
    while ($row = $structure->fetch_assoc()) {
        $cols[] = $row['Field'];
    }
    echo implode(', ', $cols) . "\n";
} else {
    echo "✗ Tabel 'notif' TIDAK ADA!\n";
    exit;
}

echo "\n";

// 2. Cek jumlah notifikasi
echo "2. JUMLAH NOTIFIKASI\n";
echo "--------------------\n";
$result = $conn->query("SELECT COUNT(*) as total FROM notif");
$row = $result->fetch_assoc();
echo "Total notifikasi: {$row['total']}\n";

if ($row['total'] == 0) {
    echo "⚠ Tidak ada notifikasi! Silakan jalankan setup_notif.php\n";
    exit;
}

echo "\n";

// 3. Cek notifikasi per user
echo "3. NOTIFIKASI PER USER\n";
echo "----------------------\n";
$result = $conn->query("
    SELECT u.id_user, u.username, u.role, 
           COUNT(n.id_notif) as total_notif,
           SUM(CASE WHEN n.is_read = 0 THEN 1 ELSE 0 END) as unread_count
    FROM user u
    LEFT JOIN notif n ON u.id_user = n.id_user
    GROUP BY u.id_user
    HAVING total_notif > 0
    ORDER BY u.id_user
");

while ($row = $result->fetch_assoc()) {
    $badge = $row['unread_count'] > 0 ? " 🔴 {$row['unread_count']} unread" : " ✓ semua dibaca";
    echo "User: {$row['username']} (ID: {$row['id_user']}, Role: {$row['role']})\n";
    echo "  Total notifikasi: {$row['total_notif']}{$badge}\n";
}

echo "\n";

// 4. Detail notifikasi
echo "4. DETAIL NOTIFIKASI (5 TERBARU)\n";
echo "---------------------------------\n";
$result = $conn->query("
    SELECT n.*, u.username 
    FROM notif n 
    JOIN user u ON n.id_user = u.id_user 
    ORDER BY n.created_at DESC 
    LIMIT 5
");

while ($row = $result->fetch_assoc()) {
    $status = $row['is_read'] == 0 ? '🔴 UNREAD' : '✓ Read';
    echo "[{$status}] {$row['judul']}\n";
    echo "  User: {$row['username']} (ID: {$row['id_user']})\n";
    echo "  Pesan: {$row['pesan']}\n";
    echo "  Tipe: {$row['tipe']}\n";
    echo "  Waktu: {$row['created_at']}\n\n";
}

// 5. Test query model
echo "5. TEST QUERY (seperti NotifModel)\n";
echo "-----------------------------------\n";
$result = $conn->query("
    SELECT * FROM notif 
    WHERE id_user = 43 
    ORDER BY is_read ASC, created_at DESC 
    LIMIT 10
");
echo "Query untuk user ID 43 (admini):\n";
echo "Hasil: {$result->num_rows} notifikasi\n";

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $status = $row['is_read'] == 0 ? '🔴' : '✓';
        echo "  {$status} {$row['judul']} ({$row['tipe']})\n";
    }
}

echo "\n";

// 6. Test count unread
echo "6. COUNT UNREAD PER USER\n";
echo "-------------------------\n";
$result = $conn->query("
    SELECT u.id_user, u.username, 
           COUNT(n.id_notif) as unread_count
    FROM user u
    LEFT JOIN notif n ON u.id_user = n.id_user AND n.is_read = 0
    GROUP BY u.id_user
    HAVING unread_count > 0
");

while ($row = $result->fetch_assoc()) {
    echo "User {$row['username']} (ID: {$row['id_user']}): {$row['unread_count']} unread\n";
}

echo "\n";
echo "===================================\n";
echo "✅ DEBUG SELESAI\n";
echo "===================================\n\n";

echo "💡 INSTRUKSI:\n";
echo "1. Login ke sistem dengan salah satu user di atas\n";
echo "2. Pastikan ada badge angka merah di bell icon\n";
echo "3. Klik bell icon untuk melihat dropdown\n";
echo "4. Buka browser console (F12) untuk melihat debug log\n";
echo "5. Cek endpoint langsung: http://localhost:8080/notif/get\n";

$conn->close();
