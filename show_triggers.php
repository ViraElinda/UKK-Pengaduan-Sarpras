<?php

$pdo = new PDO('mysql:host=localhost;dbname=pengaduan_sarpras', 'root', '');

echo "🔍 Daftar Triggers di database:\n";
echo str_repeat("=", 70) . "\n\n";

$stmt = $pdo->query('SHOW TRIGGERS');
$triggers = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (empty($triggers)) {
    echo "❌ Tidak ada trigger\n";
} else {
    foreach ($triggers as $trigger) {
        echo "📌 Trigger: {$trigger['Trigger']}\n";
        echo "   Table: {$trigger['Table']}\n";
        echo "   Event: {$trigger['Event']}\n";
        echo "   Timing: {$trigger['Timing']}\n";
        echo str_repeat("-", 70) . "\n\n";
    }
    
    // Get detail dari setiap trigger
    echo "\n📋 Detail Trigger:\n";
    echo str_repeat("=", 70) . "\n\n";
    
    foreach ($triggers as $trigger) {
        $stmt = $pdo->query("SHOW CREATE TRIGGER `{$trigger['Trigger']}`");
        $detail = $stmt->fetch(PDO::FETCH_ASSOC);
        
        echo "Trigger: {$trigger['Trigger']}\n";
        echo "SQL Statement:\n";
        echo $detail['SQL Original Statement'] . "\n\n";
        echo str_repeat("=", 70) . "\n\n";
    }
}
