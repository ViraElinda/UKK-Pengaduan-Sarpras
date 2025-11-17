<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PengaduanModel;
use App\Models\LokasiModel;
use Config\Database;

class LaporanController extends BaseController
{
    protected $pengaduanModel;

    public function __construct()
    {
        $this->pengaduanModel = new PengaduanModel();
    }

    public function index()
    {
        // Provide lists for the filter selects (petugas and lokasi)
        $db = Database::connect();
        // Join petugas with users so we can show the related username and any petugas-specific photo
        $petugasList = $db->table('petugas p')
            ->select('p.id_petugas, p.nama as nama_petugas, u.id_user, u.username')
            ->join('user u', 'u.id_user = p.id_user', 'left')
            ->orderBy('p.nama', 'ASC')
            ->get()
            ->getResultArray();

        $lokasiModel = new LokasiModel();
        $lokasiList = $lokasiModel->orderBy('id_lokasi', 'ASC')->findAll();

        // Status options (key => label)
        $statusList = [
            '' => 'Semua Status',
            'diajukan' => 'Diajukan',
            'diproses' => 'Diproses',
            'selesai' => 'Selesai',
            'disetujui' => 'Disetujui',
            'ditolak' => 'Ditolak',
        ];

        $data['pengaduan'] = $this->pengaduanModel->orderBy('tgl_pengajuan', 'DESC')->findAll();
        $data['petugasList'] = $petugasList;
        $data['lokasiList'] = $lokasiList;
        $data['statusList'] = $statusList;

        return view('admin/laporan/index', $data);
    }

    public function preview()
    {
        $tgl_mulai_raw = $this->request->getPost('tgl_mulai');
        $tgl_selesai_raw = $this->request->getPost('tgl_selesai');
        $filterPetugas = $this->request->getPost('petugas');
        $filterStatus = $this->request->getPost('status');
        $filterLokasi = $this->request->getPost('lokasi');

        // Normalize date inputs (accept date-only YYYY-MM-DD or date-time)
        $tgl_mulai = $this->normalizeDateInput($tgl_mulai_raw, false);
        $tgl_selesai = $this->normalizeDateInput($tgl_selesai_raw, true);

        $builder = $this->pengaduanModel
            ->where('tgl_pengajuan >=', $tgl_mulai)
            ->where('tgl_pengajuan <=', $tgl_selesai);

        if (!empty($filterPetugas)) {
            $builder->where('id_petugas', $filterPetugas);
        }
        if (!empty($filterStatus)) {
            $builder->where('status', $filterStatus);
        }
        if (!empty($filterLokasi)) {
            $builder->where('id_lokasi', $filterLokasi);
        }

        $laporan = $builder->orderBy('tgl_pengajuan', 'ASC')->findAll();

        // prepare view data
        $data = [];
        $data['laporan'] = $laporan;
        $data['tgl_mulai'] = $tgl_mulai_raw;
        $data['tgl_selesai'] = $tgl_selesai_raw;
        $data['filterPetugas'] = $filterPetugas;
    $data['filterStatus'] = $filterStatus;
        $data['filterLokasi'] = $filterLokasi;

        // Resolve human-readable names for selected filters
        $data['filterPetugasName'] = null;
        $data['filterLokasiName'] = null;
        if (!empty($filterPetugas)) {
            // fetch petugas with user info for display
            $row = Database::connect()->table('petugas p')
                ->select('p.nama as nama_petugas, u.username')
                ->join('user u', 'u.id_user = p.id_user', 'left')
                ->where('p.id_petugas', $filterPetugas)
                ->get()
                ->getRowArray();
            if (!empty($row)) {
                $display = $row['nama_petugas'] ?? null;
                if (!empty($row['username'])) $display .= ' (' . $row['username'] . ')';
                $data['filterPetugasName'] = $display;
            } else {
                $data['filterPetugasName'] = null;
            }
        }
        if (!empty($filterLokasi)) {
            $lokasiModel = new LokasiModel();
            $lok = $lokasiModel->find($filterLokasi);
            $data['filterLokasiName'] = $lok['nama_lokasi'] ?? null;
        }
        // Resolve status label
        $data['filterStatusName'] = null;
        if (!empty($filterStatus)) {
            $map = [
                'diajukan' => 'Diajukan',
                'diproses' => 'Diproses',
                'selesai' => 'Selesai',
                'disetujui' => 'Disetujui',
                'ditolak' => 'Ditolak',
            ];
            $data['filterStatusName'] = $map[$filterStatus] ?? ucfirst($filterStatus);
        }

        if (empty($laporan)) {
            return redirect()->to('/admin/laporan')
                ->with('error', 'Tidak ada laporan di rentang tanggal tersebut.');
        }

        return view('admin/laporan/preview', $data);
    }

