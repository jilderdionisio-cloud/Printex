<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SupportRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SupportRequestController extends Controller
{
    public function index(): View
    {
        $requests = SupportRequest::with(['user', 'course'])
            ->latest()
            ->paginate(20);

        return view('admin.support-requests.index', compact('requests'));
    }

    public function show(int $id): View
    {
        $requestSupport = SupportRequest::with(['user', 'course'])->findOrFail($id);

        return view('admin.support-requests.show', compact('requestSupport'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $data = $request->validate([
            'status' => ['required', 'in:Pendiente,En proceso,Resuelto'],
        ]);

        $requestSupport = SupportRequest::findOrFail($id);
        $requestSupport->update($data);
        \App\Support\AuditLogger::log('status_updated', $requestSupport);

        return back()->with('status', 'Estado actualizado.');
    }
}
