<?php

// Script untuk clear session CodeIgniter 4
session_start();

// Destroy semua session
session_unset();
session_destroy();

// Hapus cookie
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time()-3600, '/');
}

echo "<!DOCTYPE html>
<html>
<head>
    <title>Session Cleared</title>
    <meta http-equiv='refresh' content='2;url=http://localhost/pengaduan4/pengaduan4/public/auth/login'>
</head>
<body style='font-family: Arial; text-align: center; padding: 50px;'>
    <h2>✅ Session Berhasil Dihapus!</h2>
    <p>Anda akan diarahkan ke halaman login dalam 2 detik...</p>
    <p>Atau klik <a href='http://localhost/pengaduan4/pengaduan4/public/auth/login'>di sini</a> untuk langsung ke login.</p>
</body>
</html>";
