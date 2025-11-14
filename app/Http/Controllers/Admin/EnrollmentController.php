<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CourseEnrollment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EnrollmentController extends Controller
{
    public function index(): View
    {
        $enrollments = CourseEnrollment::with(['course', 'user'])->latest()->paginate(20);

        return view('admin.enrollments.index', compact('enrollments'));
    }

    public function show(int $id): View
    {
        $enrollment = CourseEnrollment::with(['course', 'user'])->findOrFail($id);

        return view('admin.enrollments.show', compact('enrollment'));
    }

    public function updateStatus(Request $request, int $id): RedirectResponse
    {
        $enrollment = CourseEnrollment::findOrFail($id);

        $data = $request->validate([
            'status' => ['required', 'string', 'max:50'],
        ]);

        $enrollment->update($data);

        return back()->with('status', 'Estado de inscripción actualizado.');
    }
}
