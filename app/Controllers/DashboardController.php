<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class DashboardController extends BaseController
{
     public function admin()
    {
        if(session('role') !== 'admin') {
            return redirect()->to('/auth/unauthorized');
        }
        return view('dashboard/admin');
    }

    public function petugas()
    {
        if(session('role') !== 'petugas') {
            return redirect()->to('/auth/unauthorized');
        }
        return view('dashboard/petugas');
    }

    public function guru()
    {
        if(session('role') !== 'guru') {
            return redirect()->to('/auth/unauthorized');
        }
        return view('dashboard/guru');
    }

    public function siswa()
    {
        if(session('role') !== 'siswa') {
            return redirect()->to('/auth/unauthorized');
        }
        return view('dashboard/siswa');
    }
}
    