<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Audit;
use Illuminate\View\View;

class AuditController extends Controller
{
    public function index(): View
    {
        $audits = Audit::with('user')
            ->latest()
            ->paginate(50);

        return view('admin.audits.index', compact('audits'));
    }
}
