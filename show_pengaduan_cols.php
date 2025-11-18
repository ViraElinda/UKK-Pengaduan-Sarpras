<?php
$db = new mysqli('localhost', 'root', '', 'pengaduan_sarpras');
$cols = $db->query('DESCRIBE pengaduan');
echo "Pengaduan Table Columns:\n";
while($c = $cols->fetch_assoc()) {
    echo "  - {$c['Field']} ({$c['Type']})\n";
}
