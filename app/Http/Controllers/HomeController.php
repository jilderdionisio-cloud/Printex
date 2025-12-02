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
            ->latest()
            ->take(6)
            ->get();

        $courses = Course::latest()
            ->take(3)
            ->get();

        return view('home', compact('products', 'courses'));
    }
}
