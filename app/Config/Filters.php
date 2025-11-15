<?php

namespace Config;

use CodeIgniter\Config\Filters as BaseFilters;
use CodeIgniter\Filters\CSRF;
use CodeIgniter\Filters\DebugToolbar;
use CodeIgniter\Filters\Honeypot;
use CodeIgniter\Filters\InvalidChars;
use CodeIgniter\Filters\SecureHeaders;

class Filters extends BaseFilters
{
    public array $aliases = [
        'csrf'          => CSRF::class,
        'toolbar'       => DebugToolbar::class,
        'honeypot'      => Honeypot::class,
        'invalidchars'  => InvalidChars::class,
        'secureheaders' => SecureHeaders::class,

        // Custom filters
        'role'    => \App\Filters\RoleFilter::class,
        'auth'    => \App\Filters\AuthFilter::class,
        'guest'   => \App\Filters\GuestFilter::class,
        'nocache' => \App\Filters\NoCache::class,
    ];

    public array $required = [
        'before' => [],
        'after'  => [],
    ];

    public array $globals = [
        'before' => [
            // 'csrf', // aktifkan kalau perlu
        ],
        'after' => [
            'toolbar',
            'nocache', // cegah cache global
        ],
    ];

    public array $methods = [];

    public array $filters = [
        'auth' => [
            'before' => [
                'admin/*',
                'petugas/*',
                'user/*',
            ],
        ],
    ];
}
