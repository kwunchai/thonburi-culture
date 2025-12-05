<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ทดสอบหน้า Home - Thonburi Culture</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Sarabun', sans-serif; }
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
</head>
<body class="bg-gray-50">
    <div class="max-w-4xl mx-auto py-8 px-4">
        <h1 class="text-3xl font-bold text-center mb-8 text-gray-800">
            <i class="fas fa-home mr-2 text-orange-500"></i>
            ทดสอบหน้า Home - Thonburi Culture
        </h1>

        <!-- Test Basic Info -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
            <h2 class="text-xl font-bold text-gray-800 mb-4">
                <i class="fas fa-info-circle text-blue-500 mr-2"></i>
                ข้อมูลระบบ
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <span class="font-semibold text-gray-700">Laravel Version:</span>
                    <span class="text-gray-600"><?php echo app()->version(); ?></span>
                </div>
                <div>
                    <span class="font-semibold text-gray-700">PHP Version:</span>
                    <span class="text-gray-600"><?php echo phpversion(); ?></span>
                </div>
                <div>
                    <span class="font-semibold text-gray-700">Environment:</span>
                    <span class="text-gray-600"><?php echo config('app.env'); ?></span>
                </div>
                <div>
                    <span class="font-semibold text-gray-700">Debug Mode:</span>
                    <span class="text-gray-600"><?php echo config('app.debug') ? 'เปิด' : 'ปิด'; ?></span>
                </div>
            </div>
        </div>

        <!-- Test Database Connection -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
            <h2 class="text-xl font-bold text-gray-800 mb-4">
                <i class="fas fa-database text-green-500 mr-2"></i>
                การเชื่อมต่อฐานข้อมูล
            </h2>
            <?php
            try {
                $culturalCount = \App\Models\CulturalItem::count();
                $culturalWithLocation = \App\Models\CulturalItem::whereNotNull('latitude')->whereNotNull('longitude')->count();
                echo "<div class='space-y-2'>";
                echo "<div><span class='font-semibold text-gray-700'>Cultural Items ทั้งหมด:</span> <span class='text-blue-600 font-bold'>$culturalCount</span></div>";
                echo "<div><span class='font-semibold text-gray-700'>Cultural Items ที่มีพิกัด:</span> <span class='text-green-600 font-bold'>$culturalWithLocation</span></div>";
                echo "<div class='text-sm text-green-600'><i class='fas fa-check-circle mr-1'></i>เชื่อมต่อฐานข้อมูลสำเร็จ</div>";
                echo "</div>";
            } catch (Exception $e) {
                echo "<div class='text-red-600'><i class='fas fa-times-circle mr-1'></i>Error: " . $e->getMessage() . "</div>";
            }
            ?>
        </div>

        <!-- Test Controller -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
            <h2 class="text-xl font-bold text-gray-800 mb-4">
                <i class="fas fa-cogs text-purple-500 mr-2"></i>
                ทดสอบ Controller
            </h2>
            <?php
            try {
                $controller = new \App\Http\Controllers\FrontendController();
                $response = $controller->home();
                
                // ดึงข้อมูลจาก view
                $data = $response->getData();
                
                echo "<div class='space-y-2'>";
                echo "<div class='text-sm text-green-600'><i class='fas fa-check-circle mr-1'></i>FrontendController ทำงานสำเร็จ</div>";
                
                if (isset($data['culturalItemsWithLocation'])) {
                    $itemsWithLocation = $data['culturalItemsWithLocation'];
                    echo "<div><span class='font-semibold text-gray-700'>รายการที่มีพิกัด:</span> <span class='text-blue-600 font-bold'>" . $itemsWithLocation->count() . "</span></div>";
                    
                    if ($itemsWithLocation->count() > 0) {
                        echo "<div class='mt-4'>";
                        echo "<h4 class='font-semibold text-gray-700 mb-2'>ตัวอย่างรายการ 3 รายการแรก:</h4>";
                        echo "<div class='bg-gray-50 p-3 rounded space-y-2'>";
                        
                        foreach ($itemsWithLocation->take(3) as $item) {
                            echo "<div class='text-sm'>";
                            echo "<strong>" . htmlspecialchars($item->title) . "</strong> ";
                            echo "<span class='text-gray-600'>(" . $item->latitude . ", " . $item->longitude . ")</span>";
                            echo "</div>";
                        }
                        echo "</div></div>";
                    }
                }
                echo "</div>";
                
            } catch (Exception $e) {
                echo "<div class='text-red-600'><i class='fas fa-times-circle mr-1'></i>Error: " . $e->getMessage() . "</div>";
            }
            ?>
        </div>

        <!-- Test Google Maps API -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
            <h2 class="text-xl font-bold text-gray-800 mb-4">
                <i class="fas fa-map text-orange-500 mr-2"></i>
                ทดสอบ Google Maps API
            </h2>
            <div id="mapTest" style="height: 300px; background: #f3f4f6;" class="rounded mb-4 flex items-center justify-center">
                <div class="text-center">
                    <i class="fas fa-spinner fa-spin text-2xl text-orange-500 mb-2"></i>
                    <p>กำลังโหลด Google Maps...</p>
                </div>
            </div>
            <div id="mapStatus" class="text-sm text-gray-600">
                Google Maps API Key: <?php echo config('maps.google.api_key') ? 'ตั้งค่าแล้ว' : 'ยังไม่ได้ตั้งค่า'; ?>
            </div>
        </div>

        <div class="text-center">
            <a href="/" class="inline-flex items-center px-6 py-3 bg-orange-500 hover:bg-orange-600 text-white rounded-lg font-medium transition-colors">
                <i class="fas fa-arrow-left mr-2"></i>
                กลับหน้าแรก
            </a>
        </div>
    </div>

    <!-- Google Maps API Test -->
    <script>
    function initMap() {
        try {
            const map = new google.maps.Map(document.getElementById('mapTest'), {
                zoom: 12,
                center: { lat: 13.7563, lng: 100.5018 } // Default to Thonburi
            });
            
            // Add a marker
            new google.maps.Marker({
                position: { lat: 13.7563, lng: 100.5018 },
                map: map,
                title: 'Thonburi Location'
            });

            document.getElementById('mapStatus').innerHTML = '<i class="fas fa-check-circle text-green-500 mr-1"></i>Google Maps API ทำงานสำเร็จ';
        } catch (error) {
            document.getElementById('mapTest').innerHTML = '<div class="text-center text-red-600"><i class="fas fa-times-circle text-2xl mb-2"></i><p>Google Maps API Error</p></div>';
            document.getElementById('mapStatus').innerHTML = '<i class="fas fa-times-circle text-red-500 mr-1"></i>Error: ' + error.message;
        }
    }

    // Load Google Maps API
    window.onload = function() {
        const script = document.createElement('script');
        script.src = 'https://maps.googleapis.com/maps/api/js?key=<?php echo config("maps.google.api_key"); ?>&callback=initMap';
        script.onerror = function() {
            document.getElementById('mapTest').innerHTML = '<div class="text-center text-red-600"><i class="fas fa-times-circle text-2xl mb-2"></i><p>ไม่สามารถโหลด Google Maps API</p></div>';
            document.getElementById('mapStatus').innerHTML = '<i class="fas fa-times-circle text-red-500 mr-1"></i>ไม่สามารถโหลด Google Maps API (ตรวจสอบ API Key)';
        };
        document.head.appendChild(script);
    };
    </script>
</body>
</html>