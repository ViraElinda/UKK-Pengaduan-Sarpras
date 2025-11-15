<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class RoleFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();

        // Jika belum login → arahkan ke login
        if (!$session->get('isLoggedIn')) {
            return redirect()->to(base_url('auth/login'));
        }

        // Ambil role user
        $role = $session->get('role');

        // Jika role tidak cocok dengan filter → arahkan ke halaman depan
        if (!in_array($role, $arguments)) {
            return redirect()->to(base_url('/'));
        }

        return null;
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // tidak perlu apa-apa
    }
}
