<?php

namespace App\Http\Controllers;

use App\Models\SupportRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Support\AuditLogger;

class SupportRequestController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'course_id' => ['nullable', 'integer', 'exists:courses,id'],
            'message' => ['required', 'string', 'min:10'],
        ]);

        SupportRequest::create([
            'user_id' => Auth::id(),
            'course_id' => $data['course_id'] ?? null,
            'message' => $data['message'],
            'status' => 'Pendiente',
        ]);

        AuditLogger::log('created', $supportRequest);

        return back()->with('status', 'Solicitud de asesoría enviada. Un asesor te contactará pronto.');
    }
}
