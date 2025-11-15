<?php
/**
 * Script untuk test upload foto_balasan ke pengaduan ID tertentu
 */

try {
    $pdo = new PDO('mysql:host=localhost;dbname=pengaduan_sarpras', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "🔍 Test Upload Foto Balasan\n\n";
    
    // Ambil pengaduan pertama
    $stmt = $pdo->query("SELECT id_pengaduan, nama_pengaduan, status FROM pengaduan ORDER BY tgl_pengajuan DESC LIMIT 1");
    $pengaduan = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$pengaduan) {
        echo "❌ Tidak ada pengaduan untuk testing\n";
        exit;
    }
    
    echo "Pengaduan untuk test:\n";
    echo "ID: {$pengaduan['id_pengaduan']}\n";
    echo "Nama: {$pengaduan['nama_pengaduan']}\n";
    echo "Status: {$pengaduan['status']}\n\n";
    
    // Update dengan nama foto dummy
    $fotoBalasan = "test_balasan_" . time() . ".jpg";
    
    $stmt = $pdo->prepare("
        UPDATE pengaduan 
        SET foto_balasan = :foto_balasan,
            saran_petugas = 'Perbaikan sudah selesai dilakukan'
        WHERE id_pengaduan = :id
    ");
    
    $stmt->execute([
        'foto_balasan' => $fotoBalasan,
        'id' => $pengaduan['id_pengaduan']
    ]);
    
    echo "✅ Update berhasil!\n";
    echo "Foto balasan: $fotoBalasan\n\n";
    
    // Verifikasi
    $stmt = $pdo->prepare("SELECT foto_balasan, saran_petugas FROM pengaduan WHERE id_pengaduan = ?");
    $stmt->execute([$pengaduan['id_pengaduan']]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    echo "=== Verifikasi ===\n";
    echo "Foto Balasan: " . ($result['foto_balasan'] ?? '❌ NULL') . "\n";
    echo "Saran Petugas: " . ($result['saran_petugas'] ?? '❌ NULL') . "\n";
    
    if ($result['foto_balasan']) {
        echo "\n✅ Data foto_balasan berhasil disimpan!\n";
        echo "\n📌 Sekarang coba:\n";
        echo "1. Login sebagai user pemilik pengaduan ini\n";
        echo "2. Buka Riwayat → Detail pengaduan ID {$pengaduan['id_pengaduan']}\n";
        echo "3. Lihat bagian 'Dokumentasi Perbaikan'\n";
        echo "4. Seharusnya muncul pesan 'Foto Balasan Petugas' (meski file tidak ada)\n";
    }
    
} catch (PDOException $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
