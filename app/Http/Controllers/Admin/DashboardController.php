<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Order;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        //Muestra la nfromacion 
        $metrics = [
            'sales' => Order::sum('total'),
            'pending_orders' => Order::where('status', 'Pendiente')->count(),
            'active_courses' => Course::count(),
            'new_users' => User::where('created_at', '>=', now()->subDays(30))->count(),
        ];
       //Buscar cursos populares
        $popularCourses = Course::withCount('enrollments')
            ->orderByDesc('enrollments_count')
            ->take(5)
            ->get();

        $months = collect(range(0, 11))->map(function ($i) {
            $date = now()->startOfMonth()->subMonths(11 - $i);

            return [
                'key' => $date->format('Y-m'),
                'label' => $date->translatedFormat('M Y'),
            ];
        });

        $salesRaw = Order::selectRaw("DATE_FORMAT(created_at, '%Y-%m') as ym, SUM(total) as total")
            ->where('created_at', '>=', now()->startOfMonth()->subMonths(11))
            ->groupBy('ym')
            ->orderBy('ym')
            ->pluck('total', 'ym');

        $salesSeries = $months->map(function ($m) use ($salesRaw) {
            return [
                'label' => $m['label'],
                'total' => (float) ($salesRaw[$m['key']] ?? 0),
            ];
        });

        $statusRaw = Order::selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        $statusSeries = $statusRaw->map(function ($total, $status) {
            return [
                'status' => $status ?: 'Sin estado',
                'total' => (int) $total,
            ];
        })->values();

        return view('admin.dashboard', compact('metrics', 'popularCourses', 'salesSeries', 'statusSeries'));
    }
}
