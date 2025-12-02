<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Product;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $products = Product::with('category')
            ->orderByDesc('purchase_count')
            ->latest()
            ->take(6)
            ->get();

        $courses = Course::orderByDesc('enrollment_count')
            ->latest()
            ->take(3)
            ->get();

        return view('home', compact('products', 'courses'));
    }
}
