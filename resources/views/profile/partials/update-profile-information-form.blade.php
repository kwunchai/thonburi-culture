<section>
    <header class="mb-6">
        <h2 class="text-xl font-bold text-gray-900">
            ข้อมูลส่วนตัว
        </h2>
        <p class="mt-2 text-sm text-gray-600">
            อัปเดตข้อมูลโปรไฟล์และที่อยู่อีเมลของคุณ
        </p>
    </header>

    <form method="post" action="{{ route('profile.update') }}" class="space-y-6">
        @csrf
        @method('patch')

        <!-- Name -->
        <div>
            <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                <i class="fas fa-user mr-2 text-orange-500"></i>ชื่อ-นามสกุล
            </label>
            <input 
                id="name" 
                name="name" 
                type="text" 
                value="{{ old('name', $user->name) }}" 
                required 
                autofocus 
                autocomplete="name"
                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all"
            />
            @error('name')
                <p class="mt-2 text-sm text-red-600 flex items-center">
                    <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                </p>
            @enderror
        </div>

        <!-- Email -->
        <div>
            <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                <i class="fas fa-envelope mr-2 text-orange-500"></i>อีเมล
            </label>
            <input 
                id="email" 
                name="email" 
                type="email" 
                value="{{ old('email', $user->email) }}" 
                required 
                autocomplete="username"
                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all"
            />
            @error('email')
                <p class="mt-2 text-sm text-red-600 flex items-center">
                    <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                </p>
            @enderror

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-3 p-3 bg-yellow-50 border border-yellow-200 rounded-lg">
                    <p class="text-sm text-yellow-800">
                        <i class="fas fa-exclamation-triangle mr-2"></i>อีเมลของคุณยังไม่ได้รับการยืนยัน
                    </p>
                    <form method="post" action="{{ route('verification.send') }}" class="mt-2">
                        @csrf
                        <button type="submit" class="text-sm text-orange-600 hover:text-orange-700 underline font-medium">
                            คลิกที่นี่เพื่อส่งอีเมลยืนยันอีกครั้ง
                        </button>
                    </form>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 text-sm text-green-600 flex items-center">
                            <i class="fas fa-check-circle mr-1"></i>ส่งลิงก์ยืนยันไปยังอีเมลของคุณแล้ว
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <!-- Submit Button -->
        <div class="flex items-center gap-4 pt-4">
            <button type="submit" class="px-6 py-3 bg-gradient-to-r from-orange-500 to-red-500 hover:from-orange-600 hover:to-red-600 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300">
                <i class="fas fa-save mr-2"></i>บันทึกข้อมูล
            </button>

            @if (session('status') === 'profile-updated')
                <p class="text-sm text-green-600 flex items-center animate-fade-in">
                    <i class="fas fa-check-circle mr-2"></i>บันทึกเรียบร้อยแล้ว
                </p>
            @endif
        </div>
    </form>
</section>
