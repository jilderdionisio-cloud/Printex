<?php

namespace App\Http\Controllers;

use App\Models\SupportRequest;
use App\Models\CourseEnrollment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Support\AuditLogger;

class SupportRequestController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'course_id' => ['required', 'integer', 'exists:courses,id'],
            'message' => ['required', 'string', 'min:10'],
        ]);

        $userId = Auth::id();
        $enrolled = CourseEnrollment::where('user_id', $userId)
            ->where('course_id', $data['course_id'])
            ->exists();

        if (! $enrolled) {
            return back()->withErrors('Solo puedes solicitar asesoría si ya adquiriste este curso.');
        }

        $supportRequest = SupportRequest::create([
            'user_id' => $userId,
            'course_id' => $data['course_id'],
            'message' => $data['message'],
            'status' => 'Pendiente',
        ]);

        AuditLogger::log('created', $supportRequest);

        return back()->with('status', 'Solicitud de asesoría enviada. Un asesor te contactará pronto. (Servicio con costo adicional)');
    }
}
