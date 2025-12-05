<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Authentication</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 py-8">
    <div class="max-w-md mx-auto bg-white p-8 rounded-lg shadow-md">
        <h1 class="text-2xl font-bold mb-6 text-center">Test Authentication</h1>
        
        <!-- Current Auth Status -->
        <div class="mb-6 p-4 bg-blue-50 rounded">
            <h3 class="font-semibold mb-2">Current Status:</h3>
            @auth
                <p class="text-green-600">✅ Logged in as: {{ Auth::user()->email }}</p>
                <p class="text-green-600">Role: {{ Auth::user()->role }}</p>
            @else
                <p class="text-red-600">❌ Not logged in</p>
            @endauth
        </div>

        <!-- Test Login Form -->
        <form id="testLoginForm" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium mb-1">Email:</label>
                <input type="email" id="email" name="email" value="admin@test.com" 
                       class="w-full px-3 py-2 border rounded focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Password:</label>
                <input type="password" id="password" name="password" placeholder="Enter password"
                       class="w-full px-3 py-2 border rounded focus:ring-2 focus:ring-blue-500">
            </div>
            <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">
                Test Login
            </button>
        </form>

        <div id="result" class="mt-6 p-4 rounded" style="display:none;"></div>

        <!-- Quick Links -->
        <div class="mt-6 space-y-2">
            <h3 class="font-semibold">Quick Links:</h3>
            <ul class="space-y-1">
                <li><a href="/login" class="text-blue-600 hover:underline">Official Login</a></li>
                <li><a href="/admin/dashboard" class="text-blue-600 hover:underline">Admin Dashboard</a></li>
                <li><a href="/admin/activities" class="text-blue-600 hover:underline">Activities Admin</a></li>
                <li><a href="/logout" class="text-red-600 hover:underline">Logout</a></li>
            </ul>
        </div>
    </div>

    <script>
        document.getElementById('testLoginForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const result = document.getElementById('result');
            
            try {
                const response = await fetch('/test-login', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('[name="_token"]').value
                    }
                });
                
                const data = await response.json();
                
                result.style.display = 'block';
                if (data.success) {
                    result.className = 'mt-6 p-4 rounded bg-green-50 text-green-700';
                    result.innerHTML = `
                        <h4 class="font-semibold">✅ Login Successful!</h4>
                        <p>Email: ${data.user.email}</p>
                        <p>Name: ${data.user.name}</p>
                        <p>Role: ${data.user.role}</p>
                        <button onclick="window.location.reload()" class="mt-2 px-4 py-2 bg-green-600 text-white rounded">
                            Refresh Page
                        </button>
                    `;
                } else {
                    result.className = 'mt-6 p-4 rounded bg-red-50 text-red-700';
                    result.innerHTML = `
                        <h4 class="font-semibold">❌ Login Failed</h4>
                        <p>${data.message}</p>
                    `;
                }
            } catch (error) {
                result.style.display = 'block';
                result.className = 'mt-6 p-4 rounded bg-red-50 text-red-700';
                result.innerHTML = `
                    <h4 class="font-semibold">❌ Error</h4>
                    <p>${error.message}</p>
                `;
            }
        });
    </script>
</body>
</html>