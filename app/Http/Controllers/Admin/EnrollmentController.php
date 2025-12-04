<?php
//inscripcion
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CourseEnrollment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EnrollmentController extends Controller
{
    //Ver todas las inscripciones
    public function index(): View
    {
        $allowedStatuses = ['Activo', 'Pendiente', 'Completado', 'Cancelado'];
        $statusFilter = request('status');

        $enrollments = CourseEnrollment::with(['course', 'user'])
            ->when($statusFilter && in_array($statusFilter, $allowedStatuses), function ($q) use ($statusFilter) {
                $q->where('status', $statusFilter);
            })
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('admin.enrollments.index', compact('enrollments', 'allowedStatuses', 'statusFilter'));
    }
    //Ver una inscripción específica
    public function show(int $id): View
    {
        $enrollment = CourseEnrollment::with(['course', 'user'])->findOrFail($id);

        return view('admin.enrollments.show', compact('enrollment'));
    }
    //Cambiar el estado de una inscripción
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
