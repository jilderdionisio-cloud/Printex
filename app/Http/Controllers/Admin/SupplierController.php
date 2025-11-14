<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SupplierController extends Controller
{
    public function index(): View
    {
        $suppliers = Supplier::latest()->paginate(15);

        return view('admin.suppliers.index', compact('suppliers'));
    }

    public function create(): View
    {
        return view('admin.suppliers.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'ruc' => ['nullable', 'string', 'max:20'],
            'contact' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'address' => ['nullable', 'string', 'max:255'],
            'products' => ['nullable', 'string'],
        ]);

        Supplier::create($data);

        return redirect()->route('admin.suppliers.index')->with('status', 'Proveedor registrado correctamente.');
    }

    public function edit(int $id): View
    {
        $supplier = Supplier::findOrFail($id);

        return view('admin.suppliers.edit', compact('supplier'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $supplier = Supplier::findOrFail($id);

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'ruc' => ['nullable', 'string', 'max:20'],
            'contact' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'address' => ['nullable', 'string', 'max:255'],
            'products' => ['nullable', 'string'],
        ]);

        $supplier->update($data);

        return redirect()->route('admin.suppliers.index')->with('status', 'Proveedor actualizado correctamente.');
    }

    public function destroy(int $id): RedirectResponse
    {
        Supplier::whereKey($id)->delete();

        return redirect()->route('admin.suppliers.index')->with('status', 'Proveedor eliminado.');
    }
}
