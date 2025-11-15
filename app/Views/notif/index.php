<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifikasi - Pengaduan Sarpras</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen">
    <!-- Navbar -->
    <?php
    $role = session('role');
    if ($role === 'admin') {
        echo view('navbar/admin');
    } elseif ($role === 'petugas') {
        echo view('navbar/petugas');
    } else {
        echo view('navbar/user');
    }
    ?>

    <!-- Content -->
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto">
            <!-- Header -->
            <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-800 mb-2">Notifikasi</h1>
                        <p class="text-gray-600">Semua pemberitahuan dan update untuk Anda</p>
                    </div>
                    <!-- Removed manual "Tandai Semua Dibaca" button.
                         Notifications are marked read when this page loads (server-side) or when opening the bell dropdown. -->
                </div>
            </div>

            <!-- Notifications List -->
            <div id="notificationsList" class="space-y-4">
                <!-- Akan diisi dengan JavaScript -->
            </div>

            <!-- Empty State -->
            <div id="emptyState" class="bg-white rounded-lg shadow-lg p-12 text-center hidden">
                <svg class="w-24 h-24 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                </svg>
                <h3 class="text-xl font-semibold text-gray-700 mb-2">Tidak Ada Notifikasi</h3>
                <p class="text-gray-500">Anda belum memiliki notifikasi saat ini</p>
            </div>
        </div>
    </div>

    <script>
        // Load notifications
        async function loadNotifications() {
            try {
                const response = await fetch('<?= base_url('notif/get') ?>');
                const data = await response.json();
                
                const container = document.getElementById('notificationsList');
                const emptyState = document.getElementById('emptyState');
                
                if (data.notifications.length === 0) {
                    container.classList.add('hidden');
                    emptyState.classList.remove('hidden');
                    return;
                }
                
                container.classList.remove('hidden');
                emptyState.classList.add('hidden');
                
                container.innerHTML = data.notifications.map(notif => {
                    const tipeColors = {
                        'info': 'bg-blue-100 text-blue-600 border-blue-200',
                        'success': 'bg-green-100 text-green-600 border-green-200',
                        'warning': 'bg-yellow-100 text-yellow-600 border-yellow-200',
                        'danger': 'bg-red-100 text-red-600 border-red-200'
                    };
                    
                    const tipeIcons = {
                        'info': '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>',
                        'success': '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>',
                        'warning': '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>',
                        'danger': '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>'
                    };
                    
                    const bgClass = notif.is_read == 0 ? 'bg-blue-50' : 'bg-white';
                    const borderClass = notif.is_read == 0 ? 'border-l-4 border-blue-600' : '';
                    
                    return `
                        <div class="${bgClass} ${borderClass} rounded-lg shadow-md hover:shadow-lg transition-shadow duration-200 p-6 cursor-pointer" onclick="handleNotifClick(${notif.id_notif}, '${notif.link || ''}')">
                            <div class="flex items-start gap-4">
                                <div class="flex-shrink-0">
                                    <div class="${tipeColors[notif.tipe]} p-3 rounded-full border-2">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            ${tipeIcons[notif.tipe]}
                                        </svg>
                                    </div>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-start justify-between gap-4">
                                        <div class="flex-1">
                                            <h3 class="text-lg font-semibold text-gray-800 mb-1">${notif.judul}</h3>
                                            <p class="text-gray-600 mb-2">${notif.pesan}</p>
                                            <p class="text-sm text-gray-400">${timeAgo(notif.created_at)}</p>
                                        </div>
                                        ${notif.is_read == 0 ? '<span class="flex-shrink-0 px-3 py-1 bg-blue-600 text-white text-xs font-semibold rounded-full">Baru</span>' : ''}
                                    </div>
                                </div>
                                <button onclick="deleteNotif(event, ${notif.id_notif})" class="flex-shrink-0 text-gray-400 hover:text-red-600 transition-colors duration-200">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    `;
                }).join('');
            } catch (error) {
                console.error('Error loading notifications:', error);
            }
        }
        
        // Handle notification click
        async function handleNotifClick(idNotif, link) {
            try {
                await fetch(`<?= base_url('notif/read/') ?>${idNotif}`, {
                    method: 'POST'
                });
                
                if (link) {
                    window.location.href = '<?= base_url() ?>' + link;
                } else {
                    loadNotifications();
                }
            } catch (error) {
                console.error('Error marking as read:', error);
            }
        }
        
        // Mark all as read
        async function markAllAsRead() {
            try {
                await fetch('<?= base_url('notif/read-all') ?>', {
                    method: 'POST'
                });
                loadNotifications();
            } catch (error) {
                console.error('Error marking all as read:', error);
            }
        }
        
        // Delete notification
        async function deleteNotif(event, idNotif) {
            event.stopPropagation();
            
            if (!confirm('Hapus notifikasi ini?')) return;
            
            try {
                await fetch(`<?= base_url('notif/delete/') ?>${idNotif}`, {
                    method: 'DELETE'
                });
                loadNotifications();
            } catch (error) {
                console.error('Error deleting notification:', error);
            }
        }
        
        // Time ago helper
        function timeAgo(timestamp) {
            const now = new Date();
            const time = new Date(timestamp);
            const diff = Math.floor((now - time) / 1000);
            
            if (diff < 60) return 'Baru saja';
            if (diff < 3600) return Math.floor(diff / 60) + ' menit yang lalu';
            if (diff < 86400) return Math.floor(diff / 3600) + ' jam yang lalu';
            if (diff < 604800) return Math.floor(diff / 86400) + ' hari yang lalu';
            if (diff < 2592000) return Math.floor(diff / 604800) + ' minggu yang lalu';
            return Math.floor(diff / 2592000) + ' bulan yang lalu';
        }
        
        // Initial load
        loadNotifications();
        
        // Auto refresh every 30 seconds
        setInterval(loadNotifications, 30000);
    </script>
</body>
</html>
