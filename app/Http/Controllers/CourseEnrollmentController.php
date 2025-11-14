<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseEnrollment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CourseEnrollmentController extends Controller
{
    public function store(Request $request, int $courseId): RedirectResponse
    {
        $course = Course::findOrFail($courseId);

        $data = $request->validate([
            'student_name' => ['required', 'string', 'max:255'],
            'student_email' => ['required', 'email', 'max:255'],
            'student_phone' => ['required', 'string', 'max:50'],
            'student_address' => ['required', 'string', 'max:255'],
        ]);

        CourseEnrollment::create([
            'course_id' => $course->id,
            'user_id' => auth()->id(),
            'student_name' => $data['student_name'],
            'student_email' => $data['student_email'],
            'student_phone' => $data['student_phone'],
            'student_address' => $data['student_address'],
            'status' => 'Activo',
        ]);

        return redirect()
            ->route('courses.show', $course->id)
            ->with('status', 'Inscripción registrada correctamente.');
    }
}
