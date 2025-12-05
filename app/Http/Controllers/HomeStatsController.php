<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

// ปรับให้ตรงกับโมเดลจริงของโปรเจ็กต์คุณ
use App\Models\CulturalItem;
// use App\Models\Research; // Table not exists
use App\Models\IntellectualProperty;
// use App\Models\Innovation; // Table not exists  
// use App\Models\Place; // Table not exists
use App\Models\Community;

class HomeStatsController extends Controller
{
    public function index(Request $request)
    {
        $months = max(3, (int) $request->integer('months', 12)); // ปลอดภัยขั้นต่ำ 3 เดือน
        $from   = now()->subMonths($months - 1)->startOfMonth();
        $to     = now()->endOfMonth();

        $payload = Cache::remember("home_stats:$months", now()->addMinutes(10), function () use ($months, $from, $to) {
            // สร้างป้ายเดือน เช่น ["2024-09","2024-10",...]
            $labels = [];
            for ($i = 0; $i < $months; $i++) {
                $labels[] = $from->copy()->addMonths($i)->format('Y-m');
            }

            $seriesFor = function (string $model) use ($from, $to, $labels) {
                /** @var \Illuminate\Database\Eloquent\Model $model */
                // Use strftime for SQLite, DATE_FORMAT for MySQL
                $dateFormat = DB::connection()->getDriverName() === 'sqlite' 
                    ? "strftime('%Y-%m', created_at)"
                    : "DATE_FORMAT(created_at, '%Y-%m')";
                
                $rows = $model::whereBetween('created_at', [$from, $to])
                    ->selectRaw("{$dateFormat} as ym, COUNT(*) as c")
                    ->groupBy('ym')
                    ->pluck('c', 'ym')
                    ->toArray();

                // เติม 0 ให้เดือนที่ไม่มีข้อมูล
                return array_map(fn ($ym) => $rows[$ym] ?? 0, $labels);
            };

            return [
                'labels' => $labels,
                'line' => [
                    'cultural' => $seriesFor(CulturalItem::class),
                    // 'research' => $seriesFor(Research::class), // Table not exists
                    'research' => array_fill(0, 12, 0), // Dummy data
                    'ip'       => $seriesFor(IntellectualProperty::class),
                    // 'innov'    => $seriesFor(Innovation::class), // Table not exists 
                    'innov'    => array_fill(0, 12, 0), // Dummy data
                    // 'places'   => $seriesFor(Place::class), // Table not exists
                    'places'   => array_fill(0, 12, 0), // Dummy data
                ],
                'ipTypes' => IntellectualProperty::select('type', DB::raw('COUNT(*) c'))
                    ->groupBy('type')->pluck('c', 'type'), // {"GI":10,"copyright":5,...}

                'topCommunities' => Community::withCount('culturalItems')
                    ->orderByDesc('cultural_items_count')
                    ->take(5)
                    ->get(['id', 'name'])
                    ->map(fn ($c) => ['name' => $c->name, 'count' => $c->cultural_items_count])
                    ->values(),
            ];
        });

        return response()->json($payload);
    }
}
