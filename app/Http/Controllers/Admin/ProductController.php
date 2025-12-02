<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProductController extends Controller
{
    //Mostrar la lista de productos
    public function index(Request $request): View
    {
        $query = Product::with(['category', 'supplier']);

        if ($search = $request->string('search')->toString()) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        if ($categoryId = $request->integer('category')) {
            $query->where('category_id', $categoryId);
        }

        if ($sort = $request->input('sort')) {
            $query->when($sort === 'price_desc', fn ($q) => $q->orderByDesc('price'))
                ->when($sort === 'price_asc', fn ($q) => $q->orderBy('price'))
                ->when($sort === 'stock_desc', fn ($q) => $q->orderByDesc('stock'));
        } else {
            $query->latest();
        }

        $products = $query->paginate(15)->withQueryString();
        $categories = Category::orderBy('name')->get();

        return view('admin.products.index', compact('products', 'categories'));
    }
    //Mostrar formulario para crear un producto
    public function create(): View
    {
        $this->ensureDefaultCategory();
        $categories = Category::orderBy('name')->get();
        $suppliers = Supplier::orderBy('name')->get();

        return view('admin.products.create', compact('categories', 'suppliers'));
    }
    //Guardar un producto nuevo
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'category_id' => [
                'required',
                function ($attribute, $value, $fail) {
                    if ($value === 'new') {
                        return;
                    }
                    if (! Category::whereKey($value)->exists()) {
                        $fail('La categoría seleccionada no existe.');
                    }
                },
            ],
            'category_name_new' => ['required_if:category_id,new', 'string', 'max:255'],
            'category_description_new' => ['nullable', 'string', 'max:255'],
            'supplier_id' => ['required', 'exists:suppliers,id'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'image' => ['nullable', 'image', 'max:2048'],
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        if ($data['category_id'] === 'new') {
            $category = Category::create([
                'name' => $data['category_name_new'],
                'description' => $data['category_description_new'] ?? null,
            ]);
            $data['category_id'] = $category->id;
        }

        $product = Product::create($data);
        \App\Support\AuditLogger::log('created', $product);

        return redirect()->route('admin.products.index')->with('status', 'Producto creado correctamente.');
    }
    //Mostrar formulario para editar un producto
    public function edit(int $id): View
    {
        $product = Product::findOrFail($id);
        $this->ensureDefaultCategory();
        $categories = Category::orderBy('name')->get();
        $suppliers = Supplier::orderBy('name')->get();

        return view('admin.products.edit', compact('product', 'categories', 'suppliers'));
    }
    //Guardar cambios de un producto
    public function update(Request $request, int $id): RedirectResponse
    {
        $product = Product::findOrFail($id);

        $data = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'supplier_id' => ['required', 'exists:suppliers,id'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'image' => ['nullable', 'image', 'max:2048'],
        ]);

        if ($request->hasFile('image')) {
            if ($product->image && ! Str::startsWith($product->image, ['http://', 'https://'])) {
                Storage::disk('public')->delete($product->image);
            }
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);
        \App\Support\AuditLogger::log('updated', $product);

        return redirect()->route('admin.products.index')->with('status', 'Producto actualizado correctamente.');
    }
   //Borrar un producto
    public function destroy(int $id): RedirectResponse
    {
        $product = Product::findOrFail($id);
        $product->delete();
        \App\Support\AuditLogger::log('deleted', $product);

        return redirect()->route('admin.products.index')->with('status', 'Producto eliminado.');
    }

    private function ensureDefaultCategory(): void
    {
        if (Category::count() === 0) {
            Category::create([
                'name' => 'General',
                'description' => 'Categoría creada automáticamente.',
            ]);
        }
    }
}
