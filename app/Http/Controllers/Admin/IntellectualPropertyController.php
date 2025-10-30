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
    public function index(Request $req)
    {
        $q = IntellectualProperty::query();

        if ($kw = $req->string('q')->toString()) {
            $q->where(function($w) use ($kw){
                $w->where('title','like',"%$kw%")
                  ->orWhere('registration_number','like',"%$kw%")
                  ->orWhere('description','like',"%$kw%");
            });
        }
        $items = $q->latest('ip_id')->paginate(20)->withQueryString();
        
        // สถิติสำหรับการ์ด
        $stats = [
            'total_items' => IntellectualProperty::count(),
            'active_items' => IntellectualProperty::where('status', 'active')->count(),
            'registered_items' => IntellectualProperty::where('status', 'registered')->count(),
            'pending_items' => IntellectualProperty::where('status', 'pending')->count(),
            'draft_items' => IntellectualProperty::where('status', 'draft')->count(),
            'expired_items' => IntellectualProperty::where('status', 'expired')->count(),
            'copyright_items' => IntellectualProperty::where('type', 'copyright')->count(),
            'patent_items' => IntellectualProperty::where('type', 'patent')->count(),
            'trademark_items' => IntellectualProperty::where('type', 'trademark')->count(),
            'local_wisdom_items' => IntellectualProperty::where('type', 'local_wisdom')->count(),
            'with_registration' => IntellectualProperty::whereNotNull('registration_number')->count(),
            'expiring_soon' => IntellectualProperty::whereBetween('expiry_date', [now(), now()->addDays(30)])->count(),
        ];
        
        return view('admin.ip.index', compact('items', 'stats'));
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
