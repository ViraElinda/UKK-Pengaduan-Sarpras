<!-- Notification Bell Component -->
<div class="relative" id="notifDropdown">
    <!-- Bell Icon -->
    <button type="button" class="relative text-white hover:text-white/80 transition-colors" id="notifBtn">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
        </svg>
        <!-- Badge untuk jumlah notif belum dibaca -->
        <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs font-bold rounded-full w-5 h-5 flex items-center justify-center" id="notifBadge" style="display: none;">0</span>
    </button>

    <!-- Dropdown Menu -->
    <div class="absolute right-0 mt-2 w-80 bg-white rounded-xl shadow-2xl border border-gray-200 hidden z-50" id="notifMenu">
        <!-- Header -->
        <div class="px-4 py-3 border-b border-gray-200 flex justify-between items-center">
            <h3 class="font-bold text-gray-900">Notifikasi</h3>
            <!-- Removed explicit "Tandai Semua Dibaca" button.
                 Notifications will be marked read automatically when the dropdown is opened (Instagram-like behavior). -->
        </div>

        <!-- Notifikasi List -->
        <div class="max-h-96 overflow-y-auto" id="notifList">
            <div class="px-4 py-8 text-center text-gray-500">
                <svg class="w-12 h-12 mx-auto mb-2 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                </svg>
                <p class="text-sm">Belum ada notifikasi</p>
            </div>
        </div>

        <!-- Footer -->
        <div class="px-4 py-3 border-t border-gray-200 text-center">
            <a href="<?= base_url(session('role') . '/notifikasi') ?>" class="text-sm text-blue-600 hover:text-blue-700 font-semibold">
                Lihat Semua Notifikasi
            </a>
        </div>
    </div>
</div>

