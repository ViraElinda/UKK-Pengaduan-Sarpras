<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class NoCache implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Tidak perlu aksi sebelum controller
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Hapus cache agar halaman tidak bisa diakses kembali lewat tombol back
        $response->setHeader('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
                 ->setHeader('Pragma', 'no-cache')
                 ->setHeader('Expires', '0');
    }
}