    public function cetak($tgl_mulai, $tgl_selesai)
    {
        // Check if user is admin. For local testing you can add ?dev=1 to bypass this check.
        $isDevBypass = $this->request->getGet('dev') === '1';
        if (!$isDevBypass && session('role') !== 'admin') {
            return redirect()->to('/auth/unauthorized');
        }

        // Clear output buffers
        while (ob_get_level()) ob_end_clean();

        $mulai = $this->normalizeDateInput($tgl_mulai, false);
        $selesai = $this->normalizeDateInput($tgl_selesai, true);

        $filterPetugas = $this->request->getGet('petugas');
    $filterStatus = $this->request->getGet('status');
        $filterLokasi = $this->request->getGet('lokasi');

        $builder = $this->pengaduanModel
            ->where('tgl_pengajuan >=', $mulai)
            ->where('tgl_pengajuan <=', $selesai);

        if (!empty($filterPetugas)) $builder->where('id_petugas', $filterPetugas);
    if (!empty($filterStatus)) $builder->where('status', $filterStatus);
        if (!empty($filterLokasi)) $builder->where('id_lokasi', $filterLokasi);

        $laporan = $builder->orderBy('tgl_pengajuan', 'ASC')->findAll();

        // stats
        $stats = ['diajukan' => 0, 'diproses' => 0, 'selesai' => 0, 'ditolak' => 0];
        foreach ($laporan as $item) {
            $status = strtolower($item['status'] ?? '');
            if (isset($stats[$status])) $stats[$status]++;
        }

        // Prepare foto data URIs so HTML-to-PDF renderers can embed images reliably
        foreach ($laporan as $k => $row) {
            $laporan[$k]['foto_data_uri'] = null;
            if (!empty($row['foto'])) {
                $possible = FCPATH . 'uploads/foto_pengaduan/' . $row['foto'];
                if (is_file($possible)) {
                    $mime = @mime_content_type($possible) ?: 'image/jpeg';
                    $data64 = base64_encode(file_get_contents($possible));
                    $laporan[$k]['foto_data_uri'] = 'data:' . $mime . ';base64,' . $data64;
                }
            }
        }

        // logo as data URI if available - try several common locations (uploads/, image/)
        $logoDataUri = null;
        $logoCandidates = [
            FCPATH . 'uploads/logo.png',
            FCPATH . 'image/logo.png',
            FCPATH . 'images/logo.png',
            FCPATH . 'assets/logo.png',
        ];
        foreach ($logoCandidates as $candidate) {
            if (is_file($candidate)) {
                $mime = @mime_content_type($candidate) ?: 'image/png';
                $logoDataUri = 'data:' . $mime . ';base64,' . base64_encode(file_get_contents($candidate));
                break;
            }
        }

        $data = [
            'laporan' => $laporan,
            'tgl_mulai' => $mulai,
            'tgl_selesai' => $selesai,
            'stats' => $stats,
            'filterPetugas' => $filterPetugas,
            'filterStatus' => $filterStatus,
            'filterLokasi' => $filterLokasi,
            'logo' => $logoDataUri,
        ];

    // Siapa yang mencetak (ambil dari session user jika tersedia)
    $session = session();
    $userSession = $session->get('user') ?? [];
    $printedBy = $userSession['nama_pengguna'] ?? $session->get('username') ?? 'Admin Sistem Pengaduan';
    $data['printedBy'] = $printedBy;

    // Use Asia/Jakarta timezone for printed timestamps (WIB)
    $now = new \DateTime('now', new \DateTimeZone('Asia/Jakarta'));
    $data['printedAt'] = $now->format('d F Y, H:i:s'); // e.g. 17 November 2025, 20:09:36
    $data['printedAtShort'] = $now->format('d/m/Y H:i');

    // Use same timezone for filename timestamp
    $filename = 'Laporan_Pengaduan_' . $now->format('Ymd_His') . '.pdf';

    $html = view('admin/laporan/pdf_template', $data);

        // Try to use Dompdf (pure-PHP HTML->PDF). If not available, instruct to install.
        if (!class_exists('\\Dompdf\\Dompdf')) {
            $autoload = ROOTPATH . 'vendor/autoload.php';
            if (is_file($autoload)) require_once $autoload;
        }
        if (!class_exists('\\Dompdf\\Dompdf')) {
            return service('response')->setStatusCode(500)->setBody("Dompdf tidak ditemukan. Jalankan 'composer require dompdf/dompdf' di direktori proyek.\n");
        }

        // Dompdf options: enable remote (for external resources) and set DPI/html5 parser
    $options = new \Dompdf\Options();
    $options->set('isRemoteEnabled', true);
    // increase DPI to improve sizing fidelity and enable HTML5 parser for better CSS handling
    $options->set('dpi', 150);
    $options->set('isHtml5ParserEnabled', true);
    $dompdf = new \Dompdf\Dompdf($options);
        // Force A4 landscape to match our template when a wide table is used
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->loadHtml($html);
        $dompdf->render();
        $output = $dompdf->output();

        return service('response')
            ->setHeader('Content-Type', 'application/pdf')
            ->setHeader('Content-Disposition', 'attachment; filename="' . $filename . '"')
            ->setBody($output);
    }

    private function normalizeDateInput($value, bool $isEnd = false): string
    {
        $v = urldecode((string)$value);
        // if just date YYYY-MM-DD
        if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $v)) {
            return $v . ($isEnd ? ' 23:59:59' : ' 00:00:00');
        }
        // replace T with space if present
        $v = str_replace('T', ' ', $v);
        // if format YYYY-MM-DD HH:MM (no seconds)
        if (preg_match('/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}$/', $v)) {
            $v .= $isEnd ? ':59' : ':00';
        }
        return $v;
    }
}

