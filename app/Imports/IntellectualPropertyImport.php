<?php

namespace App\Imports;

use App\Models\IntellectualProperty;
use App\Models\User;
use App\Enums\IpType;
use App\Enums\IpStatus;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class IntellectualPropertyImport implements 
    ToModel, 
    WithHeadingRow, 
    WithValidation,
    SkipsOnError,
    SkipsOnFailure,
    WithBatchInserts,
    WithChunkReading
{
    protected $importResults = [
        'success' => 0,
        'skipped' => 0,
        'errors' => [],
    ];

    protected $defaultOwnerId;
    protected $importedBy;

    public function __construct($userId = null)
    {
        // ใช้ user ที่ทำการ import หรือ admin แรก
        $this->importedBy = $userId ?? User::where('role', 'admin')->first()?->id ?? 1;
        $this->defaultOwnerId = $this->importedBy;
    }

    /**
     * ตัวอย่าง Excel Headers (Row 1):
     * ลำดับ | ชื่อผลงาน | ประเภท | คำอธิบาย | เลขคำขอ/ทะเบียน | วันที่ยื่นขอ | วันที่จดทะเบียน | วันหมดอายุ | สถานะ | ผู้เป็นเจ้าของ
     * 
     * Excel Column Mapping:
     * - lamtad (ลำดับ) - ใช้สำหรับอ้างอิง
     * - chue_phon_ngan (ชื่อผลงาน) -> title
     * - prapheth (ประเภท) -> type
     * - kham_othbai (คำอธิบาย) -> description
     * - lekh_kham_khor (เลขคำขอ/ทะเบียน) -> registration_number
     * - wan_thi_yuen_khor (วันที่ยื่นขอ) - metadata
     * - wan_thi_chot_thabian (วันที่จดทะเบียน) -> registration_date
     * - wan_mot_ayu (วันหมดอายุ) -> expiry_date
     * - sathana (สถานะ) -> status
     * - phu_pen_chao_khong (ผู้เป็นเจ้าของ) - metadata
     */
    public function model(array $row)
    {
        try {
            // ตรวจสอบข้อมูลที่จำเป็น
            if (empty($row['chue_phon_ngan']) || empty($row['prapheth'])) {
                $this->importResults['skipped']++;
                $this->importResults['errors'][] = "แถว: ข้อมูลไม่ครบ (ต้องมีชื่อผลงานและประเภท)";
                return null;
            }

            // ตรวจสอบข้อมูลซ้ำ
            if (!empty($row['lekh_kham_khor'])) {
                $exists = IntellectualProperty::where('registration_number', $row['lekh_kham_khor'])->first();
                if ($exists) {
                    $this->importResults['skipped']++;
                    $this->importResults['errors'][] = "แถว {$row['lamtad']}: ข้อมูลซ้ำ (เลขทะเบียน: {$row['lekh_kham_khor']})";
                    return null;
                }
            }

            // ตรวจสอบชื่อผลงานซ้ำ
            $existsByTitle = IntellectualProperty::where('title', $row['chue_phon_ngan'])->first();
            if ($existsByTitle) {
                $this->importResults['skipped']++;
                $this->importResults['errors'][] = "แถว {$row['lamtad']}: ชื่อผลงานซ้ำ ({$row['chue_phon_ngan']})";
                return null;
            }

            // แปลงประเภท
            $type = $this->mapType($row['prapheth']);
            if (!$type) {
                $this->importResults['skipped']++;
                $this->importResults['errors'][] = "แถว {$row['lamtad']}: ประเภทไม่ถูกต้อง ({$row['prapheth']})";
                return null;
            }

            // แปลงสถานะ
            $status = $this->mapStatus($row['sathana'] ?? 'ยื่นคำขอ');

            // แปลงวันที่
            $registrationDate = $this->parseDate($row['wan_thi_chot_thabian'] ?? null);
            $expiryDate = $this->parseDate($row['wan_mot_ayu'] ?? null);
            $submittedDate = $this->parseDate($row['wan_thi_yuen_khor'] ?? null);

            // สร้าง metadata
            $metadata = [
                'row_number' => $row['lamtad'] ?? null,
                'submitted_date' => $submittedDate,
                'owner_name' => $row['phu_pen_chao_khong'] ?? null,
                'imported_at' => now()->toDateTimeString(),
                'import_source' => 'Excel Import',
            ];

            $this->importResults['success']++;

            return new IntellectualProperty([
                'title' => $row['chue_phon_ngan'],
                'type' => $type,
                'description' => $row['kham_othbai'] ?? 'ไม่มีคำอธิบาย',
                'owner_id' => $this->defaultOwnerId,
                'owner_type' => 'user',
                'registration_number' => $row['lekh_kham_khor'] ?? null,
                'registration_date' => $registrationDate,
                'expiry_date' => $expiryDate,
                'status' => $status,
                'metadata' => json_encode($metadata),
                'created_by' => $this->importedBy,
                'updated_by' => $this->importedBy,
            ]);

        } catch (\Exception $e) {
            $this->importResults['skipped']++;
            $this->importResults['errors'][] = "แถว {$row['lamtad']}: Error - " . $e->getMessage();
            Log::error('IP Import Error', ['row' => $row, 'error' => $e->getMessage()]);
            return null;
        }
    }

    /**
     * แปลงประเภทจากภาษาไทยเป็น enum value
     */
    protected function mapType($typeThai): ?string
    {
        $mapping = [
            'สิทธิบัตรการประดิษฐ์' => IpType::INVENTION_PATENT->value,
            'สิทธิบัตร' => IpType::PATENT->value,
            'อนุสิทธิบัตร' => IpType::PETTY_PATENT->value,
            'สิทธิบัตรการออกแบบ' => IpType::DESIGN_PATENT->value,
            'ลิขสิทธิ์' => IpType::COPYRIGHT->value,
            'เครื่องหมายการค้า' => IpType::TRADEMARK->value,
            'GI' => IpType::GI->value,
            'ภูมิปัญญาดั้งเดิม' => IpType::TK->value,
            'ภูมิปัญญาท้องถิ่น' => IpType::LOCAL_WISDOM->value,
            'ความลับทางการค้า' => IpType::TRADE_SECRET->value,
            'อื่นๆ' => IpType::OTHER->value,
        ];

        return $mapping[$typeThai] ?? null;
    }

    /**
     * แปลงสถานะจากภาษาไทยเป็น enum value
     */
    protected function mapStatus($statusThai): string
    {
        $mapping = [
            'ร่าง' => IpStatus::DRAFT->value,
            'ยื่นคำขอ' => IpStatus::SUBMITTED->value,
            'รอพิจารณา' => IpStatus::UNDER_REVIEW->value,
            'จดทะเบียนแล้ว' => IpStatus::REGISTERED->value,
            'ใช้งานอยู่' => IpStatus::ACTIVE->value,
            'ปฏิเสธ' => IpStatus::REJECTED->value,
            'หมดอายุ' => IpStatus::EXPIRED->value,
        ];

        return $mapping[$statusThai] ?? IpStatus::SUBMITTED->value;
    }

    /**
     * แปลงวันที่จาก Excel (รองรับหลายรูปแบบ)
     */
    protected function parseDate($date): ?string
    {
        if (empty($date)) {
            return null;
        }

        try {
            // ถ้าเป็นตัวเลข (Excel serial date)
            if (is_numeric($date)) {
                return \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($date)->format('Y-m-d');
            }

            // ถ้าเป็น string
            $parsedDate = Carbon::parse($date);
            return $parsedDate->format('Y-m-d');

        } catch (\Exception $e) {
            Log::warning('Date parsing failed', ['date' => $date, 'error' => $e->getMessage()]);
            return null;
        }
    }

    /**
     * Validation rules
     */
    public function rules(): array
    {
        return [
            'chue_phon_ngan' => 'required|string|max:255',
            'prapheth' => 'required|string',
            'kham_othbai' => 'nullable|string',
        ];
    }

    /**
     * Error handling
     */
    public function onError(\Throwable $e)
    {
        $this->importResults['errors'][] = "System Error: " . $e->getMessage();
        Log::error('IP Import System Error', ['error' => $e->getMessage()]);
    }

    public function onFailure(\Maatwebsite\Excel\Validators\Failure ...$failures)
    {
        foreach ($failures as $failure) {
            $this->importResults['errors'][] = "Row {$failure->row()}: " . implode(', ', $failure->errors());
        }
    }

    /**
     * Batch insert size
     */
    public function batchSize(): int
    {
        return 100;
    }

    /**
     * Chunk reading size
     */
    public function chunkSize(): int
    {
        return 100;
    }

    /**
     * Get import results
     */
    public function getResults(): array
    {
        return $this->importResults;
    }
}
