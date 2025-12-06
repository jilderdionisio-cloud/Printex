<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\User;
use App\Support\AuditLogger;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CourseController extends Controller
{
   // Ver la lista de cursos
    public function index(): View
    {
        $courses = Course::orderBy('id')->paginate(15);

        return view('admin.courses.index', compact('courses'));
    }
    //Mostrar el formulario para crear
    public function create(): View
    {
        $instructors = $this->instructorsList();

        return view('admin.courses.create', compact('instructors'));
    }
   //Guardar un curso nuevo
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'duration_hours' => ['required', 'integer', 'min:1'],
            'modality' => ['required', 'string', 'max:50'],
            'slots' => ['required', 'integer', 'min:1'],
            'instructor' => ['required', 'string', 'max:255'],
            'image' => ['nullable', 'image', 'max:2048'],
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('courses', 'public');
        }

        $course = Course::create($data);
        AuditLogger::log('created', $course);

        return redirect()->route('admin.courses.index')->with('status', 'Curso creado correctamente.');
    }
    //Ver formulario para editar un curso
    public function edit(int $id): View
    {
        $course = Course::findOrFail($id);
        $instructors = $this->instructorsList();

        return view('admin.courses.edit', compact('course', 'instructors'));
    }
   //Guardar los cambios de un curso
    public function update(Request $request, int $id): RedirectResponse
    {
        $course = Course::findOrFail($id);

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'duration_hours' => ['required', 'integer', 'min:1'],
            'modality' => ['required', 'string', 'max:50'],
            'slots' => ['required', 'integer', 'min:1'],
            'instructor' => ['required', 'string', 'max:255'],
            'image' => ['nullable', 'image', 'max:2048'],
        ]);

        if ($request->hasFile('image')) {
            if ($course->image && ! Str::startsWith($course->image, ['http://', 'https://'])) {
                Storage::disk('public')->delete($course->image);
            }
            $data['image'] = $request->file('image')->store('courses', 'public');
        }

        $course->update($data);
        AuditLogger::log('updated', $course);

        return redirect()->route('admin.courses.index')->with('status', 'Curso actualizado correctamente.');
    }
   //Borrar un curso
    public function destroy(int $id): RedirectResponse
    {
        $course = Course::findOrFail($id);
        $course->delete();
        AuditLogger::log('deleted', $course);

        return redirect()->route('admin.courses.index')->with('status', 'Curso eliminado.');
    }

    private function instructorsList()
    {
        $whitelist = [
            'maria.gomez@printex.com',
            'luis.rojas@printex.com',
            'carolina.mejia@printex.com',
        ];

        return User::where(function ($q) use ($whitelist) {
            $q->where('role', 'instructor')
                ->orWhereIn('email', $whitelist);
        })
            ->orderBy('name')
            ->get();
    }
}
