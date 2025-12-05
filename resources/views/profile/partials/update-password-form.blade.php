<section>
    <header class="mb-6">
        <h2 class="text-xl font-bold text-gray-900">
            เปลี่ยนรหัสผ่าน
        </h2>
        <p class="mt-2 text-sm text-gray-600">
            ใช้รหัสผ่านที่ยาวและสุ่มเพื่อความปลอดภัยของบัญชี
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="space-y-6">
        @csrf
        @method('put')

        <!-- Current Password -->
        <div>
            <label for="current_password" class="block text-sm font-semibold text-gray-700 mb-2">
                <i class="fas fa-lock mr-2 text-blue-500"></i>รหัสผ่านปัจจุบัน
            </label>
            <div class="relative">
                <input 
                    id="current_password" 
                    name="current_password" 
                    type="password" 
                    autocomplete="current-password"
                    class="w-full px-4 py-3 pr-12 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                    placeholder="กรอกรหัสผ่านปัจจุบัน"
                />
                <button type="button" onclick="togglePasswordVisibility('current_password')" class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-blue-500">
                    <i id="current_password_icon" class="fas fa-eye"></i>
                </button>
            </div>
            @error('current_password', 'updatePassword')
                <p class="mt-2 text-sm text-red-600 flex items-center">
                    <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                </p>
            @enderror
        </div>

        <!-- New Password -->
        <div>
            <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                <i class="fas fa-key mr-2 text-blue-500"></i>รหัสผ่านใหม่
            </label>
            <div class="relative">
                <input 
                    id="password" 
                    name="password" 
                    type="password" 
                    autocomplete="new-password"
                    class="w-full px-4 py-3 pr-12 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                    placeholder="กรอกรหัสผ่านใหม่ (อย่างน้อย 8 ตัวอักษร)"
                />
                <button type="button" onclick="togglePasswordVisibility('password')" class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-blue-500">
                    <i id="password_icon" class="fas fa-eye"></i>
                </button>
            </div>
            @error('password', 'updatePassword')
                <p class="mt-2 text-sm text-red-600 flex items-center">
                    <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                </p>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">
                <i class="fas fa-check-circle mr-2 text-blue-500"></i>ยืนยันรหัสผ่านใหม่
            </label>
            <div class="relative">
                <input 
                    id="password_confirmation" 
                    name="password_confirmation" 
                    type="password" 
                    autocomplete="new-password"
                    class="w-full px-4 py-3 pr-12 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                    placeholder="กรอกรหัสผ่านใหม่อีกครั้ง"
                />
                <button type="button" onclick="togglePasswordVisibility('password_confirmation')" class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-blue-500">
                    <i id="password_confirmation_icon" class="fas fa-eye"></i>
                </button>
            </div>
            @error('password_confirmation', 'updatePassword')
                <p class="mt-2 text-sm text-red-600 flex items-center">
                    <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                </p>
            @enderror
        </div>

        <!-- Submit Button -->
        <div class="flex items-center gap-4 pt-4">
            <button type="submit" class="px-6 py-3 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300">
                <i class="fas fa-save mr-2"></i>บันทึกรหัสผ่านใหม่
            </button>

            @if (session('status') === 'password-updated')
                <p class="text-sm text-green-600 flex items-center animate-fade-in">
                    <i class="fas fa-check-circle mr-2"></i>เปลี่ยนรหัสผ่านเรียบร้อยแล้ว
                </p>
            @endif
        </div>
    </form>
</section>

<script>
function togglePasswordVisibility(fieldId) {
    const field = document.getElementById(fieldId);
    const icon = document.getElementById(fieldId + '_icon');
    
    if (field.type === 'password') {
        field.type = 'text';
        icon.className = 'fas fa-eye-slash';
    } else {
        field.type = 'password';
        icon.className = 'fas fa-eye';
    }
}
</script>
