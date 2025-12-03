<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseEnrollment;
use Illuminate\Support\Facades\DB;
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
            'payment_reference_transfer' => ['nullable', 'string', 'max:255'],
            'card_number' => ['nullable', 'string', 'max:32'],
            'card_exp' => ['nullable', 'string', 'max:8'],
            'card_cvv' => ['nullable', 'string', 'max:8'],
        ]);

        CourseEnrollment::updateOrCreate(
            [
                'course_id' => $course->id,
                'user_id' => $user->id,
            ],
            [
                'student_name' => $user->name ?? null,
                'student_email' => $user->email ?? null,
                'student_phone' => $user->phone ?? '',
                'student_address' => $user->address ?? '',
                'status' => 'Activo',
            ]
        );

        return back()->with('status', 'Pago exitoso.');
    }
}
