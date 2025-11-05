<?php
namespace App\Enums;

enum IpType: string
{
    case INVENTION_PATENT   = 'invention_patent';
    case PETTY_PATENT       = 'petty_patent';
    case DESIGN_PATENT      = 'design_patent';
    case COPYRIGHT          = 'copyright';
    case TRADEMARK          = 'trademark';
    case GI                 = 'gi';
    case TK                 = 'tk';
    case PATENT             = 'patent';
    case LOCAL_WISDOM       = 'local_wisdom';
    case TRADE_SECRET       = 'trade_secret';
    case OTHER              = 'other';

    public function label(): string
    {
        return match($this) {
            self::INVENTION_PATENT => 'สิทธิบัตรการประดิษฐ์',
            self::PETTY_PATENT => 'อนุสิทธิบัตร',
            self::DESIGN_PATENT => 'สิทธิบัตรการออกแบบ',
            self::COPYRIGHT => 'ลิขสิทธิ์',
            self::TRADEMARK => 'เครื่องหมายการค้า',
            self::GI => 'GI',
            self::TK => 'ภูมิปัญญาดั้งเดิม',
            self::PATENT => 'สิทธิบัตร',
            self::LOCAL_WISDOM => 'ภูมิปัญญาท้องถิ่น',
            self::TRADE_SECRET => 'ความลับทางการค้า',
            self::OTHER => 'อื่นๆ',
        };
    }
}
