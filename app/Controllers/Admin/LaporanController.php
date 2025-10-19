<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PengaduanModel;
// tidak usah “use \TCPDF;” kalau kita pakai \TCPDF langsung

class LaporanController extends BaseController
{
    protected $pengaduanModel;

    public function __construct()
    {
        $this->pengaduanModel = new PengaduanModel();
    }

    public function index()
    {
        return view('admin/laporan/index');
    }

    public function preview()
    {
        $tgl_mulai = $this->request->getPost('tgl_mulai');
        $tgl_selesai = $this->request->getPost('tgl_selesai');

        $data['laporan'] = $this->pengaduanModel
            ->where('tgl_pengajuan >=', $tgl_mulai)
            ->where('tgl_pengajuan <=', $tgl_selesai)
            ->findAll();

        $data['tgl_mulai'] = $tgl_mulai;
        $data['tgl_selesai'] = $tgl_selesai;

        if (empty($data['laporan'])) {
            return redirect()->to('/admin/laporan')
                ->with('error', 'Tidak ada laporan di rentang tanggal tersebut.');
        }

        return view('admin/laporan/preview', $data);
    }

    public function cetak($tgl_mulai, $tgl_selesai)
    {
        $laporan = $this->pengaduanModel
            ->where('tgl_pengajuan >=', $tgl_mulai)
            ->where('tgl_pengajuan <=', $tgl_selesai)
            ->findAll();
        // pastikan kelas TCPDF tersedia (Composer mungkin belum lengkap)
        if (!class_exists('\\TCPDF')) {
            $tcpdfPath = ROOTPATH . 'vendor/tecnickcom/tcpdf/tcpdf.php';
            if (is_file($tcpdfPath)) {
                require_once $tcpdfPath;
            }
        }

        // kalau masih belum ada, tampilkan pesan yang membantu
        if (!class_exists('\\TCPDF')) {
            // kembalikan response 500 dengan instruksi singkat
            return service('response')
                ->setStatusCode(500)
                ->setBody("TCPDF class not found. Please run 'composer install' in project root or place the TCPDF library in vendor/tecnickcom/tcpdf.\n");
        }

    // Pastikan konstanta-konstanta TCPDF ada (fallback agar tidak error jika tcpdf belum
    // sepenuhnya di-load oleh composer). Nilai ini mengikuti nilai default TCPDF.
    if (!defined('PDF_PAGE_ORIENTATION')) define('PDF_PAGE_ORIENTATION', 'P');
    if (!defined('PDF_UNIT')) define('PDF_UNIT', 'mm');
    if (!defined('PDF_PAGE_FORMAT')) define('PDF_PAGE_FORMAT', 'A4');
    if (!defined('PDF_CREATOR')) define('PDF_CREATOR', 'TCPDF');
    if (!defined('PDF_FONT_NAME_MAIN')) define('PDF_FONT_NAME_MAIN', 'helvetica');
    if (!defined('PDF_FONT_SIZE_MAIN')) define('PDF_FONT_SIZE_MAIN', 10);
    if (!defined('PDF_FONT_NAME_DATA')) define('PDF_FONT_NAME_DATA', 'helvetica');
    if (!defined('PDF_FONT_SIZE_DATA')) define('PDF_FONT_SIZE_DATA', 8);
    if (!defined('PDF_MARGIN_LEFT')) define('PDF_MARGIN_LEFT', 15);
    if (!defined('PDF_MARGIN_RIGHT')) define('PDF_MARGIN_RIGHT', 15);
    if (!defined('PDF_MARGIN_TOP')) define('PDF_MARGIN_TOP', 27);
    if (!defined('PDF_MARGIN_HEADER')) define('PDF_MARGIN_HEADER', 5);
    if (!defined('PDF_MARGIN_FOOTER')) define('PDF_MARGIN_FOOTER', 10);
    if (!defined('PDF_MARGIN_BOTTOM')) define('PDF_MARGIN_BOTTOM', 25);

    // instansiasi TCPDF dengan nama global
    $pdf = new \TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Sistem Pengaduan');
        $pdf->SetTitle("Laporan Pengaduan");
        $pdf->SetHeaderData('', 0, 'Laporan Pengaduan', "$tgl_mulai s/d $tgl_selesai");
        $pdf->setHeaderFont([PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN]);
        $pdf->setFooterFont([PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA]);
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->setFontSubsetting(true);

        $pdf->AddPage();

        $pdf->SetFont('helvetica', 'B', 16);
        $pdf->Cell(0, 10, "Laporan Pengaduan $tgl_mulai s/d $tgl_selesai", 0, 1, 'C');

        $pdf->SetFont('helvetica', '', 12);
        // header tabel
        $pdf->Cell(20, 10, 'ID', 1);
        $pdf->Cell(50, 10, 'Nama Pengaduan', 1);
        $pdf->Cell(40, 10, 'Tanggal', 1);
        $pdf->Cell(30, 10, 'Status', 1);
        $pdf->Cell(0, 10, 'User', 1, 1);

        foreach ($laporan as $row) {
            $pdf->Cell(20, 8, $row['id_pengaduan'], 1);
            $pdf->Cell(50, 8, $row['nama_pengaduan'], 1);
            $pdf->Cell(40, 8, $row['tgl_pengajuan'], 1);
            $pdf->Cell(30, 8, $row['status'], 1);
            $pdf->Cell(0, 8, $row['id_user'], 1, 1);
        }

        $pdf->Output("laporan_pengaduan_{$tgl_mulai}_{$tgl_selesai}.pdf", 'I');  
    }
}