<script>
// Notification JavaScript (uses in-page toasts)
(function() {
    const notifBtn = document.getElementById('notifBtn');
    const notifMenu = document.getElementById('notifMenu');
    const notifList = document.getElementById('notifList');
    const notifBadge = document.getElementById('notifBadge');

    // Toggle dropdown
    notifBtn.addEventListener('click', function(e) {
        e.stopPropagation();
        notifMenu.classList.toggle('hidden');
        if (!notifMenu.classList.contains('hidden')) {
            // Load notifications then mark them as read (Instagram-like)
            loadNotifications().then(() => {
                // After notifications are loaded and rendered, mark all as read on the server
                fetch('<?= base_url('notif/read-all') ?>', { method: 'POST', credentials: 'include' })
                    .then(() => {
                        // Clear badge locally
                        updateNotifBadge(0);
                    }).catch(err => {
                        // ignore errors; endpoint might not exist yet in some environments
                        console.warn('Gagal menandai notif sebagai dibaca:', err);
                    });
            });
        }
    });

    // Close dropdown when clicking outside
    document.addEventListener('click', function(e) {
        if (!notifBtn.contains(e.target) && !notifMenu.contains(e.target)) {
            notifMenu.classList.add('hidden');
        }
    });

    // Load notifications via AJAX
    function loadNotifications() {
        fetch('<?= base_url('notif/get') ?>', { credentials: 'include' })
            .then(response => {
                // If server redirected to login page, response will be HTML not JSON
                const ct = response.headers.get('content-type') || '';
                if (!ct.includes('application/json')) {
                    console.warn('Notif: unexpected response content-type', ct);
                    return { notifications: [], unread_count: 0 };
                }
                return response.json();
            })
            .then(data => {
                console.log('Notif data:', data); // Debug
                if (data && (data.success || data.notifications)) {
                    updateNotifBadge(data.unread_count || 0);
                    renderNotifications(data.notifications || []);
                }
            })
            .catch(error => console.error('Error loading notifications:', error));
    }

    // Update badge
    function updateNotifBadge(count) {
        if (count > 0) {
            notifBadge.textContent = count > 99 ? '99+' : count;
            notifBadge.style.display = 'flex';
        } else {
            notifBadge.style.display = 'none';
        }
    }

    // Render notifications
    function renderNotifications(notifikasi) {
        if (notifikasi.length === 0) {
            notifList.innerHTML = `
                <div class="px-4 py-8 text-center text-gray-500">
                    <svg class="w-12 h-12 mx-auto mb-2 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                    <p class="text-sm">Belum ada notifikasi</p>
                </div>
            `;
            return;
        }

        let html = '';
        notifikasi.forEach(notif => {
            const bgColor = notif.is_read == 0 ? 'bg-blue-50' : 'bg-white';
            const tipeColor = {
                'info': 'text-blue-600 bg-blue-100',
                'success': 'text-green-600 bg-green-100',
                'warning': 'text-orange-600 bg-orange-100',
                'danger': 'text-red-600 bg-red-100'
            };
            
            html += `
                <div class="px-4 py-3 border-b border-gray-100 hover:bg-gray-50 cursor-pointer transition-colors ${bgColor}" data-id="${notif.id_notif}" data-link="${notif.link || ''}" onclick="handleNotifClick(this)">
                    <div class="flex items-start gap-3">
                        <div class="flex-shrink-0">
                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full ${tipeColor[notif.tipe] || tipeColor['info']}">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-gray-900">${notif.judul}</p>
                            <p class="text-xs text-gray-600 mt-1">${notif.pesan}</p>
                            <p class="text-xs text-gray-400 mt-1">${timeAgo(notif.created_at)}</p>
                        </div>
                        ${notif.is_read == 0 ? '<div class="flex-shrink-0"><span class="inline-block w-2 h-2 bg-blue-600 rounded-full"></span></div>' : ''}
                    </div>
                </div>
            `;
        });

        notifList.innerHTML = html;
    }

    // Handle notif click
    window.handleNotifClick = function(element) {
        const id = element.dataset.id;
        const link = element.dataset.link;

        // Mark as read
        fetch(`<?= base_url('notif/read/') ?>${id}`, { method: 'POST', credentials: 'include' })
            .then(() => {
                if (link && link !== 'null' && link !== '') {
                    window.location.href = '<?= base_url() ?>' + link;
                } else {
                    loadNotifications();
                }
            }).catch(err => {
                console.warn('Gagal menandai notif sebagai dibaca:', err);
            });
    };

    // No manual "mark all" button: notifications are marked as read when the dropdown is opened.

    // Time ago helper
    function timeAgo(datetime) {
        const now = new Date();
        const created = new Date(datetime);
        const diff = Math.floor((now - created) / 1000);

        if (diff < 60) return 'Baru saja';
        if (diff < 3600) return Math.floor(diff / 60) + ' menit lalu';
        if (diff < 86400) return Math.floor(diff / 3600) + ' jam lalu';
        if (diff < 604800) return Math.floor(diff / 86400) + ' hari lalu';
        return created.toLocaleDateString('id-ID');
    }

    // Track last known unread count to detect new notifications
    let lastUnread = 0;

    // Load notifications on page load to populate badge and set baseline
    function initialLoad() {
        return fetch('<?= base_url('notif/get') ?>', { credentials: 'include' })
            .then(response => {
                const ct = response.headers.get('content-type') || '';
                if (!ct.includes('application/json')) return { notifications: [], unread_count: 0 };
                return response.json();
            })
            .then(data => {
                if (data && (data.success || data.notifications)) {
                    updateNotifBadge(data.unread_count || 0);
                    lastUnread = data.unread_count || 0;
                    // Render list only when dropdown opened; keep minimal DOM updates now
                }
            })
            .catch(() => {});
    }

    initialLoad();

    // Auto-poll notifikasi setiap 15 detik; if there's a new unread > lastUnread, fetch latest and show toast
    setInterval(function() {
        fetch('<?= base_url('notif/get') ?>', { credentials: 'include' })
            .then(response => {
                const ct = response.headers.get('content-type') || '';
                if (!ct.includes('application/json')) return null;
                return response.json();
            })
            .then(data => {
                if (!data) return;
                const unread = data.unread_count || 0;
                // update badge always
                updateNotifBadge(unread);

                if (unread > lastUnread) {
                    // New notification(s) arrived. Fetch the latest notifications to display popup content.
                    fetch('<?= base_url('notif/get') ?>', { credentials: 'include' })
                        .then(r => {
                            const ct = r.headers.get('content-type') || '';
                            if (!ct.includes('application/json')) return null;
                            return r.json();
                        })
                        .then(d => {
                            const newest = (d && d.notifications && d.notifications[0]) ? d.notifications[0] : null;
                            if (newest) {
                                    // Show toast popup using in-page toast
                                    showToast({
                                        type: newest.tipe || 'info',
                                        title: newest.judul || 'Notifikasi',
                                        message: newest.pesan || ''
                                    });
                            }
                        }).catch(() => {});
                }

                lastUnread = unread;
            })
            .catch(() => {
                // ignore network errors silently to avoid console spam
            });
    }, 15000);
})();
</script>

