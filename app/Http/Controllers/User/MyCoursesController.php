<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MyCoursesController extends Controller
{
    public function index(Request $request): View
    {
        $enrollments = $request->user()
            ->courseEnrollments()
            ->with('course')
            ->latest()
            ->paginate(10);

        return view('my-courses.index', compact('enrollments'));
    }
}
