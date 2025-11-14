<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\View\View;

class CourseController extends Controller
{
    public function index(): View
    {
        $courses = Course::latest()->get();

        return view('courses.index', compact('courses'));
    }

    public function show(int $id): View
    {
        $course = Course::findOrFail($id);

        return view('courses.show', compact('course'));
    }
}
