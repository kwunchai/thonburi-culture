<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreIntellectualPropertyRequest;
use App\Http\Requests\UpdateIntellectualPropertyRequest;
use App\Http\Resources\IntellectualPropertyResource;
use App\Models\IntellectualProperty;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class IntellectualPropertyController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(IntellectualProperty::class, 'ip');
    }

    /**
     * Display a listing of intellectual properties.
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $query = IntellectualProperty::query()
            ->with(['owner', 'creator', 'updater']);

        // Search functionality
        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('title', 'like', "%{$searchTerm}%")
                  ->orWhere('description', 'like', "%{$searchTerm}%");
            });
        }

        // Filter by type
        if ($request->has('type')) {
            $query->where('type', $request->type);
        }

        // Filter by owner
        if ($request->has('owner_id')) {
            $query->where('owner_id', $request->owner_id);
        }

        // Filter by status
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        // Filter expiring soon
        if ($request->has('expiring_soon')) {
            $days = $request->input('expiring_days', 30);
            $query->whereNotNull('expiry_date')
                  ->where('expiry_date', '<=', now()->addDays($days));
        }

        // Sorting
        $sortBy = $request->input('sort_by', 'created_at');
        $sortOrder = $request->input('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        // Pagination
        $perPage = $request->input('per_page', 15);
        $ips = $query->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => IntellectualPropertyResource::collection($ips),
            'pagination' => [
                'total' => $ips->total(),
                'per_page' => $ips->perPage(),
                'current_page' => $ips->currentPage(),
                'last_page' => $ips->lastPage(),
                'from' => $ips->firstItem(),
                'to' => $ips->lastItem(),
            ],
        ]);
    }

    /**
     * Store a newly created intellectual property.
     * 
     * @param StoreIntellectualPropertyRequest $request
     * @return JsonResponse
     */
    public function store(StoreIntellectualPropertyRequest $request): JsonResponse
    {
        DB::beginTransaction();
        
        try {
            $data = $request->validated();
            
            // Set ownership and creation tracking
            $data['owner_id'] = Auth::id();
            $data['created_by'] = Auth::id();
            $data['ip_id'] = 'IP-' . strtoupper(uniqid());
            
            // Handle file uploads
            if ($request->hasFile('attachments')) {
                $attachments = [];
                foreach ($request->file('attachments') as $file) {
                    $path = $file->store('intellectual-properties', 'public');
                    $attachments[] = [
                        'name' => $file->getClientOriginalName(),
                        'path' => $path,
                        'size' => $file->getSize(),
                        'mime' => $file->getMimeType(),
                        'uploaded_at' => now()->toIso8601String(),
                    ];
                }
                $data['attachments'] = $attachments;
            }
            
            // Create the IP record
            $ip = IntellectualProperty::create($data);
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'สร้างทรัพย์สินทางปัญญาสำเร็จ',
                'data' => new IntellectualPropertyResource($ip->load(['owner', 'creator'])),
            ], 201);
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => 'เกิดข้อผิดพลาดในการสร้างทรัพย์สินทางปัญญา',
                'error' => config('app.debug') ? $e->getMessage() : 'Internal server error',
            ], 500);
        }
    }

    /**
     * Display the specified intellectual property.
     * 
     * @param IntellectualProperty $ip
     * @return JsonResponse
     */
    public function show(IntellectualProperty $ip): JsonResponse
    {
        $ip->load(['owner', 'creator', 'updater']);

        return response()->json([
            'success' => true,
            'data' => new IntellectualPropertyResource($ip),
        ]);
    }

    /**
     * Update the specified intellectual property.
     * 
     * @param UpdateIntellectualPropertyRequest $request
     * @param IntellectualProperty $ip
     * @return JsonResponse
     */
    public function update(UpdateIntellectualPropertyRequest $request, IntellectualProperty $ip): JsonResponse
    {
        DB::beginTransaction();
        
        try {
            $data = $request->validated();
            
            // Set update tracking
            $data['updated_by'] = Auth::id();
            
            // Handle new file uploads
            if ($request->hasFile('attachments')) {
                $existingAttachments = $ip->attachments ?? [];
                $newAttachments = [];
                
                foreach ($request->file('attachments') as $file) {
                    $path = $file->store('intellectual-properties', 'public');
                    $newAttachments[] = [
                        'name' => $file->getClientOriginalName(),
                        'path' => $path,
                        'size' => $file->getSize(),
                        'mime' => $file->getMimeType(),
                        'uploaded_at' => now()->toIso8601String(),
                    ];
                }
                
                $data['attachments'] = array_merge($existingAttachments, $newAttachments);
            }
            
            // Update the IP record
            $ip->update($data);
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'อัพเดททรัพย์สินทางปัญญาสำเร็จ',
                'data' => new IntellectualPropertyResource($ip->fresh(['owner', 'updater'])),
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => 'เกิดข้อผิดพลาดในการอัพเดททรัพย์สินทางปัญญา',
                'error' => config('app.debug') ? $e->getMessage() : 'Internal server error',
            ], 500);
        }
    }

    /**
     * Remove the specified intellectual property.
     * 
     * @param IntellectualProperty $ip
     * @return JsonResponse
     */
    public function destroy(IntellectualProperty $ip): JsonResponse
    {
        try {
            // Authorization is handled by the policy through authorizeResource
            
            // Delete associated files
            if ($ip->attachments) {
                foreach ($ip->attachments as $attachment) {
                    Storage::disk('public')->delete($attachment['path']);
                }
            }
            
            // Soft delete the record
            $ip->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'ลบทรัพย์สินทางปัญญาสำเร็จ',
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'เกิดข้อผิดพลาดในการลบทรัพย์สินทางปัญญา',
                'error' => config('app.debug') ? $e->getMessage() : 'Internal server error',
            ], 500);
        }
    }

    /**
     * Get statistics of intellectual properties.
     * 
     * @return JsonResponse
     */
    public function statistics(): JsonResponse
    {
        $stats = [
            'total' => IntellectualProperty::count(),
            'by_type' => IntellectualProperty::select('type', DB::raw('count(*) as count'))
                ->groupBy('type')
                ->pluck('count', 'type'),
            'by_status' => IntellectualProperty::select('status', DB::raw('count(*) as count'))
                ->groupBy('status')
                ->pluck('count', 'status'),
            'expiring_soon' => IntellectualProperty::expiringSoon(30)->count(),
            'expired' => IntellectualProperty::where('status', 'expired')->count(),
        ];

        return response()->json([
            'success' => true,
            'data' => $stats,
        ]);
    }
}