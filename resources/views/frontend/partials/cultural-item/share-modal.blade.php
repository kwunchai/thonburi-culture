{{-- Share Modal --}}
<div id="shareModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg p-6 w-full max-w-md">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold">แชร์เรื่องราวนี้</h3>
                <button onclick="closeShareModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <div class="grid grid-cols-2 gap-3">
                <button onclick="shareOnFacebook()" 
                        class="flex items-center justify-center p-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors">
                    <i class="fab fa-facebook-f mr-2"></i>Facebook
                </button>
                <button onclick="shareOnTwitter()" 
                        class="flex items-center justify-center p-3 bg-blue-400 hover:bg-blue-500 text-white rounded-lg transition-colors">
                    <i class="fab fa-twitter mr-2"></i>Twitter
                </button>
                <button onclick="shareOnLine()" 
                        class="flex items-center justify-center p-3 bg-green-500 hover:bg-green-600 text-white rounded-lg transition-colors">
                    <i class="fab fa-line mr-2"></i>Line
                </button>
                <button onclick="copyLink()" 
                        class="flex items-center justify-center p-3 bg-gray-600 hover:bg-gray-700 text-white rounded-lg transition-colors">
                    <i class="fas fa-copy mr-2"></i>คัดลอก
                </button>
            </div>
        </div>
    </div>
</div>