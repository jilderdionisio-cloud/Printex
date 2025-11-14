<?php

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Route;

/**
 * Datos temporales para que las vistas Blade funcionen mientras se conecta el backend real.
 */

$categories = collect([
    ['id' => 1, 'name' => 'Tintas'],
    ['id' => 2, 'name' => 'Maquinaria'],
    ['id' => 3, 'name' => 'Papeles'],
    ['id' => 4, 'name' => 'Vinilos'],
    ['id' => 5, 'name' => 'Serigrafía'],
    ['id' => 6, 'name' => 'Herramientas'],
    ['id' => 7, 'name' => 'Kits'],
]);

$productsSeed = [
    ['name' => 'Tinta Sublimática EPSON 1L', 'price' => 89.90, 'category' => 'Tintas', 'stock' => 50, 'description' => 'Calidad premium para sublimación.', 'image' => 'https://images.unsplash.com/photo-1515165562835-c4c1bfa1c8ca?auto=format&fit=crop&w=800&q=80'],
    ['name' => 'Plancha Transfer 38x38cm', 'price' => 1850.00, 'category' => 'Maquinaria', 'stock' => 15, 'description' => 'Plancha profesional de alta presión.', 'image' => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?auto=format&fit=crop&w=800&q=80'],
    ['name' => 'Papel Transfer A4 (100 hojas)', 'price' => 45.00, 'category' => 'Papeles', 'stock' => 200, 'description' => 'Papel transfer compatible con tintas eco.', 'image' => 'https://images.unsplash.com/photo-1489515217757-5fd1be406fef?auto=format&fit=crop&w=800&q=80'],
    ['name' => 'Vinilo Textil Blanco Rollo 50cm', 'price' => 65.00, 'category' => 'Vinilos', 'stock' => 80, 'description' => 'Vinilo de corte con alta adherencia.', 'image' => 'https://images.unsplash.com/photo-1521572267360-ee0c2909d518?auto=format&fit=crop&w=800&q=80'],
    ['name' => 'Prensa Térmica 5 en 1', 'price' => 2350.00, 'category' => 'Maquinaria', 'stock' => 10, 'description' => 'Incluye accesorios para tazas, gorras y platos.', 'image' => 'https://images.unsplash.com/photo-1517430816045-df4b7de11d1d?auto=format&fit=crop&w=800&q=80'],
    ['name' => 'Marco Serigráfico 40x50cm', 'price' => 120.00, 'category' => 'Serigrafía', 'stock' => 35, 'description' => 'Aluminio reforzado, malla 120 hilos.', 'image' => 'https://images.unsplash.com/photo-1475180098004-ca77a66827be?auto=format&fit=crop&w=800&q=80'],
    ['name' => 'Tinta Plastisol Negro 1kg', 'price' => 95.00, 'category' => 'Tintas', 'stock' => 60, 'description' => 'Secado rápido, acabado brillante.', 'image' => 'https://images.unsplash.com/photo-1498050108023-c5249f4df085?auto=format&fit=crop&w=800&q=80'],
    ['name' => 'Emulsión Fotográfica 1L', 'price' => 85.00, 'category' => 'Serigrafía', 'stock' => 40, 'description' => 'Fácil de aplicar y revelar.', 'image' => 'https://images.unsplash.com/photo-1447933601403-0c6688de566e?auto=format&fit=crop&w=800&q=80'],
    ['name' => 'Rasqueta Serigrafía 30cm', 'price' => 25.00, 'category' => 'Herramientas', 'stock' => 100, 'description' => 'Mango ergonómico y goma reemplazable.', 'image' => 'https://images.unsplash.com/photo-1454165205744-3b78555e5572?auto=format&fit=crop&w=800&q=80'],
    ['name' => 'Impresora Sublimática A4', 'price' => 1650.00, 'category' => 'Maquinaria', 'stock' => 8, 'description' => 'Incluye sistema continuo y tintas iniciales.', 'image' => 'https://images.unsplash.com/photo-1448932223592-d1fc686e76ea?auto=format&fit=crop&w=800&q=80'],
    ['name' => 'Papel Sublimático A3 (100 hojas)', 'price' => 68.00, 'category' => 'Papeles', 'stock' => 150, 'description' => 'Secado rápido y alta transferencia.', 'image' => 'https://images.unsplash.com/photo-1473093295043-cdd812d0e601?auto=format&fit=crop&w=800&q=80'],
    ['name' => 'Kit Completo Iniciación Sublimación', 'price' => 3200.00, 'category' => 'Kits', 'stock' => 5, 'description' => 'Todo lo necesario para iniciar tu negocio.', 'image' => 'https://images.unsplash.com/photo-1492724441997-5dc865305da7?auto=format&fit=crop&w=800&q=80'],
];

$sampleProducts = collect($productsSeed)->map(function ($product, $index) use ($categories) {
    $category = $categories->firstWhere('name', $product['category']);
    return (object) [
        'id' => $index + 1,
        'name' => $product['name'],
        'description' => $product['description'],
        'price' => $product['price'],
        'category' => (object) $category,
        'category_id' => $category['id'],
        'stock' => $product['stock'],
        'image' => $product['image'],
        'sku' => 'PRX-' . str_pad($index + 1, 4, '0', STR_PAD_LEFT),
        'updated_at' => now(),
    ];
});

$sampleCourses = collect([
    ['name' => 'Curso Básico de Sublimación', 'price' => 350.00, 'duration' => '4 semanas', 'modality' => 'Presencial', 'slots' => 20, 'instructor' => 'Ana Gómez', 'description' => 'Aprende desde cero la técnica de sublimación.', 'image' => 'https://images.unsplash.com/photo-1457530378978-8bac673b8062?auto=format&fit=crop&w=800&q=80'],
    ['name' => 'Curso Avanzado de Serigrafía', 'price' => 450.00, 'duration' => '6 semanas', 'modality' => 'Presencial', 'slots' => 15, 'instructor' => 'Luis Ramos', 'description' => 'Profundiza en procesos avanzados de serigrafía.', 'image' => 'https://images.unsplash.com/photo-1506784983877-45594efa4cbe?auto=format&fit=crop&w=800&q=80'],
    ['name' => 'Curso Transfer y Estampado Textil', 'price' => 400.00, 'duration' => '5 semanas', 'modality' => 'Híbrido', 'slots' => 18, 'instructor' => 'María Torres', 'description' => 'Combina teoría online y práctica presencial.', 'image' => 'https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?auto=format&fit=crop&w=800&q=80'],
])->map(function ($course, $index) {
    return (object) array_merge($course, ['id' => $index + 1]);
});

$sampleUser = (object) [
    'id' => 1,
    'name' => 'Admin Printex',
    'email' => 'admin@printex.com',
    'phone' => '999 888 777',
    'role' => 'admin',
    'address' => 'Av. Industrial 123, Lima',
];

$sampleSuppliers = collect([
    (object) [
        'id' => 1,
        'name' => 'Proveedor Andino SAC',
        'ruc' => '20123456789',
        'contact' => 'Carla Ruiz',
        'email' => 'ventas@andinosac.com',
        'phone' => '987 654 321',
        'address' => 'Av. La Industria 456, Lima',
        'products' => 'Tintas, papeles y vinilos premium.',
    ],
    (object) [
        'id' => 2,
        'name' => 'Maquinas Pro',
        'ruc' => '20456789012',
        'contact' => 'Jorge Medina',
        'email' => 'contacto@maquinaspro.com',
        'phone' => '912 345 678',
        'address' => 'Jr. Producción 222, Lima',
        'products' => 'Planchas, prensas y repuestos.',
    ],
]);

$sampleCartItems = [
    [
        'product' => $sampleProducts->first(),
        'quantity' => 2,
    ],
];
$sampleSummary = [
    'subtotal' => collect($sampleCartItems)->sum(fn ($item) => $item['product']->price * $item['quantity']),
    'discount' => 0,
];
$sampleSummary['total'] = $sampleSummary['subtotal'] - $sampleSummary['discount'];

$sampleOrders = collect([
    (object) [
        'id' => 5001,
        'created_at' => now()->subDay(),
        'payment_method' => 'Yape',
        'status' => 'Pendiente',
        'total' => $sampleSummary['total'],
        'subtotal' => $sampleSummary['subtotal'],
        'discount' => $sampleSummary['discount'],
        'shipping_address' => $sampleUser->address,
        'user' => $sampleUser,
        'items' => [
            (object) [
                'product' => $sampleProducts->first(),
                'name' => $sampleProducts->first()->name,
                'quantity' => 2,
                'price' => $sampleProducts->first()->price,
            ],
        ],
    ],
    (object) [
        'id' => 5002,
        'created_at' => now()->subDays(3),
        'payment_method' => 'Visa',
        'status' => 'Entregado',
        'total' => 450.00,
        'subtotal' => 450.00,
        'discount' => 0,
        'shipping_address' => $sampleUser->address,
        'user' => $sampleUser,
        'items' => [
            (object) [
                'product' => $sampleProducts->get(2),
                'name' => $sampleProducts->get(2)->name,
                'quantity' => 5,
                'price' => $sampleProducts->get(2)->price,
            ],
        ],
    ],
]);

$sampleEnrollments = collect([
    (object) [
        'id' => 1,
        'status' => 'Activo',
        'created_at' => now()->subDays(5),
        'course_id' => 1,
        'course' => $sampleCourses->first(),
        'student_name' => $sampleUser->name,
        'student_email' => $sampleUser->email,
        'student_phone' => $sampleUser->phone,
        'student_address' => $sampleUser->address,
    ],
]);

$dashboardMetrics = [
    'sales' => $sampleOrders->sum('total'),
    'pending_orders' => $sampleOrders->where('status', 'Pendiente')->count(),
    'active_courses' => $sampleCourses->count(),
    'new_users' => 24,
];
$popularCourses = $sampleCourses->map(fn ($course) => [
    'name' => $course->name,
    'enrollments' => rand(10, 60),
]);

/**
 * Rutas públicas
 */
Route::view('/', 'home')->name('home');

Route::get('/products', function () use ($sampleProducts, $categories) {
    $perPage = 12;
    $page = request()->integer('page', 1);
    $paginated = new LengthAwarePaginator(
        $sampleProducts->forPage($page, $perPage)->values(),
        $sampleProducts->count(),
        $perPage,
        $page,
        ['path' => request()->url(), 'query' => request()->query()]
    );

    return view('products.index', [
        'products' => $paginated,
        'categories' => $categories,
    ]);
})->name('products.index');

Route::get('/products/{id}', function ($id) use ($sampleProducts) {
    $product = $sampleProducts->firstWhere('id', (int) $id) ?? $sampleProducts->first();
    $related = $sampleProducts->where('id', '!=', $product->id)->take(4)->values();

    return view('products.show', [
        'product' => $product,
        'relatedProducts' => $related,
    ]);
})->name('products.show');

Route::get('/courses', fn () => view('courses.index', ['courses' => $sampleCourses]))->name('courses.index');

Route::get('/courses/{id}', function ($id) use ($sampleCourses) {
    $course = $sampleCourses->firstWhere('id', (int) $id) ?? $sampleCourses->first();
    return view('courses.show', compact('course'));
})->name('courses.show');

Route::get('/cart', fn () => view('cart.index', [
    'cartItems' => $sampleCartItems,
    'summary' => $sampleSummary,
]))->name('cart.index');

Route::get('/checkout', fn () => view('checkout', [
    'cartItems' => $sampleCartItems,
    'summary' => $sampleSummary,
    'user' => $sampleUser,
]))->name('checkout');

Route::view('/about', 'about')->name('about');

Route::get('/profile/edit', fn () => view('profile.edit', ['user' => $sampleUser]))->name('profile.edit');

Route::get('/my-courses', fn () => view('my-courses.index', ['enrollments' => $sampleEnrollments]))->name('courses.my');

Route::get('/orders', fn () => view('orders.index', ['orders' => $sampleOrders]))->name('orders.index');

Route::get('/orders/{id}', function ($id) use ($sampleOrders) {
    $order = $sampleOrders->firstWhere('id', (int) $id) ?? $sampleOrders->first();
    return view('orders.show', compact('order'));
})->name('orders.show');

/**
 * Rutas panel admin (frontend)
 */
Route::get('/admin/dashboard', fn () => view('admin.dashboard', [
    'metrics' => $dashboardMetrics,
    'popularCourses' => $popularCourses,
]))->name('admin.dashboard');

// Productos admin
Route::get('/admin/products', fn () => view('admin.products.index', [
    'products' => $sampleProducts,
    'categories' => $categories,
]))->name('admin.products.index');

Route::get('/admin/products/create', fn () => view('admin.products.create', [
    'categories' => $categories,
]))->name('admin.products.create');

Route::get('/admin/products/{id}/edit', function ($id) use ($sampleProducts, $categories) {
    $product = $sampleProducts->firstWhere('id', (int) $id) ?? $sampleProducts->first();
    return view('admin.products.edit', compact('product', 'categories'));
})->name('admin.products.edit');

// Proveedores admin
Route::get('/admin/suppliers', fn () => view('admin.suppliers.index', [
    'suppliers' => $sampleSuppliers,
]))->name('admin.suppliers.index');

Route::view('/admin/suppliers/create', 'admin.suppliers.create')->name('admin.suppliers.create');

Route::get('/admin/suppliers/{id}/edit', function ($id) use ($sampleSuppliers) {
    $supplier = $sampleSuppliers->firstWhere('id', (int) $id) ?? $sampleSuppliers->first();
    return view('admin.suppliers.edit', compact('supplier'));
})->name('admin.suppliers.edit');

// Pedidos admin
Route::get('/admin/orders', fn () => view('admin.orders.index', [
    'orders' => $sampleOrders,
]))->name('admin.orders.index');

Route::get('/admin/orders/{id}', function ($id) use ($sampleOrders) {
    $order = $sampleOrders->firstWhere('id', (int) $id) ?? $sampleOrders->first();
    return view('admin.orders.show', compact('order'));
})->name('admin.orders.show');

// Cursos admin
Route::get('/admin/courses', fn () => view('admin.courses.index', [
    'courses' => $sampleCourses,
]))->name('admin.courses.index');

Route::view('/admin/courses/create', 'admin.courses.create')->name('admin.courses.create');

Route::get('/admin/courses/{id}/edit', function ($id) use ($sampleCourses) {
    $course = $sampleCourses->firstWhere('id', (int) $id) ?? $sampleCourses->first();
    return view('admin.courses.edit', compact('course'));
})->name('admin.courses.edit');

// Inscripciones admin
Route::get('/admin/enrollments', fn () => view('admin.enrollments.index', [
    'enrollments' => $sampleEnrollments,
]))->name('admin.enrollments.index');
