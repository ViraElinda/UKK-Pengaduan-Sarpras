<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    
    <!-- Prevent Caching - No Back After Logout -->
    <meta http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate, max-age=0" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />
    
    <title><?= $this->renderSection('title') ?? 'Pengaduan Sarpras' ?></title>

    <!-- Bootstrap CSS dari CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Global UI styles to complement Tailwind -->
    <link rel="stylesheet" href="<?= base_url('css/ui.css') ?>">

        <!-- Minimal dark-mode CSS overrides (toggle by adding class 'dark-mode' to <html>).
             NOTE: these overrides are intentionally scoped to the navbar and its mobile menu only
             so they do NOT change page-level backgrounds or form input colors. -->
        <style>
            :root{
                --nav-gradient: linear-gradient(to right, #4f46e5, #2563eb, #1e40af);
                --nav-text: #ffffff;
                --nav-muted: rgba(255,255,255,0.8);
            }
            html.dark-mode {
                /* Dark-mode colors for navbar only */
                --nav-gradient: linear-gradient(90deg,#0f1724,#071033);
                --nav-text: #e6eef8;
                --nav-muted: rgba(156,163,175,0.95);
            }

            /* Apply only to navbar / mobile menu UI elements */
            nav.bg-gradient-to-r { background: var(--nav-gradient) !important; }
            nav, nav * { color: var(--nav-text) !important; }
            .mobile-menu-ui { background: var(--nav-gradient) !important; }
            /* muted text inside nav (overrides utility classes where needed) */
            nav .text-gray-600, nav .text-indigo-100 { color: var(--nav-muted) !important; }
        </style>

        <!-- Apply saved theme ASAP to avoid flash -->
        <script>
            (function(){
                try {
                    var t = localStorage.getItem('theme');
                    if(t === 'dark') document.documentElement.classList.add('dark-mode');
                } catch(e) { /* ignore */ }
            })();
        </script>

    <!-- Section untuk tambahan <head> jika diperlukan -->
    <?= $this->renderSection('head') ?>
</head>
<body class="m-0 p-0 overflow-x-hidden">

    <?= view('navbar/user') ?>

    <!-- Konten halaman -->
    <?= $this->renderSection('content') ?>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Prevent Back After Logout -->
    <script>
        (function() {
            // Disable browser back button
            function preventBack() {
                window.history.forward();
            }
            setTimeout("preventBack()", 0);
            window.onunload = function() { null };
            
            // Alternative method
            window.history.pushState(null, "", window.location.href);
            window.onpopstate = function() {
                window.history.pushState(null, "", window.location.href);
            };

            // Force reload on back button (clear cache)
            window.addEventListener('pageshow', function(event) {
                if (event.persisted || (window.performance && window.performance.navigation.type === 2)) {
                    // Page was loaded from cache (back button or forward button)
                    window.location.reload(true);
                }
            });
        })();
    </script>

    <!-- Section untuk tambahan script jika dibutuhkan -->
    <?= $this->renderSection('scripts') ?>
    
</body>
</html>
