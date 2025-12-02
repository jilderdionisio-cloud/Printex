<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Course;
use Illuminate\View\View;

class TopItemsController extends Controller
{
    public function index(): View
    {
        $topProducts = Product::orderByDesc('purchase_count')->take(10)->get();
        $topCourses = Course::orderByDesc('enrollment_count')->take(10)->get();

        return view('admin.top-items.index', compact('topProducts', 'topCourses'));
    }
}
