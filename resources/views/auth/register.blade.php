@extends('layouts.frontend')

@section('title', 'ลงทะเบียน')

@section('content')
<!-- Main Container with modern design -->
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-white to-orange-50/30 flex items-center justify-center px-4 py-8">
    <div class="w-full max-w-md mx-auto">
        
        <!-- Right Side - Register Form -->
        <div class="w-full">
            <!-- Mobile Header -->
            <div class="text-center mb-8">
                <div class="mx-auto mb-6">
                    <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-orange-500 to-red-500 rounded-full mb-4 floating-logo">
                        <i class="fas fa-user-plus text-white text-3xl"></i>
                    </div>
                    <h1 class="text-2xl font-medium text-gray-800">สร้างบัญชีผู้ใช้ใหม่</h1>
                    <p class="text-gray-600 mt-2 text-sm">กรอกข้อมูลเพื่อเริ่มต้นใช้งาน</p>
                </div>
            </div>

            <!-- Register Form -->
            <div class="bg-white/95 backdrop-blur-sm rounded-3xl shadow-2xl border border-white/20 overflow-hidden">
                <div class="p-8 space-y-6">
                    <form method="POST" action="{{ route('register') }}" class="space-y-6">
                        @csrf
                        
                        <!-- Name Field -->
                        <div class="space-y-2">
                            <label for="name" class="block text-sm font-semibold text-gray-700">
                                <i class="fas fa-user mr-2 text-orange-500"></i>
                                ชื่อ-นามสกุล
                            </label>
                            <input id="name" 
                                   type="text" 
                                   name="name" 
                                   value="{{ old('name') }}" 
                                   required 
                                   autofocus 
                                   autocomplete="name"
                                   placeholder="กรอกชื่อ-นามสกุลของคุณ"
                                   class="w-full px-4 py-3.5 text-gray-900 bg-gray-50 border border-gray-200 rounded-2xl focus:outline-none focus:ring-3 focus:ring-orange-500/20 focus:border-orange-500 transition-all duration-300 placeholder-gray-500">
                            @if ($errors->has('name'))
                                <p class="text-xs text-red-600 flex items-center mt-2">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $errors->first('name') }}
                                </p>
                            @endif
                        </div>

                        <!-- Email Field -->
                        <div class="space-y-2">
                            <label for="email" class="block text-sm font-semibold text-gray-700">
                                <i class="fas fa-envelope mr-2 text-orange-500"></i>
                                อีเมล
                            </label>
                            <input id="email" 
                                   type="email" 
                                   name="email" 
                                   value="{{ old('email') }}" 
                                   required 
                                   autocomplete="username"
                                   placeholder="กรอกอีเมลของคุณ"
                                   class="w-full px-4 py-3.5 text-gray-900 bg-gray-50 border border-gray-200 rounded-2xl focus:outline-none focus:ring-3 focus:ring-orange-500/20 focus:border-orange-500 transition-all duration-300 placeholder-gray-500">
                            @if ($errors->has('email'))
                                <p class="text-xs text-red-600 flex items-center mt-2">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $errors->first('email') }}
                                </p>
                            @endif
                        </div>

                        <!-- Password Field -->
                        <div class="space-y-2">
                            <label for="password" class="block text-sm font-semibold text-gray-700">
                                <i class="fas fa-lock mr-2 text-orange-500"></i>
                                รหัสผ่าน
                            </label>
                            <div class="relative">
                                <input id="password" 
                                       type="password" 
                                       name="password" 
                                       required 
                                       autocomplete="new-password"
                                       placeholder="กรอกรหัสผ่าน (อย่างน้อย 8 ตัวอักษร)"
                                       class="w-full px-4 py-3.5 pr-12 text-gray-900 bg-gray-50 border border-gray-200 rounded-2xl focus:outline-none focus:ring-3 focus:ring-orange-500/20 focus:border-orange-500 transition-all duration-300 placeholder-gray-500">
                                <button type="button" 
                                        onclick="togglePassword('password')" 
                                        class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-orange-500 transition-colors duration-200">
                                    <i id="passwordIcon" class="fas fa-eye"></i>
                                </button>
                            </div>
                            @if ($errors->has('password'))
                                <p class="text-xs text-red-600 flex items-center mt-2">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $errors->first('password') }}
                                </p>
                            @endif
                        </div>

                        <!-- Confirm Password Field -->
                        <div class="space-y-2">
                            <label for="password_confirmation" class="block text-sm font-semibold text-gray-700">
                                <i class="fas fa-lock mr-2 text-orange-500"></i>
                                ยืนยันรหัสผ่าน
                            </label>
                            <div class="relative">
                                <input id="password_confirmation" 
                                       type="password" 
                                       name="password_confirmation" 
                                       required 
                                       autocomplete="new-password"
                                       placeholder="กรอกรหัสผ่านอีกครั้ง"
                                       class="w-full px-4 py-3.5 pr-12 text-gray-900 bg-gray-50 border border-gray-200 rounded-2xl focus:outline-none focus:ring-3 focus:ring-orange-500/20 focus:border-orange-500 transition-all duration-300 placeholder-gray-500">
                                <button type="button" 
                                        onclick="togglePassword('password_confirmation')" 
                                        class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-orange-500 transition-colors duration-200">
                                    <i id="password_confirmationIcon" class="fas fa-eye"></i>
                                </button>
                            </div>
                            @if ($errors->has('password_confirmation'))
                                <p class="text-xs text-red-600 flex items-center mt-2">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $errors->first('password_confirmation') }}
                                </p>
                            @endif
                        </div>

                        <!-- Register Button -->
                        <button type="submit" 
                                class="w-full bg-gradient-to-r from-orange-500 to-red-500 hover:from-orange-600 hover:to-red-600 text-white font-semibold py-4 px-6 rounded-2xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-300 focus:outline-none focus:ring-4 focus:ring-orange-500/30">
                            <span class="flex items-center justify-center">
                                <i class="fas fa-user-plus mr-3"></i>
                                ลงทะเบียน
                                <i class="fas fa-arrow-right ml-3"></i>
                            </span>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Already registered -->
            <div class="text-center mt-6 space-y-3">
                <a href="{{ route('login') }}" 
                   class="inline-flex items-center text-sm text-orange-600 hover:text-orange-500 font-medium transition-colors duration-200">
                    <i class="fas fa-sign-in-alt mr-2"></i>
                    มีบัญชีอยู่แล้ว? เข้าสู่ระบบ
                </a>
                
                <div class="text-gray-400">|</div>
                
                <a href="{{ route('home') }}" 
                   class="inline-flex items-center text-sm text-gray-600 hover:text-orange-600 transition-colors duration-200">
                    <i class="fas fa-home mr-2"></i>
                    กลับสู่หน้าแรก
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Modern styling */
    .form-container {
        animation: slideUp 0.8s ease-out;
    }
    
    /* Slide up animation */
    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(20px) scale(0.98);
        }
        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }
    
    /* Float animation for logo */
    @keyframes float {
        0%, 100% {
            transform: translateY(0) rotate(0deg);
        }
        50% {
            transform: translateY(-8px) rotate(-3deg);
        }
    }
    
    .floating-logo {
        animation: float 4s ease-in-out infinite;
    }
    
    /* Input focus effects */
    input:focus {
        transform: translateY(-1px);
        box-shadow: 0 0 0 3px rgba(249, 115, 22, 0.15),
                    0 4px 12px -2px rgba(249, 115, 22, 0.1);
        border-color: rgb(249, 115, 22);
    }
    
    /* Button animations */
    button[type="submit"]:hover {
        transform: translateY(-2px) scale(1.02);
        box-shadow: 0 12px 20px -5px rgba(249, 115, 22, 0.4),
                    0 8px 16px -4px rgba(249, 115, 22, 0.1);
    }
    
    button[type="submit"]:active {
        transform: translateY(0) scale(0.98);
        transition: transform 0.1s ease;
    }
    
    /* Modern glassmorphism effect */
    .backdrop-blur-sm {
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
    }
    
    /* Enhanced shadows */
    .shadow-2xl {
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    }
    
    /* Ripple effect */
    .ripple {
        position: absolute;
        border-radius: 50%;
        background-color: rgba(255, 255, 255, 0.4);
        transform: scale(0);
        animation: ripple-animation 0.6s ease-out;
        pointer-events: none;
    }
    
    @keyframes ripple-animation {
        to {
            transform: scale(2);
            opacity: 0;
        }
    }
    
    /* Loading state styles */
    button:disabled {
        opacity: 0.8;
        cursor: not-allowed;
    }
    
    /* Enhanced accessibility */
    input:focus {
        outline: none;
    }
    
    label {
        cursor: pointer;
    }

    /* Responsive design */
    @media (max-width: 768px) {
        .form-container {
            padding: 1rem;
        }
    }
