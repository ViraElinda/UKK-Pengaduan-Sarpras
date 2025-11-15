<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class GuestFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();

        // Sudah login → langsung ke dashboard sesuai role
        if ($session->get('isLoggedIn')) {
            switch ($session->get('role')) {
                case 'admin':
                    return redirect()->to(base_url('admin/dashboard'));
                case 'petugas':
                    return redirect()->to(base_url('petugas/dashboard'));
                case 'user':
                    return redirect()->to(base_url('user/dashboard'));
                default:
                    return redirect()->to(base_url('/'));
            }
        }

        // Belum login → lanjutkan akses ke landing / login / register
        return null;
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}
