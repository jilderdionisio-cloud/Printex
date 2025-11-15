<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CourseController extends Controller
{
   // Ver la lista de cursos
    public function index(): View
    {
        $courses = Course::latest()->paginate(15);

        return view('admin.courses.index', compact('courses'));
    }
   //Mostrar el formulario para crear
    public function create(): View
    {
        return view('admin.courses.create');
    }
   //Guardar un curso nuevo
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'duration' => ['required', 'string', 'max:100'],
            'modality' => ['required', 'string', 'max:50'],
            'slots' => ['required', 'integer', 'min:1'],
            'instructor' => ['required', 'string', 'max:255'],
            'image' => ['nullable', 'url'],
        ]);

        Course::create($data);

        return redirect()->route('admin.courses.index')->with('status', 'Curso creado correctamente.');
    }
   //Ver formulario para editar un curso
    public function edit(int $id): View
    {
        $course = Course::findOrFail($id);

        return view('admin.courses.edit', compact('course'));
    }
   //Guardar los cambios de un curso
    public function update(Request $request, int $id): RedirectResponse
    {
        $course = Course::findOrFail($id);

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'duration' => ['required', 'string', 'max:100'],
            'modality' => ['required', 'string', 'max:50'],
            'slots' => ['required', 'integer', 'min:1'],
            'instructor' => ['required', 'string', 'max:255'],
            'image' => ['nullable', 'url'],
        ]);

        $course->update($data);

        return redirect()->route('admin.courses.index')->with('status', 'Curso actualizado correctamente.');
    }
   //Borrar un curso
    public function destroy(int $id): RedirectResponse
    {
        Course::whereKey($id)->delete();

        return redirect()->route('admin.courses.index')->with('status', 'Curso eliminado.');
    }
}
