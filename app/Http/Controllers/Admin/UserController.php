<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        // ค้นหา
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%');
            });
        }

        // กรองตามบทบาท
        if ($request->has('role') && $request->role != '') {
            $query->where('role', $request->role);
        }

        // เรียงลำดับ
        $order = $request->get('order', 'desc');
        $query->orderBy('created_at', $order);

        $users = $query->paginate(20);
        $users->appends($request->query());
        
        // สถิติ
        $stats = [
            'total_users' => User::count(),
            'admin_users' => User::where('role', 'admin')->count(),
            'editor_users' => User::where('role', 'editor')->count(),
            'ip_manager_users' => User::where('role', 'ip_manager')->count(),
            'viewer_users' => User::where('role', 'viewer')->count(),
            'verified_users' => User::whereNotNull('email_verified_at')->count(),
            'unverified_users' => User::whereNull('email_verified_at')->count(),
        ];
        
        return view('admin.users.index', compact('users', 'stats'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,editor,ip_manager,viewer',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['email_verified_at'] = now();

        User::create($validated);

        return redirect()->route('admin.users.index')
            ->with('success', 'เพิ่มผู้ใช้งานเรียบร้อยแล้ว');
    }

    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'role' => 'required|in:admin,editor,ip_manager,viewer',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        if ($validated['password']) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('admin.users.index')
            ->with('success', 'อัปเดตข้อมูลผู้ใช้งานเรียบร้อยแล้ว');
    }

    public function destroy(User $user)
    {
        // ป้องกันการลบตัวเอง
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'ไม่สามารถลบบัญชีของตัวเองได้');
        }

        // ป้องกันการลบ admin สุดท้าย
        if ($user->role === 'admin' && User::where('role', 'admin')->count() <= 1) {
            return redirect()->route('admin.users.index')
                ->with('error', 'ไม่สามารถลบ Admin คนสุดท้ายได้');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'ลบผู้ใช้งานเรียบร้อยแล้ว');
    }

    public function toggleStatus(User $user)
    {
        $user->update([
            'email_verified_at' => $user->email_verified_at ? null : now()
        ]);

        $status = $user->email_verified_at ? 'เปิดใช้งาน' : 'ปิดใช้งาน';
        
        return redirect()->back()
            ->with('success', "เปลี่ยนสถานะผู้ใช้งานเป็น {$status} เรียบร้อยแล้ว");
    }
}
