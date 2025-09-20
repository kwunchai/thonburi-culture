<?php
namespace App\Enums;

enum IpType:string {
    case INVENTION_PATENT   = 'สิทธิบัตรการประดิษฐ์';
    case PETTY_PATENT       = 'อนุสิทธิบัตร';
    case DESIGN_PATENT      = 'สิทธิบัตรการออกแบบ';
    case COPYRIGHT          = 'ลิขสิทธิ์';
    case TRADEMARK          = 'เครื่องหมายการค้า';
    case GI                 = 'GI';
    case TK                 = 'ภูมิปัญญาดั้งเดิม';
}
