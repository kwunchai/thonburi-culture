<!DOCTYPE html>
<html>
<head>
    <title>Test Bulk Delete Form Submission</title>
</head>
<body>
    <h1>Test IP Bulk Delete</h1>
    
    <p>This page tests if the form submission works correctly.</p>
    
    <button type="button" onclick="testFormSubmit()">Test Form Submit</button>
    
    <hr>
    
    <form id="bulkDeleteForm" action="<?php echo route('admin.ip.bulk-destroy'); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <input type="checkbox" name="selected_ids[]" value="1" checked> Item 1<br>
        <input type="checkbox" name="selected_ids[]" value="2" checked> Item 2<br>
        <input type="checkbox" name="selected_ids[]" value="3" checked> Item 3<br>
        <br>
        <button type="submit">Direct Submit</button>
    </form>
    
    <script>
    function testFormSubmit() {
        const form = document.getElementById('bulkDeleteForm');
        console.log('Form found:', form);
        console.log('Form action:', form.action);
        console.log('Form method:', form.method);
        
        if (confirm('Submit the form via JavaScript?')) {
            form.submit();
        }
    }
    </script>
    
    <hr>
    <p><strong>Route URL:</strong> <?php echo route('admin.ip.bulk-destroy'); ?></p>
    <p><strong>Current URL:</strong> <?php echo url()->current(); ?></p>
    <p><strong>APP_URL:</strong> <?php echo config('app.url'); ?></p>
</body>
</html>