</style>
@endpush

@push('scripts')
<script>
// Toggle password visibility
function togglePassword(fieldId) {
    const passwordField = document.getElementById(fieldId);
    const toggleIcon = document.getElementById(fieldId + 'Icon');
    
    if (passwordField.type === 'password') {
        passwordField.type = 'text';
        toggleIcon.className = 'fas fa-eye-slash';
        toggleIcon.style.color = '#f97316';
    } else {
        passwordField.type = 'password';
        toggleIcon.className = 'fas fa-eye';
        toggleIcon.style.color = '#9ca3af';
    }
}

// Enhanced interactivity
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    const submitButton = document.querySelector('button[type="submit"]');
    const inputs = document.querySelectorAll('input[type="text"], input[type="email"], input[type="password"]');
    
    // Modern input interactions
    inputs.forEach(input => {
        input.addEventListener('focus', function() {
            this.style.transform = 'translateY(-2px)';
            this.style.boxShadow = '0 8px 25px -8px rgba(249, 115, 22, 0.3)';
        });
        
        input.addEventListener('blur', function() {
            this.style.transform = 'translateY(0)';
            this.style.boxShadow = '';
        });
    });
    
    // Button ripple effect
    if (submitButton) {
        submitButton.addEventListener('click', function(e) {
            const ripple = document.createElement('span');
            const rect = this.getBoundingClientRect();
            const size = Math.max(rect.height, rect.width);
            const x = e.clientX - rect.left - size / 2;
            const y = e.clientY - rect.top - size / 2;
            
            ripple.style.width = ripple.style.height = size + 'px';
            ripple.style.left = x + 'px';
            ripple.style.top = y + 'px';
            ripple.classList.add('ripple');
            
            this.appendChild(ripple);
            
            setTimeout(() => {
                ripple.remove();
            }, 600);
        });
    }
    
    // Form submission with loading state
    if (form) {
        form.addEventListener('submit', function(e) {
            if (submitButton) {
                submitButton.innerHTML = `
                    <span class="flex items-center justify-center">
                        <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        กำลังลงทะเบียน...
                    </span>
                `;
                submitButton.disabled = true;
                submitButton.classList.add('opacity-75', 'cursor-not-allowed');
            }
        });
    }
});
</script>
@endpush
