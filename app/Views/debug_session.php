<!DOCTYPE html>
<html>
<head>
    <title>Debug Session</title>
</head>
<body>
    <h1>Debug Session Info</h1>
    <pre><?php
    session_start();
    echo "Session ID: " . session_id() . "\n\n";
    echo "Session Data:\n";
    print_r($_SESSION);
    
    echo "\n\nCodeIgniter Session:\n";
    $session = \Config\Services::session();
    echo "Is Logged In: " . ($session->get('isLoggedIn') ? 'YES' : 'NO') . "\n";
    echo "User ID: " . $session->get('id_user') . "\n";
    echo "Username: " . $session->get('username') . "\n";
    echo "Role: " . $session->get('role') . "\n";
    ?></pre>
</body>
</html>
