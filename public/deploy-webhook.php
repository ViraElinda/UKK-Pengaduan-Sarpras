<?php
// deploy-webhook.php
$log_file = '/var/www/UKK-Pengaduan-Sarpras/deploy.log';

// === TOKEN ANDA ===
$secret = 'aku-suka-rama-rudi';

file_put_contents($log_file, date('Y-m-d H:i:s') . " - Webhook started\n", FILE_APPEND);

// Get signature from GitHub header
$hub_signature = $_SERVER['HTTP_X_HUB_SIGNATURE_256'] ?? '';
$github_event = $_SERVER['HTTP_X_GITHUB_EVENT'] ?? '';

file_put_contents($log_file, "Event: $github_event\nSignature: $hub_signature\n", FILE_APPEND);

// Get payload
$payload = file_get_contents('php://input');

// Verify GitHub signature
$calculated_signature = 'sha256=' . hash_hmac('sha256', $payload, $secret);
file_put_contents($log_file, "Calculated: $calculated_signature\n", FILE_APPEND);

if (!hash_equals($hub_signature, $calculated_signature)) {
    file_put_contents($log_file, "ERROR: Signature mismatch!\n", FILE_APPEND);
    http_response_code(403);
    die('Error: Invalid or missing secret token.');
}

file_put_contents($log_file, "Signature valid! Starting deployment...\n", FILE_APPEND);

// Process push event to main branch
if ($github_event === 'push') {
    $data = json_decode($payload, true);
    $ref = $data['ref'] ?? '';
    
    file_put_contents($log_file, "Branch: $ref\n", FILE_APPEND);
    
    if ($ref === 'refs/heads/main') {
        // Change to project directory
        chdir('/var/www/UKK-Pengaduan-Sarpras');
        
        // Git commands
        exec('git reset --hard HEAD 2>&1', $output_reset);
        exec('git pull origin main 2>&1', $output_pull);
        
        $output = array_merge($output_reset, $output_pull);
        file_put_contents($log_file, "Git output: " . implode("\n", $output) . "\n", FILE_APPEND);
        
        // Fix permissions
        exec('chmod -R 755 /var/www/UKK-Pengaduan-Sarpras 2>&1');
        exec('chmod -R 775 /var/www/UKK-Pengaduan-Sarpras/writable 2>&1');
        
        file_put_contents($log_file, "Deployment completed successfully!\n", FILE_APPEND);
        
        http_response_code(200);
        echo "Deployment successful!";
    } else {
        file_put_contents($log_file, "Not main branch, skipping deployment\n", FILE_APPEND);
        echo "Not main branch";
    }
} else {
    file_put_contents($log_file, "Not push event: $github_event\n", FILE_APPEND);
    echo "Not push event";
}
?>