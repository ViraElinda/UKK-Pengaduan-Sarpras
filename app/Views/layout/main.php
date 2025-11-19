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

        <!-- Minimal dark-mode CSS overrides (toggle by adding class 'dark-mode' to <html>) -->
        <style>
            :root{
                --page-bg: #f8fafc;
                --card-bg: #ffffff;
                --text-color: #111827;
                --muted: #6b7280;
                --nav-gradient: linear-gradient(to right, #4f46e5, #2563eb, #1e40af);
            }
            html.dark-mode {
                --page-bg: #0b1220;
                --card-bg: #0f1724;
                --text-color: #e6eef8;
                --muted: #9ca3af;
                --nav-gradient: linear-gradient(90deg,#0f1724,#071033);
            }
            body { background: var(--page-bg); color: var(--text-color); }
            .ui-card { background: var(--card-bg); color: var(--text-color); }
            nav.bg-gradient-to-r { background: var(--nav-gradient) !important; }
            .text-gray-600 { color: var(--muted) !important; }
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
