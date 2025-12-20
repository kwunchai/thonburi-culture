<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Bulk Delete</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 800px; margin: 50px auto; padding: 20px; }
        .test-section { margin: 20px 0; padding: 20px; border: 1px solid #ddd; }
        button { padding: 10px 20px; margin: 5px; cursor: pointer; }
        #result { margin-top: 20px; padding: 15px; background: #f5f5f5; white-space: pre-wrap; }
    </style>
</head>
<body>
    <h1>Test IP Bulk Delete Directly</h1>
    
    <div class="test-section">
        <h2>Test 1: Direct Form Submission</h2>
        <form id="testForm" action="<?php echo url('/admin/ip/bulk-destroy'); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="selected_ids[]" value="1">
            <input type="hidden" name="selected_ids[]" value="2">
            <button type="submit">Submit via Form</button>
        </form>
    </div>

    <div class="test-section">
        <h2>Test 2: Fetch API</h2>
        <button onclick="testFetch()">Submit via Fetch</button>
    </div>

    <div class="test-section">
        <h2>Test 3: Check Route</h2>
        <p><strong>Route URL:</strong> <?php echo route('admin.ip.bulk-destroy'); ?></p>
        <p><strong>Full URL:</strong> <?php echo url('/admin/ip/bulk-destroy'); ?></p>
        <p><strong>Current Domain:</strong> <?php echo request()->getHost(); ?></p>
        <p><strong>APP_URL:</strong> <?php echo config('app.url'); ?></p>
    </div>

    <div id="result"></div>

    <script>
    function testFetch() {
        const formData = new FormData();
        formData.append('_token', document.querySelector('input[name="_token"]').value);
        formData.append('selected_ids[]', '1');
        formData.append('selected_ids[]', '2');

        const url = '<?php echo route('admin.ip.bulk-destroy'); ?>';
        
        document.getElementById('result').textContent = 'Sending request to: ' + url + '\n\nWaiting for response...';

        fetch(url, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            },
            credentials: 'same-origin'
        })
        .then(response => {
            const resultText = `Status: ${response.status} ${response.statusText}\n` +
                             `URL: ${response.url}\n` +
                             `Redirected: ${response.redirected}\n` +
                             `Type: ${response.type}\n\n`;
            
            return response.text().then(text => {
                document.getElementById('result').textContent = resultText + 'Response:\n' + text;
            });
        })
        .catch(error => {
            document.getElementById('result').textContent = 'Error: ' + error.message + '\n\n' + error.stack;
        });
    }
    </script>
</body>
</html>
