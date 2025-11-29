# วิธีเปิด HTTPS ใน Laragon

## ขั้นตอนที่ 1: เปิด SSL Module
1. เปิด Laragon
2. คลิกขวาที่ไอคอน Laragon
3. เลือก Apache > SSL > Enabled

## ขั้นตอนที่ 2: สร้าง SSL Certificate
1. คลิกขวาที่ไอคอน Laragon
2. เลือก Apache > SSL > Import Certificate
3. หรือใช้คำสั่ง: Menu > Tools > SSL > Generate Certificate

## ขั้นตอนที่ 3: Restart Apache
1. คลิก Stop All
2. คลิก Start All

## ขั้นตอนที่ 4: เข้าเว็บด้วย HTTPS
https://thonburi-culture.test/admin/communities/create

## หมายเหตุ
- Chrome อาจแสดงคำเตือน "Not Secure" - คลิก "Advanced" > "Proceed"
- Firefox: คลิก "Advanced" > "Accept the Risk and Continue"
