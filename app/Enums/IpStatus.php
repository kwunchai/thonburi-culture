<?php
namespace App\Enums;

enum IpStatus: string
{
    case DRAFT         = 'draft';
    case SUBMITTED     = 'submitted';
    case UNDER_REVIEW  = 'under_review';
    case REGISTERED    = 'registered';
    case REJECTED      = 'rejected';
    case EXPIRED       = 'expired';

    public function label(): string
    {
        return match($this) {
            self::DRAFT => 'ร่าง',
            self::SUBMITTED => 'ยื่นคำขอ',
            self::UNDER_REVIEW => 'รอพิจารณา',
            self::REGISTERED => 'จดทะเบียนแล้ว',
            self::REJECTED => 'ปฏิเสธ',
            self::EXPIRED => 'หมดอายุ',
        };
    }
}
