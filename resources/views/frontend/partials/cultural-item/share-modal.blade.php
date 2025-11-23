{{-- Share Modal --}}
<div id="shareModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden justify-center items-center">
    <div class="bg-white rounded-2xl p-6 max-w-md w-full mx-4 transform transition-all">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-bold text-gray-800">แชร์เรื่องราวนี้</h3>
            <button onclick="hideShareModal()" class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
        
        <p class="text-gray-600 mb-6">ช่วยเผยแพร่มรดกทางวัฒนธรรมไทยให้คนอื่นๆ ได้รู้จัก</p>
        
        <div class="grid grid-cols-2 gap-3 mb-6">
            <button onclick="shareToFacebook()" 
                    class="flex items-center justify-center p-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                <i class="fab fa-facebook-f mr-2"></i>
                Facebook
            </button>
            
            <button onclick="shareToTwitter()" 
                    class="flex items-center justify-center p-3 bg-sky-500 text-white rounded-lg hover:bg-sky-600 transition-colors">
                <i class="fab fa-twitter mr-2"></i>
                Twitter
            </button>
            
            <button onclick="shareToLine()" 
                    class="flex items-center justify-center p-3 bg-green-500 text-white rounded-lg hover:bg-green-600 transition-colors">
                <i class="fab fa-line mr-2"></i>
                LINE
            </button>
            
            <button onclick="shareToEmail()" 
                    class="flex items-center justify-center p-3 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
                <i class="fas fa-envelope mr-2"></i>
                อีเมล
            </button>
        </div>
        
        <div class="flex items-center border rounded-lg p-3 bg-gray-50">
            <input type="text" 
                   id="shareUrl" 
                   value="{{ url()->current() }}" 
                   readonly 
                   class="flex-1 bg-transparent text-gray-700 text-sm">
            <button onclick="copyToClipboard()" 
                    class="ml-2 px-3 py-1 bg-orange-500 text-white rounded text-sm hover:bg-orange-600 transition-colors">
                คัดลอก
            </button>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function showShareModal() {
        document.getElementById('shareModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }
    
    function hideShareModal() {
        document.getElementById('shareModal').classList.add('hidden');
        document.body.style.overflow = '';
    }
    
    function shareToFacebook() {
        const url = encodeURIComponent(window.location.href);
        window.open(`https://www.facebook.com/sharer/sharer.php?u=${url}`, '_blank', 'width=600,height=400');
    }
    
    function shareToTwitter() {
        const url = encodeURIComponent(window.location.href);
        const text = encodeURIComponent('{{ $item->title }} - มรดกทางวัฒนธรรมไทย #วัฒนธรรมไทย');
        window.open(`https://twitter.com/intent/tweet?url=${url}&text=${text}`, '_blank', 'width=600,height=400');
    }
    
    function shareToLine() {
        const url = encodeURIComponent(window.location.href);
        const text = encodeURIComponent('{{ $item->title }}');
        window.open(`https://social-plugins.line.me/lineit/share?url=${url}&text=${text}`, '_blank', 'width=600,height=400');
    }
    
    function shareToEmail() {
        const subject = encodeURIComponent('{{ $item->title }} - วัฒนธรรมเขตธนบุรี');
        const body = encodeURIComponent(`ฉันอยากแชร์เรื่องราวน่าสนใจเกี่ยวกับ {{ $item->title }} กับคุณ\n\nอ่านเพิ่มเติมได้ที่: ${window.location.href}`);
        window.location.href = `mailto:?subject=${subject}&body=${body}`;
    }
    
    function copyToClipboard() {
        const urlInput = document.getElementById('shareUrl');
        urlInput.select();
        urlInput.setSelectionRange(0, 99999);
        
        navigator.clipboard.writeText(urlInput.value).then(function() {
            alert('คัดลอกลิงก์แล้ว!');
        }).catch(function() {
            // Fallback for older browsers
            document.execCommand('copy');
            alert('คัดลอกลิงก์แล้ว!');
        });
    }
    
    // Close modal when clicking outside
    document.getElementById('shareModal').addEventListener('click', function(e) {
        if (e.target === this) {
            hideShareModal();
        }
    });
    
    // Close modal with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            hideShareModal();
        }
    });
    
    // Back to top functionality
    function scrollToTop() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    }
    
    // Show/hide back to top button
    window.addEventListener('scroll', function() {
        const backToTop = document.getElementById('backToTop');
        if (window.scrollY > 300) {
            backToTop.classList.remove('opacity-0', 'pointer-events-none', 'translate-y-4');
            backToTop.classList.add('opacity-100', 'pointer-events-auto', 'translate-y-0');
        } else {
            backToTop.classList.add('opacity-0', 'pointer-events-none', 'translate-y-4');
            backToTop.classList.remove('opacity-100', 'pointer-events-auto', 'translate-y-0');
        }
    });
    
    // Smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
</script>
@endpush