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
        // Check if user is admin
        if (session('role') !== 'admin') {
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

        // prepare foto paths for TCPDF
        foreach ($laporan as $k => $row) {
            $laporan[$k]['foto_path'] = null;
            if (!empty($row['foto'])) {
                $possible = FCPATH . 'uploads/foto_pengaduan/' . $row['foto'];
                if (is_file($possible)) $laporan[$k]['foto_path'] = $possible;
            }
        }

        // ensure TCPDF
        if (!class_exists('\\TCPDF')) {
            $tcpdfPath = ROOTPATH . 'vendor/tecnickcom/tcpdf/tcpdf.php';
            if (is_file($tcpdfPath)) require_once $tcpdfPath;
        }
        if (!class_exists('\\TCPDF')) {
            return service('response')->setStatusCode(500)->setBody("TCPDF tidak ditemukan. Jalankan 'composer install'.\n");
        }

        // PDF setup
        if (!defined('PDF_PAGE_ORIENTATION')) define('PDF_PAGE_ORIENTATION', 'L');
        if (!defined('PDF_UNIT')) define('PDF_UNIT', 'mm');
        if (!defined('PDF_PAGE_FORMAT')) define('PDF_PAGE_FORMAT', 'A4');
        if (!defined('PDF_CREATOR')) define('PDF_CREATOR', 'Sistem Pengaduan Sarpras');

        $pdf = new \TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetCreator('Sistem Pengaduan Sarpras');
        $pdf->SetAuthor('Admin Sekolah');
        $pdf->SetTitle('Laporan Pengaduan Sarana & Prasarana');
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->SetMargins(12, 12, 12);
        $pdf->SetAutoPageBreak(true, 15);
        $pdf->SetFont('dejavusans', '', 10);
        $pdf->setImageScale(1.25);
        $pdf->AddPage();

        $data = [
            'laporan' => $laporan,
            'tgl_mulai' => $mulai,
            'tgl_selesai' => $selesai,
            'stats' => $stats,
            'filterPetugas' => $filterPetugas,
            'filterStatus' => $filterStatus,
            'filterLokasi' => $filterLokasi,
        ];

        $logoPath = FCPATH . 'uploads/logo.png';
        $data['logo'] = is_file($logoPath) ? $logoPath : null;

        $html = view('admin/laporan/pdf_template', $data);
        $pdf->writeHTML($html, true, false, true, false, '');

        $filename = 'Laporan_Pengaduan_' . date('Ymd_His') . '.pdf';
        $pdf->Output($filename, 'D');
        exit;
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

