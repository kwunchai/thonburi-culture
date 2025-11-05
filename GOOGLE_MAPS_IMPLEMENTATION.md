# Google Maps Integration Documentation
## ระบบจัดการข้อมูลวัฒนธรรมธนบุรี - การเพิ่มฟังก์ชัน Google Maps

### 📋 สรุปการพัฒนา

ฟังก์ชัน Google Maps ได้ถูกเพิ่มเข้าสู่ระบบจัดการข้อมูลวัฒนธรรมธนบุรีเรียบร้อยแล้ว โดยรองรับ:

1. **Admin Input Form**: ปักหมุดสำหรับระบุตำแหน่งที่ตั้งในฟอร์มเพิ่ม/แก้ไขข้อมูล
2. **Public Display**: แสดงแผนที่และตำแหน่งที่ตั้งในหน้ารายละเอียดข้อมูลวัฒนธรรม
3. **Database Support**: คอลัมน์ latitude และ longitude สำหรับเก็บพิกัด

---

### 🔧 ไฟล์ที่ถูกสร้าง/แก้ไข

#### 1. Database Migration
```
database/migrations/2025_11_04_000001_add_coordinates_to_cultural_items_table.php
```
- เพิ่มคอลัมน์ `latitude` (decimal 10,8) และ `longitude` (decimal 11,8)
- รองรับพิกัดทั่วโลกด้วยความแม่นยำสูง

#### 2. Model Update
```
app/Models/CulturalItem.php
```
- เพิ่ม `latitude` และ `longitude` ใน `$fillable` array

#### 3. Configuration
```
config/maps.php (ใหม่)
.env.maps.example (ใหม่)
```
- การตั้งค่า Google Maps API
- พิกัดเริ่มต้น (ธนบุรี: 13.7563, 100.5018)

#### 4. Admin Forms
```
resources/views/admin/cultural-items/create.blade.php
resources/views/admin/cultural-items/edit.blade.php
```
- ฟอร์ม Google Maps picker พร้อม draggable marker
- Input fields สำหรับละติจูดและลองจิจูด
- JavaScript สำหรับจัดการแผนที่

#### 5. Controller Updates
```
app/Http/Controllers/Admin/CulturalItemController.php
```
- เพิ่ม validation rules สำหรับพิกัด
- รองรับ latitude/longitude ในทั้ง store() และ update() methods

#### 6. Public Display
```
resources/views/frontend/show.blade.php
```
- แสดงแผนที่ในหน้ารายละเอียดข้อมูลวัฒนธรรม
- InfoWindow พร้อมข้อมูลพื้นฐาน
- ลิงก์ไปยัง Google Maps แยกต่างหาก

---

### ⚙️ การตั้งค่าระบบ

#### 1. Google Maps API Key
เพิ่มการตั้งค่าใน `.env`:
```
GOOGLE_MAPS_API_KEY=your_actual_api_key_here
```

#### 2. Google Cloud Console Setup
1. เข้าไปที่ [Google Cloud Console](https://console.cloud.google.com/)
2. เปิดใช้งาน **Maps JavaScript API**
3. สร้าง API Key และตั้งค่า restrictions:
   - **Application restrictions**: HTTP referrers
   - **Website restrictions**: `localhost/*`, `your-domain.com/*`
   - **API restrictions**: Maps JavaScript API

#### 3. รัน Migration
```bash
php artisan migrate
```

---

### 🎯 การใช้งาน

#### สำหรับ Admin (การเพิ่ม/แก้ไขข้อมูล):
1. เข้าไปยังฟอร์มเพิ่ม/แก้ไขข้อมูลวัฒนธรรม
2. เลื่อนลงมาหาส่วน "ตำแหน่งที่ตั้ง"
3. **คลิก** หรือ **ลากหมุด** บนแผนที่เพื่อเลือกตำแหน่ง
4. ระบบจะอัปเดตค่าละติจูดและลองจิจูดอัตโนมัติ
5. บันทึกข้อมูล

#### สำหรับผู้เยี่ยมชม (การดูข้อมูล):
1. เข้าไปยังหน้ารายละเอียดข้อมูลวัฒนธรรม
2. หากมีพิกัด จะเห็นแผนที่แสดงตำแหน่งที่ตั้ง
3. คลิกหมุดเพื่อดูข้อมูลเพิ่มเติม
4. คลิก "เปิดใน Google Maps" เพื่อดูในแอปแยกต่างหาก

---

### 🧪 การทดสอบ

รันสคริปต์ทดสอบ:
```bash
php test_google_maps.php
```

ลิงก์ทดสอบ:
- **ฟอร์มเพิ่มข้อมูล**: `http://localhost/thonburi-culture/admin/cultural-items/create`
- **หน้าแสดงข้อมูล**: `http://localhost/thonburi-culture/cultural-item/{id}`
- **ฟอร์มแก้ไข**: `http://localhost/thonburi-culture/admin/cultural-items/{id}/edit`

---

### 🔧 Technical Details

#### JavaScript Functions
- **initMapPicker()**: สำหรับฟอร์ม admin (draggable marker)
- **initMapDisplay()**: สำหรับหน้าแสดงผลสาธารณะ (read-only marker)

#### Validation Rules
```php
'latitude' => 'nullable|numeric|between:-90,90',
'longitude' => 'nullable|numeric|between:-180,180'
```

#### Default Coordinates
- **ธนบุรี, กรุงเทพฯ**: 13.7563, 100.5018
- **Zoom Level**: 12 (admin forms), 15 (public display)

---

### 🚨 Troubleshooting

#### แผนที่ไม่แสดง
1. ตรวจสอบ `GOOGLE_MAPS_API_KEY` ใน `.env`
2. ตรวจสอบว่า Maps JavaScript API เปิดใช้งานแล้ว
3. ตรวจสอบ API restrictions และ referrer settings

#### พิกัดไม่อัปเดต
1. ตรวจสอบ JavaScript console สำหรับ errors
2. ตรวจสอบว่า input fields มี IDs ที่ถูกต้อง
3. ตรวจสอบการทำงานของ event listeners

#### ข้อมูลไม่บันทึก
1. ตรวจสอบ validation rules ใน Controller
2. ตรวจสอบว่า Model มี latitude/longitude ใน $fillable
3. ตรวจสอบว่า migration รันสำเร็จแล้ว

---

### 📈 การขยายผลต่อไป

#### ฟีเจอร์ที่อาจเพิ่มได้:
1. **Search by Location**: ค้นหาข้อมูลตามระยะทาง
2. **Map Clustering**: รวมหมุดที่อยู่ใกล้กัน
3. **Custom Markers**: ไอคอนหมุดตามประเภทข้อมูล
4. **Directions**: การเดินทางไปยังสถานที่
5. **Heatmap**: แสดงความหนาแน่นของข้อมูล

---

### ✅ Status: พร้อมใช้งาน

ระบบ Google Maps integration สมบูรณ์และพร้อมใช้งานทันที หลังจากตั้งค่า API Key เรียบร้อยแล้ว