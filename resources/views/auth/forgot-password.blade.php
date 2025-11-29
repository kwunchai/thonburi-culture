@extends('layouts.frontend')

@section('title', 'ลืมรหัสผ่าน')

@section('content')
<!-- Main Container with modern design -->
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-white to-orange-50/30 flex items-center justify-center px-4 py-8">
    <div class="w-full max-w-md mx-auto">
        
        <!-- Right Side - Forgot Password Form -->
        <div class="w-full">
            <!-- Mobile Header -->
            <div class="text-center mb-8">
                <div class="mx-auto mb-6">
                    <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-orange-500 to-red-500 rounded-full mb-4 floating-logo">
                        <i class="fas fa-key text-white text-3xl"></i>
                    </div>
                    <h1 class="text-2xl font-medium text-gray-800">ลืมรหัสผ่าน?</h1>
                    <p class="text-gray-600 mt-2 text-sm">ไม่เป็นไร เราจะส่งลิงก์รีเซ็ตรหัสผ่านให้คุณทางอีเมล</p>
                </div>
            </div>

            <!-- Session Status -->
            @if (session('status'))
                <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-r-lg">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle text-green-500 mr-3 text-xl"></i>
                        <p class="text-green-700 font-medium">{{ session('status') }}</p>
                    </div>
                </div>
            @endif

            <!-- Forgot Password Form -->
            <div class="bg-white/95 backdrop-blur-sm rounded-3xl shadow-2xl border border-white/20 overflow-hidden">
                <div class="p-8 space-y-6">
                    <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
                        @csrf
                        
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
                                   autofocus 
                                   placeholder="กรอกอีเมลที่ลงทะเบียนไว้"
                                   class="w-full px-4 py-3.5 text-gray-900 bg-gray-50 border border-gray-200 rounded-2xl focus:outline-none focus:ring-3 focus:ring-orange-500/20 focus:border-orange-500 transition-all duration-300 placeholder-gray-500">
                            @if ($errors->has('email'))
                                <p class="text-xs text-red-600 flex items-center mt-2">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $errors->first('email') }}
                                </p>
                            @endif
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" 
                                class="w-full bg-gradient-to-r from-orange-500 to-red-500 hover:from-orange-600 hover:to-red-600 text-white font-semibold py-4 px-6 rounded-2xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-300 focus:outline-none focus:ring-4 focus:ring-orange-500/30">
                            <span class="flex items-center justify-center">
                                <i class="fas fa-paper-plane mr-3"></i>
                                ส่งลิงก์รีเซ็ตรหัสผ่าน
                                <i class="fas fa-arrow-right ml-3"></i>
                            </span>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Back to Login -->
            <div class="text-center mt-6 space-y-3">
                <a href="{{ route('login') }}" 
                   class="inline-flex items-center text-sm text-orange-600 hover:text-orange-500 font-medium transition-colors duration-200">
                    <i class="fas fa-arrow-left mr-2"></i>
                    กลับไปหน้าเข้าสู่ระบบ
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
    
    /* Subtle background pattern */
    .bg-pattern {
        background-image: 
            radial-gradient(circle at 25% 25%, rgba(249, 115, 22, 0.1) 0%, transparent 25%),
            radial-gradient(circle at 75% 75%, rgba(239, 68, 68, 0.08) 0%, transparent 25%);
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
    
    /* Error message animation */
    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
        20%, 40%, 60%, 80% { transform: translateX(5px); }
    }
    
    .error-shake {
        animation: shake 0.6s ease-in-out;
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
    
    /* Background decorative elements - responsive */
    .bg-decorative::before {
        content: '';
        position: absolute;
        top: -40px;
        right: -40px;
        width: 80px;
        height: 80px;
        background: linear-gradient(45deg, rgba(249, 115, 22, 0.06), rgba(251, 146, 60, 0.06));
        border-radius: 50%;
        z-index: -1;
    }
    
    .bg-decorative::after {
        content: '';
        position: absolute;
        bottom: -30px;
        left: -30px;
        width: 60px;
        height: 60px;
        background: linear-gradient(-45deg, rgba(249, 115, 22, 0.04), rgba(251, 146, 60, 0.04));
        border-radius: 50%;
        z-index: -1;
    }

    /* Responsive design */
    @media (max-width: 1023px) {
        .bg-decorative::before,
        .bg-decorative::after {
            display: none;
        }
        
        .form-container {
            max-width: 420px;
        }
    }

    @media (max-width: 768px) {
        .form-container {
            padding: 1rem;
        }
    }

    /* Tablet adjustments */
    @media (min-width: 768px) and (max-width: 1023px) {
        .form-container {
            max-width: 480px;
            margin: 0 auto;
        }
        
        .floating-logo {
            animation-duration: 3s;
        }
    }

    /* Large screen adjustments */
    @media (min-width: 1280px) {
        input:focus {
            transform: translateY(-2px);
        }
        
        button[type="submit"]:hover {
            transform: translateY(-3px) scale(1.03);
        }
    }

    /* Success message animation */
    @keyframes slideInDown {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .bg-green-50 {
        animation: slideInDown 0.5s ease-out;
    }
</style>
@endpush

@push('scripts')
<script>
// Enhanced interactivity
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    const submitButton = document.querySelector('button[type="submit"]');
    const emailInput = document.querySelector('input[type="email"]');
    
    // Modern input interactions
    if (emailInput) {
        emailInput.addEventListener('focus', function() {
            this.style.transform = 'translateY(-2px)';
            this.style.boxShadow = '0 8px 25px -8px rgba(249, 115, 22, 0.3)';
        });
        
        emailInput.addEventListener('blur', function() {
            this.style.transform = 'translateY(0)';
            this.style.boxShadow = '';
        });
    }
    
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
                        กำลังส่ง...
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
