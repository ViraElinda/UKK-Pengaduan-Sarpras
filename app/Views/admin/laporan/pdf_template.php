<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Laporan Pengaduan</title>
    <style>
    /* A4 page sizing for PDF generators that respect @page */
    @page { size: A4; margin: 20mm 16mm 20mm 16mm; }

        /* === Global Style === */
        body {
            font-family: 'DejaVu Sans', 'Poppins', sans-serif;
            font-size: 10px;
            color: #111827;
            margin: 0;
            padding: 0; /* page margin handled by @page */
            background-color: #ffffff;
            line-height: 1.5;
        }

    /* Page content wrapper */
    .page { padding: 8mm 8mm 18mm 8mm; }
        h1, h2, h3 { margin: 0; padding: 0; }

        /* Header */
        /* Simple header styles (centered) */
        .center-header { text-align:center; margin-bottom:10px; }
        .center-header .logo-small { width:64px; height:64px; object-fit:contain; display:block; margin:0 auto 6px; }
        .center-header h1 { margin:0; font-size:18px; font-weight:800; }
        .center-header h2 { margin:2px 0 6px; font-size:12px; color:#374151; }

        /* Info box */
    .info-section { border:1px solid #eef2ff; background:#fbfdff; border-radius:6px; padding:10px 12px; margin:12px 0 14px; }
        .info-row { margin:4px 0; }
        .info-row strong { display:inline-block; min-width:120px; color:#1e40af; }

        /* Summary */
    .summary-grid { display:flex; gap:8px; margin:8px 0 12px; }
    .summary-card { flex:1; background:#fff; border:1px solid #eef2ff; border-radius:6px; padding:8px; text-align:center; }
        .summary-number { font-size:20px; font-weight:800; color:#0f172a; }
        .summary-label { font-size:11px; color:#475569; margin-top:6px; }

        /* Table */
    table.data-table { width:100%; border-collapse:collapse; font-size:10px; margin-top:6px; }
        table.data-table th { background:#f8fafc; text-transform:uppercase; font-weight:700; font-size:10px; color:#0f172a; border:1px solid #eef2ff; padding:6px; text-align:center; }
    table.data-table td { border:1px solid #f1f5f9; padding:6px; vertical-align:top; }
    table.data-table tbody tr { page-break-inside: avoid; }
        table.data-table tr:nth-child(even) td { background:#fbfcfe; }

        /* Column hints */
        th.col-no { width:4%; } th.col-id { width:7%; } th.col-foto { width:9%; } th.col-nama { width:20%; text-align:left; }
        th.col-lokasi { width:12%; } th.col-tgl { width:12%; } th.col-status { width:8%; } th.col-user { width:8%; } th.col-desc { width:20%; text-align:left; }
    td.desc { white-space:pre-wrap; font-size:10px; color:#334155; }
        img.thumb { width:64px; height:44px; object-fit:cover; border-radius:6px; border:1px solid #e6eefb; }

        /* Badges */
        .badge { padding:4px 8px; border-radius:999px; font-size:9px; font-weight:700; display:inline-block; }
        .badge-diajukan{ background:#e6f0ff; color:#1e40af; border:1px solid #60a5fa; }
        .badge-diproses{ background:#fff7ed; color:#92400e; border:1px solid #f59e0b; }
        .badge-selesai{ background:#ecfdf5; color:#065f46; border:1px solid #34d399; }
        .badge-ditolak{ background:#fff1f2; color:#991b1b; border:1px solid #fb7185; }

        .signature-block { margin-top:18px; display:flex; justify-content:flex-end; }
        .signature { text-align:center; width:40%; }
        .signature .name { margin-top:50px; font-weight:700; text-decoration:underline; }

    .footer { margin-top:18px; border-top:1px solid #eef2ff; padding-top:8px; text-align:center; font-size:10px; color:#64748b; }
<style>
    @page { size: A4 landscape; margin: 20mm; }
    body { font-family: 'DejaVu Sans', Arial, sans-serif; color:#111827; margin:0; padding:0; }
    .page { padding: 8mm 12mm 18mm 12mm; }

    /* Centered simple header */
    .center-header { text-align:center; margin-bottom:12px; }
    .center-header img { width:64px; height:64px; object-fit:contain; display:block; margin:0 auto 6px; }
    .center-header h1 { margin:0; font-size:18px; font-weight:800; }
    .center-header h2 { margin:4px 0; font-size:12px; color:#374151; }
    .center-header .title { font-weight:700; margin-top:6px; }

    /* compact info block under header */
    .info-section { margin:8px 0 14px; }
    .info-row { margin:3px 0; font-size:11px; }
    .info-row strong { display:inline-block; width:120px; }

    /* clean table */
    table.data-table { width:100%; border-collapse:collapse; font-size:11px; margin-top:8px; }
    table.data-table th { background:#2d3748; color:#fff; text-align:left; padding:10px 8px; font-weight:700; }
    table.data-table td { border:1px solid #e2e8f0; padding:10px 8px; vertical-align:top; }
    table.data-table tbody tr:nth-child(even) td { background:#fbfbfb; }
    img.thumb { width:64px; height:44px; object-fit:cover; border-radius:4px; }

    /* footer */
    .footer-hr { border-top:1px solid #cbd5e1; margin-top:18px; }
    .footer-right { text-align:right; font-size:11px; margin-top:8px; }

    @media print { .page { padding:0; } }
</style>
</head>
<body>
    <div class="page">
        <div class="center-header">
            <h1>SMKN 1 Bantul</h1>
            <div class="title">Laporan Pengaduan Sarpras</div>
        </div>

        <div class="info-section">
            <div class="info-row"><strong>Periode:</strong> <?= date('d F Y', strtotime($tgl_mulai)) ?> – <?= date('d F Y', strtotime($tgl_selesai)) ?></div>
            <div class="info-row"><strong>Status:</strong> <?= esc($filterStatusName ?? 'Semua') ?></div>
            <div class="info-row"><strong>Bulan/Tahun:</strong> <?= esc($filterLokasiName ?? '-') ?></div>
            <div class="info-row"><strong>Dicetak oleh:</strong> <?= esc($printedBy ?? 'Admin') ?></div>
            <div class="info-row"><strong>Tanggal Cetak:</strong> <?= esc($printedAt ?? date('d F Y, H:i:s')) ?> WIB</div>
        </div>

        <h3 style="margin:6px 0 8px;font-weight:700;">Data Pengaduan</h3>

        <table class="data-table">
            <thead>
                <tr>
                    <th class="col-no">No</th>
                    <th class="col-id">ID</th>
                    <th class="col-foto">Foto</th>
                    <th class="col-nama">Nama Pengaduan</th>
                    <th class="col-lokasi">Lokasi</th>
                    <th class="col-tgl">Tanggal</th>
                    <th class="col-status">Status</th>
                    <th class="col-user">User</th>
                    <th class="col-desc">Deskripsi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($laporan)): $no = 1; ?>
                    <?php foreach ($laporan as $row): ?>
                        <tr>
                            <td style="width:4%;"><?= $no++ ?></td>
                            <td style="color:#2563eb;">#<?= esc($row['id_pengaduan']) ?></td>
                            <td style="text-align:center;">
                                <?php if (!empty($row['foto_data_uri'])): ?>
                                    <img src="<?= $row['foto_data_uri'] ?>" class="thumb" alt="foto">
                                <?php elseif (!empty($row['foto_path']) && is_file($row['foto_path'])): ?>
                                    <img src="<?= $row['foto_path'] ?>" class="thumb" alt="foto">
                                <?php else: ?>
                                    –
                                <?php endif; ?>
                            </td>
                            <td><?= esc($row['nama_pengaduan']) ?></td>
                            <td><?= esc($row['lokasi'] ?? '-') ?></td>
                            <td><?= date('d/m/Y H:i', strtotime($row['tgl_pengajuan'])) ?></td>
                            <td><?= esc(ucfirst($row['status'])) ?></td>
                            <td><?= esc($row['id_user']) ?></td>
                            <td class="desc"><?= esc(strlen($row['deskripsi']) > 200 ? substr($row['deskripsi'],0,200) . '...' : $row['deskripsi']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="9">Tidak ada data pengaduan pada periode ini</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <div class="signature-block">
            <div class="signature">
                <div>Mengetahui,</div>
                <div class="title">Penanggung Jawab</div>
                <div class="name">( ........................................ )</div>
            </div>
        </div>

        <div class="footer-hr"></div>
        <div class="footer-right">
            <div><?= esc($printedAtShort ?? date('d/m/Y H:i')) ?> WIB</div>
            <div style="font-weight:700; margin-top:4px;"><?= esc($printedBy ?? 'Admin Sistem Pengaduan') ?></div>
            <div>SMKN 1 Bantul</div>
        </div>

    </div>
</body>
</html>
