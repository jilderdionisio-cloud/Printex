<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Order;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $metrics = [
            'sales' => Order::sum('total'),
            'pending_orders' => Order::where('status', 'Pendiente')->count(),
            'active_courses' => Course::count(),
            'new_users' => User::where('created_at', '>=', now()->subDays(30))->count(),
        ];

        $popularCourses = Course::withCount('enrollments')
            ->orderByDesc('enrollments_count')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('metrics', 'popularCourses'));
    }
}
