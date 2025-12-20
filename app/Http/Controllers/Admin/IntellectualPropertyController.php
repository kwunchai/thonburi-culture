<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreIpRequest;
use App\Http\Requests\UpdateIpRequest;
use App\Models\IntellectualProperty;
use App\Imports\IntellectualPropertyImport;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class IntellectualPropertyController extends Controller
{
    public function index(Request $request)
    {
        $query = IntellectualProperty::query();

        // ค้นหาตามคำค้นหา
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                  ->orWhere('registration_number', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%');
            });
        }

        // กรองตามประเภท
        if ($request->has('type') && $request->type != '') {
            $query->where('type', $request->type);
        }

        // กรองตามสถานะ
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // เรียงลำดับ
        $order = $request->get('order', 'desc');
        $query->orderBy('created_at', $order);

        $items = $query->paginate(20);
        $items->appends($request->query());
        
        // สถิติสำหรับการ์ด
        $stats = [
            'total_items' => IntellectualProperty::count(),
            'active_items' => IntellectualProperty::where('status', 'active')->count(),
            'registered_items' => IntellectualProperty::where('status', 'registered')->count(),
            'pending_items' => IntellectualProperty::where('status', 'submitted')->count(),
            'draft_items' => IntellectualProperty::where('status', 'draft')->count(),
            'expired_items' => IntellectualProperty::where('status', 'expired')->count(),
            'copyright_items' => IntellectualProperty::where('type', 'copyright')->count(),
            'patent_items' => IntellectualProperty::where('type', 'invention_patent')->count(),
            'trademark_items' => IntellectualProperty::where('type', 'trademark')->count(),
            'local_wisdom_items' => IntellectualProperty::where('type', 'tk')->count(),
            'with_registration' => IntellectualProperty::whereNotNull('registration_number')->count(),
            'expiring_soon' => IntellectualProperty::whereBetween('expiry_date', [now(), now()->addDays(30)])->count(),
        ];
        
        return view('admin.ip.index', compact('items', 'stats'));
    }

    public function export(Request $request)
    {
        try {
            // Simple test response first
            $format = $request->get('export', 'excel');
            
            if ($format === 'test') {
                return response()->json(['message' => 'Export method is working!']);
            }
            
            $query = IntellectualProperty::query();
            
            // Apply same filters as index
            if ($request->has('search') && $request->search != '') {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('title', 'like', '%' . $search . '%')
                      ->orWhere('registration_number', 'like', '%' . $search . '%')
                      ->orWhere('description', 'like', '%' . $search . '%');
                });
            }
            
            if ($request->has('type') && $request->type != '') {
                $query->where('type', $request->type);
            }
            
            if ($request->has('status') && $request->status != '') {
                $query->where('status', $request->status);
            }
            
            $items = $query->orderBy('created_at', 'desc')->get();
            
            // Simple CSV export
            $filename = 'intellectual-property-' . date('Y-m-d') . '.csv';
            
            $csvContent = "\xEF\xBB\xBF"; // UTF-8 BOM
            $csvContent .= "ID,ชื่อเรื่อง,เลขทะเบียน,ประเภท,สถานะ,วันที่สร้าง\n";
            
            foreach ($items as $item) {
                $csvContent .= $item->id . ',';
                $csvContent .= '"' . str_replace('"', '""', $item->title) . '",';
                $csvContent .= '"' . str_replace('"', '""', $item->registration_number ?? '') . '",';
                $csvContent .= '"' . str_replace('"', '""', $item->type_label ?? $item->type ?? '') . '",';
                $csvContent .= '"' . str_replace('"', '""', $item->status_label ?? $item->status ?? '') . '",';
                $csvContent .= $item->created_at->format('d/m/Y H:i');
                $csvContent .= "\n";
            }
            
            return response($csvContent)
                ->header('Content-Type', 'text/csv; charset=UTF-8')
                ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
                
        } catch (\Exception $e) {
            // Return error as JSON for debugging
            return response()->json([
                'error' => 'Export failed',
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ], 500);
        }
    }

    public function create()
    {
        return view('admin.ip.create');
    }

    public function store(StoreIpRequest $request)
    {
        $data = $request->validated();

        // upload certificate
        if ($request->hasFile('certificate')) {
            $data['certificate_path'] = $request->file('certificate')->store('ip/certificates','public');
        }

        $data['slug'] = Str::slug(mb_substr($data['title'],0,60)).'-'.Str::random(6);
        $ip = IntellectualProperty::create($data);

        return redirect()->route('admin.ip.index')->with('success','บันทึกข้อมูลเรียบร้อย');
    }

    public function edit(IntellectualProperty $ip)
    {
        return view('admin.ip.edit', compact('ip'));
    }

    public function update(UpdateIpRequest $request, IntellectualProperty $ip)
    {
        $data = $request->validated();
        if ($request->hasFile('certificate')) {
            if ($ip->certificate_path) Storage::disk('public')->delete($ip->certificate_path);
            $data['certificate_path'] = $request->file('certificate')->store('ip/certificates','public');
        }
        $ip->update($data);
        return redirect()->route('admin.ip.index')->with('success','อัปเดตเรียบร้อย');
    }

    public function show(IntellectualProperty $ip)
    {
        // Load relationships to prevent N+1 queries
        $ip->load(['owner', 'creator', 'updater']);
        
        return view('admin.ip.show', compact('ip'));
    }

    public function destroy(IntellectualProperty $ip)
    {
        if ($ip->certificate_path) Storage::disk('public')->delete($ip->certificate_path);
        $ip->delete();
        return back()->with('success','ลบข้อมูลแล้ว');
    }

    /**
     * Bulk delete multiple IP records
     * Uses soft delete for safety - records can be restored if needed
     */
    public function bulkDestroy(Request $request)
    {
        // Log request details for debugging
        Log::info('Bulk destroy request received', [
            'method' => $request->method(),
            'url' => $request->fullUrl(),
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'selected_ids' => $request->input('selected_ids'),
            'all_input' => $request->all()
        ]);

        // Validate input
        $validated = $request->validate([
            'selected_ids' => 'required|array|min:1',
            'selected_ids.*' => 'required|integer|exists:intellectual_properties,ip_id'
        ], [
            'selected_ids.required' => 'กรุณาเลือกรายการที่ต้องการลบ',
            'selected_ids.min' => 'กรุณาเลือกอย่างน้อย 1 รายการ',
            'selected_ids.*.exists' => 'พบรายการที่ไม่ถูกต้อง'
        ]);

        try {
            \DB::beginTransaction();

            $ids = $validated['selected_ids'];
            $count = 0;

            // Retrieve all IPs to delete
            $ips = IntellectualProperty::whereIn('ip_id', $ids)->get();

            foreach ($ips as $ip) {
                // Delete associated files if they exist
                if ($ip->certificate_path && Storage::disk('public')->exists($ip->certificate_path)) {
                    Storage::disk('public')->delete($ip->certificate_path);
                }

                // Delete attachments if they exist
                if (!empty($ip->attachments) && is_array($ip->attachments)) {
                    foreach ($ip->attachments as $attachment) {
                        if (isset($attachment['path']) && Storage::disk('public')->exists($attachment['path'])) {
                            Storage::disk('public')->delete($attachment['path']);
                        }
                    }
                }

                // Soft delete the IP record (can be restored)
                $ip->delete();
                $count++;
            }

            \DB::commit();

            Log::info("Successfully deleted {$count} IP items");

            // Return JSON for AJAX requests
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => "ลบทรัพย์สินทางปัญญา {$count} รายการเรียบร้อยแล้ว",
                    'count' => $count
                ]);
            }

            return redirect()
                ->route('admin.ip.index')
                ->with('success', "ลบทรัพย์สินทางปัญญา {$count} รายการเรียบร้อยแล้ว");

        } catch (\Exception $e) {
            \DB::rollBack();
            
            Log::error('Bulk delete IP failed: ' . $e->getMessage(), [
                'ids' => $ids ?? [],
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            // Return JSON for AJAX requests
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'เกิดข้อผิดพลาดในการลบข้อมูล: ' . $e->getMessage()
                ], 500);
            }

            return redirect()
                ->back()
                ->with('error', 'เกิดข้อผิดพลาดในการลบข้อมูล: ' . $e->getMessage());
        }
    }

    /**
     * แสดงหน้าฟอร์ม Import Excel
     */
    public function showImportForm()
    {
        return view('admin.intellectual-property.import');
    }

    /**
     * Import ข้อมูลจากไฟล์ Excel
     */
    public function import(Request $request)
    {
        // Validation
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:5120', // Max 5MB
        ], [
            'file.required' => 'กรุณาเลือกไฟล์ Excel',
            'file.mimes' => 'ไฟล์ต้องเป็นนามสกุล .xlsx, .xls หรือ .csv เท่านั้น',
            'file.max' => 'ขนาดไฟล์ต้องไม่เกิน 5 MB',
        ]);

        try {
            $file = $request->file('file');
            
            // สร้าง Import instance
            $import = new IntellectualPropertyImport(auth()->id());
            
            // Import ข้อมูล
            Excel::import($import, $file);
            
            // ดึงผลลัพธ์
            $results = $import->getResults();
            
            // สร้าง summary message
            $message = "นำเข้าข้อมูลสำเร็จ {$results['success']} รายการ";
            if ($results['skipped'] > 0) {
                $message .= ", ข้ามไป {$results['skipped']} รายการ";
            }
            
            // Log results
            Log::info('IP Import Completed', $results);
            
            // Return with results
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => $message,
                    'results' => $results,
                ]);
            }
            
            return redirect()
                ->route('admin.intellectual-property.index')
                ->with('success', $message)
                ->with('import_details', $results);

        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            $errors = [];
            
            foreach ($failures as $failure) {
                $errors[] = "แถว {$failure->row()}: " . implode(', ', $failure->errors());
            }
            
            Log::error('IP Import Validation Failed', ['errors' => $errors]);
            
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'ข้อมูลในไฟล์ไม่ถูกต้อง',
                    'errors' => $errors,
                ], 422);
            }
            
            return redirect()
                ->back()
                ->with('error', 'ข้อมูลในไฟล์ไม่ถูกต้อง')
                ->with('import_errors', $errors);

        } catch (\Exception $e) {
            Log::error('IP Import Failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'เกิดข้อผิดพลาด: ' . $e->getMessage(),
                ], 500);
            }
            
            return redirect()
                ->back()
                ->with('error', 'เกิดข้อผิดพลาดในการนำเข้าข้อมูล: ' . $e->getMessage());
        }
    }

    /**
     * ดาวน์โหลด Template Excel สำหรับ Import
     */
    public function downloadTemplate()
    {
        $templatePath = storage_path('app/templates/ip_import_template.xlsx');
        
        if (file_exists($templatePath)) {
            return response()->download($templatePath, 'แบบฟอร์มนำเข้าข้อมูลทรัพย์สินทางปัญญา.xlsx');
        }
        
        return redirect()
            ->back()
            ->with('error', 'ไม่พบไฟล์ Template');
    }
}
