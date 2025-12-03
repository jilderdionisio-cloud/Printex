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
        $supplies = ['Tintas', 'Maquinaria', 'Papeles', 'Vinilos', 'Serigrafía', 'Kits'];
        return view('admin.suppliers.create', compact('supplies'));
    }

    public function store(Request $request): RedirectResponse
    {
        $supplies = ['Tintas', 'Maquinaria', 'Papeles', 'Vinilos', 'Serigrafía', 'Kits'];

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'ruc' => ['required', 'digits:11'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'address' => ['nullable', 'string', 'max:255'],
            'products' => ['nullable', 'array'],
            'products.*' => ['in:' . implode(',', $supplies)],
        ]);

        $data['products'] = $request->filled('products') ? implode(', ', $request->input('products')) : null;

        Supplier::create($data);

        return redirect()->route('admin.suppliers.index')->with('status', 'Proveedor registrado correctamente.');
    }

    public function edit(int $id): View
    {
        $supplier = Supplier::findOrFail($id);
        $supplies = ['Tintas', 'Maquinaria', 'Papeles', 'Vinilos', 'Serigrafía', 'Kits'];

        return view('admin.suppliers.edit', compact('supplier', 'supplies'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $supplier = Supplier::findOrFail($id);
        $supplies = ['Tintas', 'Maquinaria', 'Papeles', 'Vinilos', 'Serigrafía', 'Kits'];

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'ruc' => ['required', 'digits:11'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'address' => ['nullable', 'string', 'max:255'],
            'products' => ['nullable', 'array'],
            'products.*' => ['in:' . implode(',', $supplies)],
        ]);

        $data['products'] = $request->filled('products') ? implode(', ', $request->input('products')) : null;

        $supplier->update($data);

        return redirect()->route('admin.suppliers.index')->with('status', 'Proveedor actualizado correctamente.');
    }

    public function destroy(int $id): RedirectResponse
    {
        Supplier::whereKey($id)->delete();

        return redirect()->route('admin.suppliers.index')->with('status', 'Proveedor eliminado.');
    }
}
