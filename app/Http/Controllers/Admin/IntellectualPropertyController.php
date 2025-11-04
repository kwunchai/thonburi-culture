<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreIpRequest;
use App\Http\Requests\UpdateIpRequest;
use App\Models\IntellectualProperty;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

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

    public function export()
    {
        $items = IntellectualProperty::all();

        $csvContent = "\xEF\xBB\xBF"; // UTF-8 BOM
        $csvContent .= "ลำดับ,ชื่อเรื่อง,เลขทะเบียน,ประเภท,สถานะ,วันหมดอายุ,วันที่สร้าง\n";

        foreach ($items as $index => $item) {
            $csvContent .= ($index + 1) . ',';
            $csvContent .= '"' . str_replace('"', '""', $item->title) . '",';
            $csvContent .= '"' . str_replace('"', '""', $item->registration_number ?? '') . '",';
            $csvContent .= '"' . str_replace('"', '""', $item->type?->label() ?? '') . '",';
            $csvContent .= '"' . str_replace('"', '""', $item->status?->label() ?? '') . '",';
            $csvContent .= ($item->expiry_date ? $item->expiry_date->format('d/m/Y') : '') . ',';
            $csvContent .= $item->created_at->format('d/m/Y H:i');
            $csvContent .= "\n";
        }

        return response($csvContent)
            ->header('Content-Type', 'text/csv; charset=UTF-8')
            ->header('Content-Disposition', 'attachment; filename="intellectual-property-' . date('Y-m-d') . '.csv"');
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

    public function destroy(IntellectualProperty $ip)
    {
        if ($ip->certificate_path) Storage::disk('public')->delete($ip->certificate_path);
        $ip->delete();
        return back()->with('success','ลบข้อมูลแล้ว');
    }
}
