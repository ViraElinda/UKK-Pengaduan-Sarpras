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

        // Cek login dulu
        if (!$session->get('isLoggedIn')) {
            // belum login
            return redirect()->to('/auth/login');
        }

        // Cek role ada
        $role = $session->get('role');
        if (!$role) {
            return redirect()->to('/unauthorized');
        }

        // bandingkan dengan argumen filter
        // $arguments dari route: ['user'] jika route group('user', ['filter' => 'role:user'], ...)
        // jadi perlu explode jika ada multiple roles
        $allowed = array_map('strtolower', $arguments);

        if (!in_array(strtolower($role), $allowed)) {
            return redirect()->to('/unauthorized');
        }

        // kalau lolos, lanjut ke controller
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // tidak perlu aksi setelah
    }
}
