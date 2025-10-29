<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;
use App\Models\PengaduanModel;

class PengaduanController extends BaseController
{
    protected $pengaduanModel;

    public function __construct()
    {
        $this->pengaduanModel = new PengaduanModel();
        date_default_timezone_set('Asia/Jakarta');
    }

    public function index()
    {
        return view('user/pengaduan_form');
    }

    public function store()
    {
        helper(['form', 'url']);

        $rules = [
            'nama_pengaduan' => 'required|min_length[5]|max_length[255]',
            'deskripsi'      => 'required|min_length[10]',
            'lokasi'         => 'required',
            'foto'           => 'permit_empty|is_image[foto]|max_size[foto,2048]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $data = [
            'nama_pengaduan' => $this->request->getVar('nama_pengaduan'),
            'deskripsi'      => $this->request->getVar('deskripsi'),
            'lokasi'         => $this->request->getVar('lokasi'),
            'status'         => 'Diajukan',
            'id_user'        => session()->get('id_user'),
            'tgl_pengajuan'  => date('Y-m-d H:i:s'),
        ];

        /** UPLOAD FOTO */
        $foto = $this->request->getFile('foto');

        if ($foto && $foto->isValid() && !$foto->hasMoved()) {

            $imgName = 'foto_' . time() . '.' . $foto->getExtension();
            $uploadPublic = FCPATH . "uploads/foto_pengaduan/";

            if (!is_dir($uploadPublic)) {
                mkdir($uploadPublic, 0755, true);
            }

            $foto->move($uploadPublic, $imgName);

            // resize
            \Config\Services::image()
                ->withFile($uploadPublic . $imgName)
                ->resize(800, 800, true, 'auto')
                ->save($uploadPublic . $imgName, 75);

            $data['foto'] = $imgName;
        }

        $this->pengaduanModel->insert($data);

        session()->setFlashdata('success', 'Pengaduan berhasil dikirim ✅');
        return redirect()->to(base_url('user/riwayat'));
    }


    public function riwayat()
    {
        $idUser = session()->get('id_user');

        $data['pengaduan'] = $this->pengaduanModel
            ->where('id_user', $idUser)
            ->orderBy('tgl_pengajuan', 'DESC')
            ->findAll();

        return view('user/riwayat', $data);
    }

    public function detail($id)
    {
        $pengaduan = $this->pengaduanModel->find($id);

        if (!$pengaduan) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Pengaduan tidak ditemukan");
        }

        return view('user/detail', ['pengaduan' => $pengaduan]);
    }
}
