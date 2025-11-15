<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Laporan Pengaduan</title>
<style>
    /* === Global Style === */
    body {
        font-family: 'Poppins', 'DejaVu Sans', sans-serif;
        font-size: 11.5px;
        color: #111827;
        margin: 0;
        padding: 32px;
        background-color: #ffffff;
        line-height: 1.6;
    }

    h1, h2, h3 {
        margin: 0;
        padding: 0;
    }

    /* === Header === */
    .header {
        display: flex;
        align-items: center;
        border-bottom: 2px solid #1f2937;
        padding-bottom: 10px;
        margin-bottom: 22px;
    }

    .brand-logo {
        width: 85px;
        height: 85px;
        object-fit: contain;
        margin-right: 14px;
    }

    .brand-meta {
        flex: 1;
    }

    .brand-meta h1 {
        font-size: 18px;
        font-weight: 800;
        color: #111827;
        letter-spacing: 0.5px;
    }

    .brand-meta h2 {
        font-size: 12px;
        font-weight: 600;
        color: #4b5563;
        margin-top: 4px;
    }

    .meta-right {
        text-align: right;
        font-size: 10.5px;
        color: #374151;
        min-width: 180px;
    }

    /* === Info Section === */
    .info-section {
        border: 1px solid #e5e7eb;
        background-color: #f9fafb;
        border-radius: 6px;
        padding: 12px 16px;
        margin-bottom: 22px;
    }

    .info-row {
        margin: 5px 0;
    }

    .info-row strong {
        color: #1e40af;
        display: inline-block;
        min-width: 140px;
    }

    /* === Summary Cards === */
    .section-title {
        font-weight: 700;
        font-size: 13.5px;
        color: #111827;
        border-bottom: 1px solid #d1d5db;
        margin: 18px 0 10px;
        padding-bottom: 4px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .summary-grid {
        display: flex;
        justify-content: space-between;
        gap: 10px;
        margin: 10px 0 22px;
    }

    .summary-card {
        flex: 1;
        background: linear-gradient(to bottom right, #f9fafb, #ffffff);
        border: 1px solid #d1d5db;
        border-radius: 8px;
        padding: 12px;
        text-align: center;
        box-shadow: 0 1px 2px rgba(0,0,0,0.06);
    }

    .summary-number {
        font-size: 22px;
        font-weight: 700;
        margin: 6px 0;
    }

    .summary-label {
        font-size: 11px;
        color: #4b5563;
        font-weight: 600;
        letter-spacing: 0.5px;
    }

    /* Warna masing-masing status */
    .summary-blue { color: #2563eb; }
    .summary-yellow { color: #d97706; }
    .summary-green { color: #059669; }
    .summary-red { color: #dc2626; }

    /* === Data Table === */
    table.data-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 10.5px;
        margin-top: 8px;
    }

    table.data-table th {
        background-color: #f3f4f6;
        text-transform: uppercase;
        font-size: 10px;
        font-weight: 700;
        color: #1f2937;
        border: 1px solid #d1d5db;
        padding: 8px;
        text-align: center;
    }

    table.data-table td {
        border: 1px solid #e5e7eb;
        padding: 8px;
        vertical-align: middle;
    }

    table.data-table tr:nth-child(even) { background-color: #fafafa; }
    table.data-table tr:hover { background-color: #f1f5f9; }

    /* === Badge === */
    .badge {
        padding: 4px 10px;
        border-radius: 12px;
        font-size: 8.5px;
        font-weight: 700;
        display: inline-block;
        letter-spacing: 0.3px;
    }

    .badge-diajukan {
        background-color: #dbeafe;
        color: #1e40af;
        border: 1px solid #3b82f6;
    }
    .badge-diproses {
        background-color: #fef3c7;
        color: #92400e;
        border: 1px solid #f59e0b;
    }
    .badge-selesai {
        background-color: #d1fae5;
        color: #065f46;
        border: 1px solid #10b981;
    }
    .badge-ditolak {
        background-color: #fee2e2;
        color: #991b1b;
        border: 1px solid #ef4444;
    }

    /* === No Data === */
    .no-data {
        text-align: center;
        padding: 36px 0;
        color: #9ca3af;
        font-style: italic;
        background-color: #f9fafb;
        border-radius: 6px;
    }

    /* === Footer === */
    .footer {
        margin-top: 30px;
        padding-top: 10px;
        border-top: 1px solid #d1d5db;
        text-align: center;
        font-size: 10px;
        color: #4b5563;
    }

    .footer .footer-title {
        font-weight: 700;
        color: #111827;
        margin-bottom: 5px;
    }

    .signature-block {
        margin-top: 40px;
        display: flex;
        justify-content: flex-end;
    }

    .signature {
        text-align: center;
        width: 45%;
    }

    .signature .name {
        margin-top: 60px;
        font-weight: 700;
        text-decoration: underline;
    }

    .signature .title {
        font-weight: 600;
        color: #1f2937;
    }
</style>
</head>
<body>
    
        <div class="brand-meta">
            <h1>LAPORAN PENGADUAN SARANA &amp; PRASARANA</h1>
            <h2>Sistem Pengaduan Sekolah</h2>
            <div style="font-size:11px;margin-top:6px;color:#6b7280;">Alamat Sekolah / Instansi • Telepon / Email</div>
        </div>

        <div class="meta-right">
            <div><strong>Periode:</strong><br><?= date('d F Y', strtotime($tgl_mulai)) ?> – <?= date('d F Y', strtotime($tgl_selesai)) ?></div>
            <div style="margin-top:6px;"><strong>Cetak:</strong><br><?= date('d F Y, H:i:s') ?> WIB</div>
        </div>
    </div>

    <div class="info-section">
        <div class="info-row"><strong>Periode:</strong> <?= date('d F Y', strtotime($tgl_mulai)) ?> – <?= date('d F Y', strtotime($tgl_selesai)) ?></div>
        <div class="info-row"><strong>Total Pengaduan:</strong> <?= count($laporan) ?> Data</div>
        <div class="info-row"><strong>Dicetak Oleh:</strong> Admin Sistem Pengaduan</div>
        <div class="info-row"><strong>Tanggal Cetak:</strong> <?= date('d F Y, H:i:s') ?> WIB</div>
    </div>

    <div class="section-title">Ringkasan Statistik</div>
    <div class="summary-grid">
        <div class="summary-card summary-blue">
            <div class="summary-number"><?= $stats['diajukan'] ?? 0 ?></div>
            <div class="summary-label">Diajukan</div>
        </div>
        <div class="summary-card summary-yellow">
            <div class="summary-number"><?= $stats['diproses'] ?? 0 ?></div>
            <div class="summary-label">Diproses</div>
        </div>
        <div class="summary-card summary-green">
            <div class="summary-number"><?= $stats['selesai'] ?? 0 ?></div>
            <div class="summary-label">Selesai</div>
        </div>
        <div class="summary-card summary-red">
            <div class="summary-number"><?= $stats['ditolak'] ?? 0 ?></div>
            <div class="summary-label">Ditolak</div>
        </div>
    </div>

    <div class="section-title">Data Pengaduan Lengkap</div>
    <table class="data-table">
        <thead>
            <tr>
                <th>No</th>
                <th>ID</th>
                <th>Foto</th>
                <th>Nama Pengaduan</th>
                <th>Lokasi</th>
                <th>Tanggal</th>
                <th>Status</th>
                <th>User</th>
                <th>Deskripsi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($laporan)): ?>
                <?php $no = 1; foreach ($laporan as $row): ?>
                    <tr>
                        <td style="text-align:center;"><?= $no++ ?></td>
                        <td style="text-align:center;color:#2563eb;">#<?= esc($row['id_pengaduan']) ?></td>
                        <td style="text-align:center;">
                            <?php if (!empty($row['foto_path']) && is_file($row['foto_path'])): ?>
                                <img src="<?= $row['foto_path'] ?>" style="width:70px;height:50px;object-fit:cover;border:1px solid #d1d5db;">
                            <?php else: ?>–<?php endif; ?>
                        </td>
                        <td><?= esc($row['nama_pengaduan']) ?></td>
                        <td style="text-align:center;"><?= esc($row['lokasi'] ?? '-') ?></td>
                        <td style="text-align:center;"><?= date('d/m/Y H:i', strtotime($row['tgl_pengajuan'])) ?></td>
                        <td style="text-align:center;">
                            <span class="badge badge-<?= strtolower($row['status']) ?>"><?= ucfirst($row['status']) ?></span>
                        </td>
                        <td style="text-align:center;"><?= esc($row['id_user']) ?></td>
                        <td><?= esc(strlen($row['deskripsi']) > 90 ? substr($row['deskripsi'], 0, 90) . '...' : $row['deskripsi']) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="9">
                        <div class="no-data">Tidak ada data pengaduan pada periode ini</div>
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="signature-block">
        <div class="signature">
            <div>Mengetahui,</div>
            <div class="title">Kepala Sekolah / Penanggung Jawab</div>
            <div class="name">( ........................................ )</div>
        </div>
    </div>

    <div class="footer">
        <div class="footer-title">SISTEM PENGADUAN SARANA & PRASARANA</div>
        <div>Dokumen ini sah tanpa tanda tangan basah.</div>
        <div>© <?= date('Y') ?> Sistem Pengaduan Sarpras — All Rights Reserved.</div>
    </div>
</body>
</html>
 dicetak dari sistem dan sah tanpa tanda tangan</div>
        <div class="footer-subtitle">Untuk informasi lebih lanjut, silakan hubungi administrator sistem</div>
        <div class="copyright">© <?= date('Y') ?> - Sistem Pengaduan Sarpras. All Rights Reserved.</div>
    </div>
</body>
</html>
