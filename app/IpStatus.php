<?php
namespace App\Enums;

enum IpStatus:string {
    case DRAFT         = 'ร่าง';
    case SUBMITTED     = 'ยื่นคำขอ';
    case UNDER_REVIEW  = 'รอพิจารณา';
    case REGISTERED    = 'จดทะเบียนแล้ว';
    case REJECTED      = 'ปฏิเสธ';
    case EXPIRED       = 'หมดอายุ';
}
