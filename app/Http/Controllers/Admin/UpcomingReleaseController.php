<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Product;
use App\Models\UpcomingRelease;
use App\Support\AuditLogger;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UpcomingReleaseController extends Controller
{
    public function index(): View
    {
        $releases = UpcomingRelease::with(['product', 'course'])
            ->latest()
            ->paginate(20);

        return view('admin.upcoming-releases.index', compact('releases'));
    }

    public function create(): View
    {
        $products = Product::orderBy('name')->get();
        $courses = Course::orderBy('name')->get();

        return view('admin.upcoming-releases.create', compact('products', 'courses'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validatedData($request);
        $release = UpcomingRelease::create($data);
        AuditLogger::log('created', $release);

        return redirect()->route('admin.upcoming-releases.index')->with('status', 'Próximo lanzamiento creado.');
    }

    public function edit(int $id): View
    {
        $release = UpcomingRelease::findOrFail($id);
        $products = Product::orderBy('name')->get();
        $courses = Course::orderBy('name')->get();

        return view('admin.upcoming-releases.edit', compact('release', 'products', 'courses'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $release = UpcomingRelease::findOrFail($id);
        $data = $this->validatedData($request);
        $release->update($data);
        AuditLogger::log('updated', $release);

        return redirect()->route('admin.upcoming-releases.index')->with('status', 'Próximo lanzamiento actualizado.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $release = UpcomingRelease::findOrFail($id);
        $release->delete();
        AuditLogger::log('deleted', $release);

        return redirect()->route('admin.upcoming-releases.index')->with('status', 'Próximo lanzamiento eliminado.');
    }

    private function validatedData(Request $request): array
    {
        $data = $request->validate([
            'type' => ['required', 'in:producto,curso'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'release_date' => ['nullable', 'date'],
            'status' => ['required', 'in:próximo,pospuesto,lanzado'],
            'product_id' => ['nullable', 'integer', 'exists:products,id'],
            'course_id' => ['nullable', 'integer', 'exists:courses,id'],
        ]);

        // Asegurar consistencia con el tipo
        if ($data['type'] === 'producto') {
            $data['course_id'] = null;
        } else {
            $data['product_id'] = null;
        }

        return $data;
    }
}
