<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseEnrollment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CoursePurchaseController extends Controller
{
    public function store(Request $request, Course $course): RedirectResponse
    {
        $user = $request->user();

        $request->validate([
            'payment_method' => ['required', 'string', 'max:50'],
            'payment_reference' => ['nullable', 'string', 'max:255'],
        ]);

        CourseEnrollment::updateOrCreate(
            [
                'course_id' => $course->id,
                'user_id' => $user->id,
            ],
            [
                'student_name' => $user->name ?? null,
                'student_email' => $user->email ?? null,
                'student_phone' => $user->phone ?? null,
                'student_address' => $user->address ?? null,
                'status' => 'Activo',
            ]
        );

        return back()->with('status', 'Pago exitoso.');
    }
}
