<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\View\View;

class CourseController extends Controller
{
    public function index(): View
    {
        $courses = Course::latest()->get();

        $enrolledIds = auth()->check()
            ? auth()->user()->courseEnrollments()->pluck('course_id')->toArray()
            : [];

        return view('courses.index', compact('courses', 'enrolledIds'));
    }

    public function show(int $id): View
    {
        $course = Course::findOrFail($id);

        $isEnrolled = false;
        if (auth()->check()) {
            $isEnrolled = auth()->user()
                ->courseEnrollments()
                ->where('course_id', $course->id)
                ->exists();
        }

        return view('courses.show', compact('course', 'isEnrolled'));
    }
}
