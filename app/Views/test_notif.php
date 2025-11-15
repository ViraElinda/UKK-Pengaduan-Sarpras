<!DOCTYPE html>
<html>
<head>
    <title>Test Notif API</title>
</head>
<body>
    <h1>Test Notifikasi API</h1>
    <button onclick="testAPI()">Test Get Notifications</button>
    <pre id="result"></pre>

    <script>
        function testAPI() {
            fetch('<?= base_url('notif/get') ?>')
                .then(response => response.json())
                .then(data => {
                    document.getElementById('result').textContent = JSON.stringify(data, null, 2);
                    console.log('API Response:', data);
                })
                .catch(error => {
                    document.getElementById('result').textContent = 'Error: ' + error;
                    console.error('Error:', error);
                });
        }

        // Auto test on load
        testAPI();
    </script>
</body>
</html>
