{{-- JavaScript Files --}}
@if($item->latitude && $item->longitude)
    <script>
        function initMap() {
            const map = new google.maps.Map(document.getElementById('map'), {
                zoom: 15,
                center: { lat: {{ $item->latitude }}, lng: {{ $item->longitude }} },
                styles: [
                    {
                        "featureType": "poi",
                        "elementType": "labels",
                        "stylers": [{"visibility": "off"}]
                    }
                ]
            });

            new google.maps.Marker({
                position: { lat: {{ $item->latitude }}, lng: {{ $item->longitude }} },
                map: map,
                title: '{{ $item->title }}',
                icon: {
                    url: 'data:image/svg+xml;charset=UTF-8,' + encodeURIComponent(`
                        <svg width="30" height="40" viewBox="0 0 30 40" xmlns="http://www.w3.org/2000/svg">
                            <path d="M15 0C7 0 0 7 0 15c0 12 15 25 15 25s15-13 15-25C30 7 23 0 15 0z" fill="#ef4444"/>
                            <circle cx="15" cy="15" r="6" fill="#ffffff"/>
                        </svg>
                    `),
                    scaledSize: new google.maps.Size(30, 40),
                    anchor: new google.maps.Point(15, 40)
                }
            });
        }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key={{ config('maps.google_api_key') }}&callback=initMap"></script>
@endif

<script>
    // Share Modal Functions
    function showShareModal() {
        document.getElementById('shareModal').classList.remove('hidden');
    }

    function closeShareModal() {
        document.getElementById('shareModal').classList.add('hidden');
    }

    // Close modal when clicking outside
    document.getElementById('shareModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeShareModal();
        }
    });

    // Social Share Functions
    function shareOnFacebook() {
        window.open('https://www.facebook.com/sharer/sharer.php?u=' + encodeURIComponent(window.location.href), '_blank');
    }

    function shareOnTwitter() {
        window.open('https://twitter.com/intent/tweet?url=' + encodeURIComponent(window.location.href) + '&text=' + encodeURIComponent('{{ $item->title }}'), '_blank');
    }

    function shareOnLine() {
        window.open('https://line.me/R/msg/text/?' + encodeURIComponent('{{ $item->title }} ' + window.location.href), '_blank');
    }

    function copyLink() {
        navigator.clipboard.writeText(window.location.href).then(() => {
            alert('ลิงก์ถูกคัดลอกแล้ว!');
            closeShareModal();
        });
    }
</script>