<!-- Inline minimal toast implementation (replaces SweetAlert2 toasts) -->
<style>
    #toastContainer{ position: fixed; top: 1rem; right: 1rem; z-index: 99999; display: flex; flex-direction: column; gap: .5rem; }
    .toastItem{ min-width: 240px; max-width: 360px; background: #111827; color: #fff; padding: .75rem 1rem; border-radius: .5rem; box-shadow: 0 6px 18px rgba(17,24,39,0.35); display:flex; gap:.75rem; align-items:flex-start; }
    .toastItem .toastIcon{ width:32px;height:32px;border-radius:.375rem;display:flex;align-items:center;justify-content:center;font-weight:700;color:#fff }
    .toastItem .toastContent{ flex:1 }
    .toastItem .toastTitle{ font-weight:600; font-size:0.95rem }
    .toastItem .toastMsg{ font-size:0.85rem; opacity:0.9 }
    .toast-success{ background: linear-gradient(90deg,#065f46,#10b981); }
    .toast-info{ background: linear-gradient(90deg,#0f1724,#2563eb); }
    .toast-warning{ background: linear-gradient(90deg,#92400e,#f59e0b); }
    .toast-danger{ background: linear-gradient(90deg,#7f1d1d,#ef4444); }
</style>

<div id="toastContainer" aria-live="polite" aria-atomic="true"></div>

<script>
function showToast({ type = 'info', title = '', message = '', timeout = 5000 }){
    try{
        const container = document.getElementById('toastContainer');
        if(!container) return;
        const item = document.createElement('div');
        item.className = 'toastItem toast-' + (type || 'info');

        const icon = document.createElement('div');
        icon.className = 'toastIcon';
        if(type === 'success') icon.textContent = '✓';
        else if(type === 'warning') icon.textContent = '!';
        else if(type === 'danger' || type === 'error') icon.textContent = '✕';
        else icon.textContent = 'i';

        const content = document.createElement('div');
        content.className = 'toastContent';
        const t = document.createElement('div'); t.className = 'toastTitle'; t.textContent = title;
        const m = document.createElement('div'); m.className = 'toastMsg'; m.textContent = message;
        content.appendChild(t); content.appendChild(m);

        const closeBtn = document.createElement('button');
        closeBtn.type = 'button';
        closeBtn.className = 'ml-2 text-sm text-white opacity-80';
        closeBtn.textContent = '×';
        closeBtn.style.background = 'transparent';
        closeBtn.style.border = 'none';
        closeBtn.style.cursor = 'pointer';
        closeBtn.addEventListener('click', () => { item.remove(); });

        item.appendChild(icon);
        item.appendChild(content);
        item.appendChild(closeBtn);
        container.prepend(item);

        setTimeout(() => { item.remove(); }, timeout);
    }catch(e){ console.warn('Toast error', e); }
}
</script>
